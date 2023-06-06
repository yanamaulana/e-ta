<?php

use PhpParser\Node\Stmt\Foreach_;

defined('BASEPATH') or exit('No direct script access allowed');

class CalculatePayroll extends CI_Controller
{
    private $layout             = 'layout';
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

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
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

        $DatePayFormat_Start = date("Y-m-d", strtotime($start));
        $DatePayFormat_End = date("Y-m-d", strtotime($end . ' + 1 day'));

        $begin = new DateTime($DatePayFormat_Start);
        $end = new DateTime($DatePayFormat_End);
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($begin, $interval, $end);

        // ============================ START Validation ============================//
        $ValidateSalary = $this->db->get_where($this->tmst_employee, [
            'Fk_Salary' => 0,
            'Fk_Tunjangan_Jabatan_1' => 1,
            'Fk_Tunjangan_Jabatan_2' => 1,
            'Fk_Tunjangan_Jabatan_3' => 1,
            'Fk_Tunjangan_LainLain' => 1

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
        WHERE Date_Att >= date_format('$DatePayFormat_Start','%Y-%m-%d')
        AND Date_Att <= date_format('$DatePayFormat_End','%Y-%m-%d')
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

        $TagID = 'PAY-' . $DatePayFormat_Start . 'SD' . $DatePayFormat_End . '/' . $this->help->Counter_Payroll_Number('Payroll_Doc_Number');
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
            ]);
            foreach ($period as $RawDate) {
                $date = $RawDate->format($format);
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

                $piket = $this->db->get_where($this->ttrx_payroll_guru_piket, ['ID' => $nik, 'Tanggal' => $date]);
                if ($piket->num_rows() > 0) {
                    $this->db->where('Tanggal', $date);
                    $this->db->where('ID', $nik);
                    $this->db->update($this->ttrx_payroll_guru_piket, [
                        'Calculated' => 1
                    ]);
                    $row_piket = $piket->row();
                    $Waktu_Piket = $row_piket->Waktu_Piket;
                    $Piket = floatval($row_piket->Nominal);
                } else {
                    $Waktu_Piket = NULL;
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

                $rapat = $this->db->query("SELECT SUM(Nominal_Tunjangan) as Nominal_Tunjangan, Meeting_Date, UserName FROM $this->qview_dtl_peserta_rapat 
                WHERE ID = $nik AND Meeting_Date = '$date' group by Meeting_Date, UserName");
                if ($rapat->num_rows() > 0) {
                    $row_rapat = $rapat->row();

                    $list_rapats = $this->db->get_where($this->qview_dtl_peserta_rapat, [
                        'ID' => $nik,
                        'Meeting_Date' => $date
                    ])->result();
                    foreach ($list_rapats as $list_rapat) {
                        $this->db->where('No_Meeting_Hdr', $list_rapat->No_Meeting_Hdr);
                        $this->db->where('UserName', $row_rapat->UserName);
                        $this->db->update($this->ttrx_dtl_peserta_rapat, [
                            'Calculated' => 1
                        ]);
                    }

                    $Rapat = floatval($row_rapat->Nominal_Tunjangan);
                } else {
                    $Rapat = 0;
                }

                $this->db->insert($this->ttrx_dtl_payroll, [
                    'TagID_PerNIK_Hdr' =>  $TagID . ':' . $nik,
                    'Tanggal' => $date,
                    'NIK' => $nik,
                    'Total_Hours' => $Sum_Stand_Hour,
                    'Total_Att' => $Total_Att,
                    'Tunjangan_Pokok' => $TunjanganPokok,
                    'Tunjangan_Lain' => $TunjanganLain,
                    'Waktu_Piket' => $Waktu_Piket,
                    'Upacara' => $Upacara,
                    'Jabatan_Upacara' => $Jabatan_Upacara,
                    'Piket' => $Piket,
                    'Jam_Lembur' => $Jam_Lembur,
                    'Lembur' => $Lembur,
                    'Rapat' => $Rapat
                ]);

                $this->db->where('Date_Att', $date);
                $this->db->where('Access_ID', $nik);
                $this->db->update($this->att_trans, [
                    'Calculated' => 1
                ]);
            }
        }
        // =============================== ttrx_event_payroll =============================== // 
        // TagID, Tot_Employee_Calculated, Tgl_Dari, Tgl_Sampai, Created_by, Created_at
        $this->db->insert('ttrx_event_payroll', [
            'TagID' => $TagID,
            'Tot_Employee_Calculated' =>  $TotEmploye,
            'Tgl_Dari' => $DatePayFormat_Start,
            'Tgl_Sampai' => $this->input->post('until'),
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
