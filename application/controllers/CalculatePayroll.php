<?php

use PhpParser\Node\Stmt\Foreach_;

defined('BASEPATH') or exit('No direct script access allowed');

class CalculatePayroll extends CI_Controller
{
    private $layout             = 'layout';
    private $date_time;
    private $tbl_employee       = 'qview_employee_active';
    private $tmst_employee      = 'tbl_employee';
    private $tbl_overtime       = 'ttrx_over_time';
    private $Qview_TTrx_Lembur  = 'qview_ttrx_lembur';

    private $ttrx_payroll_guru_piket = 'ttrx_payroll_guru_piket';
    private $ttrx_payroll_upacara = 'ttrx_payroll_upacara';
    private $qview_dtl_peserta_rapat = 'qview_dtl_peserta_rapat';
    private $ttrx_dtl_peserta_rapat = 'ttrx_dtl_peserta_rapat';
    private $tmst_other_payment = 'tmst_other_payment';
    private $PaymentCode = 'GURU_PIKET';

    private $ttrx_hdr_payroll       = 'ttrx_hdr_payroll';
    private $qview_employee_active  = 'qview_employee_active';
    private $att_trans  = 'att_trans';
    private $ttrx_over_time = 'ttrx_over_time';
    private $ttrx_dtl_payroll = 'ttrx_dtl_payroll';
    private $ttrx_event_payroll = 'ttrx_event_payroll';

    private $qview_mst_hdr_kasbon = 'qview_mst_hdr_kasbon';
    private $ttrx_dtl_transaksi_kasbon = 'ttrx_dtl_transaksi_kasbon';
    private $tmst_hdr_kasbon = 'tmst_hdr_kasbon';
    private $qview_payroll_cuts_pgri = 'qview_payroll_cuts_pgri';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->date_time = date("Y-m-d H:i:s");
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Calculate Payroll";
        $this->data['page_content'] = "Payroll/calculate";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Payroll/calculate.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function Generate_New_Payrol()
    {
        // ================================= Variableling ========================//
        $format = "Y-m-d";
        $start = $this->input->post('from');
        $end = $this->input->post('until');
        $niks = $this->input->post('IDs');
        $ID_Kasbons = $this->input->post('Kasbons');

        $DatePayFormat_Start = new DateTime($start);
        $DatePayFormat_End = new DateTime($end);

        // ============================ START Validation ============================//
        $ValidateSalary = $this->db->get_where($this->tmst_employee, [
            'Fk_Salary' => 0,
            'Fk_Tunjangan_Jabatan_1' => 0,
            'Fk_Tunjangan_Jabatan_2' => 0,
            'Fk_Tunjangan_Jabatan_3' => 0,
            'Fk_Tunjangan_LainLain' => 0
        ]);
        if ($ValidateSalary->num_rows() > 0) {
            $Data = '';
            foreach ($ValidateSalary->result() as $salary) {
                $Data .= "$salary->Nama <br/>";
            }

            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg' => "Beberapa karyawan belum memiliki nilai gaji & tunjangan : <br/> $Data"
            ]);
        }

        $ValidateCalculatedAtt = $this->db->query("SELECT * FROM $this->att_trans 
        WHERE Date_Att >= date_format('$start','%Y-%m-%d')
        AND Date_Att <= date_format('$end','%Y-%m-%d')
        AND Calculated = 1");

        if ($ValidateCalculatedAtt->num_rows() > 0) {
            $Data = '';
            foreach ($ValidateCalculatedAtt->result() as $att) {
                $Data .= "$att->Name Pada tanggal $att->Date_Att,<br>";
            }

            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg' => "Terjadi redudansi perhitungan : $Data , Calculate tidak dapat di lanjutkan !"
            ]);
        }
        // ============================ END Validation ============================//

        $TagID = 'PAY-' . $start . 'SD' . $end . '/' . $this->help->Counter_Payroll_Number('Payroll_Doc_Number');
        $TotEmploye = count($niks);

        $this->db->trans_start();
        foreach ($niks as $nik) {
            // =============================== ttrx_hdr_payroll ========================== //
            // TagID_Event, TagID_PerNIK, NIK, Gaji
            $karyawan = $this->db->get_where($this->qview_employee_active, ['ID' => $nik])->row();

            if ($this->input->post('include_gaji') == 1) {
                $gaji = floatval($karyawan->Nominal_Salary);
                $Include_Gaji = 1;
            } else {
                $gaji = 0;
                $Include_Gaji = 0;
            }

            if ($this->input->post('include_jabatan') == 1) {
                $Include_Tunjangan_Jabatan = 1;
                $Nominal_Tunjangan_Jabatan_1 = floatval($karyawan->Nominal_Tunjangan_Jabatan_1);
                $Nominal_Tunjangan_Jabatan_2 = floatval($karyawan->Nominal_Tunjangan_Jabatan_2);
                $Nominal_Tunjangan_Jabatan_3 = floatval($karyawan->Nominal_Tunjangan_Jabatan_3);
            } else {
                $Include_Tunjangan_Jabatan = 0;
                $Nominal_Tunjangan_Jabatan_1 = 0;
                $Nominal_Tunjangan_Jabatan_2 = 0;
                $Nominal_Tunjangan_Jabatan_3 = 0;
            }


            $SqlKasbon = $this->db->get_where($this->qview_mst_hdr_kasbon, ['ID' => $nik]);
            $Nominal_Angsuran_Kasbon = 0;
            $Include_Angsuran_Kasbon = 0;
            if (in_array($nik, $ID_Kasbons)) {
                $Include_Angsuran_Kasbon = 1;
                if ($SqlKasbon->num_rows() > 0) {
                    $RowKasbon = $SqlKasbon->row();
                    $Nominal_Angsuran_Kasbon = floatval($RowKasbon->Nominal_Angsuran);

                    $this->db->insert($this->ttrx_dtl_transaksi_kasbon, [
                        'ID' => $nik,
                        'Aritmatics' => '-',
                        'IN_OUT' => $Nominal_Angsuran_Kasbon,
                        'Saldo_Before' => floatval($RowKasbon->Saldo_Kasbon),
                        'Saldo_After' => floatval($RowKasbon->Saldo_Kasbon) - $Nominal_Angsuran_Kasbon,
                        'Remark_System' => "PAYROLL POTONGAN KASBON",
                        'Note' => '',
                        'Created_by' => $this->session->userdata('sys_username'),
                        'Created_at' => $this->date_time,
                        'Tag_Hdr' => $TagID . ':' . $nik,
                    ]);

                    $this->db->where('ID', $nik);
                    $this->db->update($this->tmst_hdr_kasbon, [
                        'Saldo_Kasbon' => floatval($RowKasbon->Saldo_Kasbon) - $Nominal_Angsuran_Kasbon,
                        'Last_Updated_by' => $this->session->userdata('sys_username'),
                        'Last_Updated_at' => $this->date_time
                    ]);
                }
            }

            $Nominal_Potongan_Keanggotaan_Pgri = 0;
            $SqlPgri = $this->db->get_where($this->qview_payroll_cuts_pgri, ['ID' => $nik]);
            if ($SqlPgri->num_rows > 0) {
                $RowPgri = $SqlPgri->row();
                $Nominal_Potongan_Keanggotaan_Pgri = floatval($RowPgri->Nominal);
            }

            $this->db->insert($this->ttrx_hdr_payroll, [
                'TagID_Event' =>  $TagID,
                'TagID_PerNIK' =>  $TagID . ':' . $nik,
                'NIK'   => $nik,
                'Include_Gaji' => $Include_Gaji,
                'Gaji'  => $gaji,
                'Jabatan' => $karyawan->Jabatan,
                'Label_Tunjangan_Pokok' => $karyawan->Tunjangan_Pokok,
                'Tunjangan_Pokok' => $karyawan->Nominal_Tunjangan_Pokok,
                'Include_Tunjangan_Jabatan' => $Include_Tunjangan_Jabatan,
                'Fk_Tunjangan_Jabatan_1' => $karyawan->Fk_Tunjangan_Jabatan_1,
                'Label_Tunjangan_Jabatan_1' => $karyawan->Tunjangan_Jabatan_1,
                'Tunjangan_Jabatan_1' => $Nominal_Tunjangan_Jabatan_1,
                'Fk_Tunjangan_Jabatan_2' => $karyawan->Fk_Tunjangan_Jabatan_2,
                'Label_Tunjangan_Jabatan_2' => $karyawan->Tunjangan_Jabatan_2,
                'Tunjangan_Jabatan_2' => $Nominal_Tunjangan_Jabatan_2,
                'Fk_Tunjangan_Jabatan_3' => $karyawan->Fk_Tunjangan_Jabatan_3,
                'Label_Tunjangan_Jabatan_3' => $karyawan->Tunjangan_Jabatan_3,
                'Tunjangan_Jabatan_3' => $Nominal_Tunjangan_Jabatan_3,
                'Label_Tunjangan_Lain' => $karyawan->Tunjangan_Lain,
                'Tunjangan_Lain' => $karyawan->Nominal_Tunjangan_Lain,
                'Include_Angsuran_Kasbon' => $Include_Angsuran_Kasbon,
                'Nominal_Angsuran_Kasbon' => $Nominal_Angsuran_Kasbon,
                'Nominal_Potongan_Keanggotaan_Pgri' => $Nominal_Potongan_Keanggotaan_Pgri
            ]);
            $currentDate = clone $DatePayFormat_Start;
            while ($currentDate <= $DatePayFormat_End) {
                $date = $currentDate->format($format);

                // ================================ ttrx_dtl_payroll ==================== //
                // SysId, TagID_PerNIK_Hdr, Tanggal, NIK, Total_Att, Total_Hours, Tunjangan_Pokok, Tunjangan_Lain, Jam_Lembur, Lembur
                $Att_Per_Day = $this->db->query("SELECT Access_ID, Date_Att, COALESCE(SUM(Stand_Hour),0) AS Sum_Stand_Hour, COALESCE(count(Stand_Hour),0) as Total_Att
                FROM $this->att_trans 
                WHERE Date_Att = '$date'
                AND Access_ID = $karyawan->ID
                group by Access_ID, Date_Att")->row();

                if (empty($Att_Per_Day)) {
                    $TunjanganPokok = 0;
                    $TunjanganLain  = 0;
                    $Sum_Stand_Hour = 0;
                    $Total_Att = 0;
                } else {
                    $TunjanganPokok = floatval($karyawan->Nominal_Tunjangan_Pokok) * floatval($Att_Per_Day->Sum_Stand_Hour);
                    $TunjanganLain  = 0;
                    $Sum_Stand_Hour = $Att_Per_Day->Sum_Stand_Hour;
                    $Total_Att = $Att_Per_Day->Total_Att;
                }

                $ot = $this->db->get_where($this->ttrx_over_time, ['ID' => $nik, 'Tanggal' => $date]);
                if ($ot->num_rows() > 0) {
                    $this->db->where('Tanggal', $date);
                    $this->db->where('ID', $nik);
                    $this->db->update($this->ttrx_over_time, [
                        'Calculated' => 1
                    ]);
                    $row_ot = $ot->row();
                    $Jam_Lembur = $row_ot->Jumlah_Jam;
                    $Lembur = floatval($row_ot->Nominal);
                } else {
                    $Jam_Lembur = 0;
                    $Lembur = 0;
                }

                $piket = $this->db->query("SELECT SUM(Nominal) as Nominal_Piket, COUNT(SysId) as Jumlah_Piket FROM $this->ttrx_payroll_guru_piket WHERE Tanggal = '$date' and ID = $nik GROUP BY ID, Tanggal");
                if ($piket->num_rows() > 0) {
                    $this->db->where('Tanggal', $date);
                    $this->db->where('ID', $nik);
                    $this->db->update($this->ttrx_payroll_guru_piket, [
                        'Calculated' => 1
                    ]);
                    $row_piket = $piket->row();
                    $Jumlah_Piket = $row_piket->Jumlah_Piket;
                    $Piket = floatval($row_piket->Nominal_Piket);
                } else {
                    $Jumlah_Piket = 0;
                    $Piket = 0;
                }

                $upacara = $this->db->get_where($this->ttrx_payroll_upacara, ['ID' => $nik, 'Tanggal' => $date]);
                if ($upacara->num_rows() > 0) {
                    $this->db->where('Tanggal', $date);
                    $this->db->where('ID', $nik);
                    $this->db->update($this->ttrx_payroll_upacara, [
                        'Calculated' => 1
                    ]);
                    $row_upacara = $upacara->row();
                    $Jabatan_Upacara = $row_upacara->Jabatan_Upacara;
                    $Upacara = floatval($row_upacara->Nominal);
                } else {
                    $Jabatan_Upacara = NULL;
                    $Upacara = 0;
                }

                $rapat = $this->db->query("SELECT SUM(Nominal_Tunjangan) as Nominal_Tunjangan, COUNT(SysId) as Jumlah_Rapat, Meeting_Date, UserName FROM $this->qview_dtl_peserta_rapat 
                WHERE ID = $nik AND Meeting_Date = '$date' and Approve_Leader = 1 and Approve_Admin = 1 group by Meeting_Date, UserName");
                if ($rapat->num_rows() > 0) {
                    $row_rapat = $rapat->row();

                    $list_rapats = $this->db->get_where($this->qview_dtl_peserta_rapat, [
                        'Meeting_Date' => $date,
                        'ID' => $nik,
                        'Approve_Leader' => 1,
                        'Approve_Admin' => 1
                    ])->result();
                    foreach ($list_rapats as $list_rapat) {
                        $this->db->where('No_Meeting_Hdr', $list_rapat->No_Meeting_Hdr);
                        $this->db->where('UserName', $row_rapat->UserName);
                        $this->db->update($this->ttrx_dtl_peserta_rapat, [
                            'Calculated' => 1
                        ]);
                    }

                    $Rapat = floatval($row_rapat->Nominal_Tunjangan);
                    $Jumlah_Rapat = $row_rapat->Jumlah_Rapat;
                } else {
                    $Rapat = 0;
                    $Jumlah_Rapat = 0;
                }

                $this->db->insert($this->ttrx_dtl_payroll, [
                    'TagID_PerNIK_Hdr'  =>  $TagID . ':' . $nik,
                    'Tanggal'           => $date,
                    'NIK'               => $nik,
                    'Total_Hours'       => $Sum_Stand_Hour,
                    'Total_Att'         => $Total_Att,
                    'Tunjangan_Pokok'   => $TunjanganPokok,
                    'Tunjangan_Lain'    => $TunjanganLain,
                    'Upacara'           => $Upacara,
                    'Jabatan_Upacara'   => $Jabatan_Upacara,
                    'Jumlah_Piket'      => $Jumlah_Piket,
                    'Piket'             => $Piket,
                    'Jam_Lembur'        => $Jam_Lembur,
                    'Lembur'            => $Lembur,
                    'Jumlah_Rapat'      => $Jumlah_Rapat,
                    'Rapat'             => $Rapat
                ]);

                $this->db->where('Date_Att', $date);
                $this->db->where('Access_ID', $nik);
                $this->db->update($this->att_trans, [
                    'Calculated' => 1
                ]);

                $currentDate->modify('+1 day');
            }
        }
        // =============================== ttrx_event_payroll =============================== // 
        // TagID, Tot_Employee_Calculated, Tgl_Dari, Tgl_Sampai, Created_by, Created_at
        $this->db->insert('ttrx_event_payroll', [
            'TagID' => $TagID,
            'Tot_Employee_Calculated' =>  $TotEmploye,
            'Tgl_Dari' => $start,
            'Tgl_Sampai' => $end,
            'Created_by' => $this->session->userdata('sys_username'),
        ]);
        // ============ END QUERY
        $error_msg = $this->db->error()["message"];
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => $error_msg,
            ]);
        } else {
            $this->db->trans_commit();
            return $this->help->Fn_resulting_response([
                'code' => 200,
                'msg' => 'Successfully Calculated Payroll, check calculate result at history !',
            ]);
        }
    }
}
