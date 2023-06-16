<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HistoryPayroll extends CI_Controller
{
    private $layout                     = 'layout';
    private $tmst_other_payment         = 'tmst_other_payment';
    private $ttrx_over_time             = 'ttrx_over_time';
    private $ttrx_payroll_guru_piket    = 'ttrx_payroll_guru_piket';
    private $ttrx_hdr_payroll           = 'ttrx_hdr_payroll';
    private $qview_employee_active      = 'qview_employee_active';
    private $qview_payroll_hdr_karyawan = 'qview_payroll_hdr_karyawan';
    private $att_trans                  = 'att_trans';
    private $ttrx_dtl_payroll           = 'ttrx_dtl_payroll';
    private $ttrx_event_payroll         = 'ttrx_event_payroll';
    private $ttrx_payroll_upacara       = 'ttrx_payroll_upacara';
    private $qview_mst_hdr_kasbon_all   = 'qview_mst_hdr_kasbon_all';
    private $ttrx_dtl_transaksi_kasbon  = 'ttrx_dtl_transaksi_kasbon';
    private $tmst_hdr_kasbon            = 'tmst_hdr_kasbon';
    private $qview_dtl_peserta_rapat    = 'qview_dtl_peserta_rapat';
    private $ttrx_dtl_peserta_rapat     = 'ttrx_dtl_peserta_rapat';

    private $date_time;
    private $PaymentCode_Piket = 'GURU_PIKET';
    private $PaymentCode_Rapat = 'K_RAPAT';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->date_time = date("Y-m-d H:i:s");
        $this->load->model('m_helper', 'help');
        $this->load->model('m_history', 'history');
        $this->load->model('m_DataTable', 'M_Datatables');
    }

    public function index()
    {
        $this->data['page_title'] = "History Payroll";
        $this->data['page_content'] = "Payroll/history_payroll";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Payroll/history_payroll.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function delete_event_payroll($SysId)
    {
        $event = $this->db->get_where($this->ttrx_event_payroll, ['SysId' => $SysId]);
        $row_event = $event->row();

        $hdr = $this->db->get_where($this->ttrx_hdr_payroll, ['TagID_Event' => $row_event->TagID]);
        $row_hdr = $hdr->result();

        $this->db->trans_start();
        $this->history->Hst_Event_Payroll($row_event, 'DELETE');
        foreach ($row_hdr as $li) {
            if ($li->Include_Angsuran_Kasbon == 1) {
                $ValidateKasbonTrue = $this->db->order_by('SysId', 'DESC')->get_where($this->ttrx_dtl_transaksi_kasbon, ['Tag_Hdr' => $li->TagID_PerNIK]);
                if ($ValidateKasbonTrue->num_rows() > 0) {
                    $RowKasbon = $this->db->get_where($this->qview_mst_hdr_kasbon_all, ['ID' => $li->NIK])->row();
                    $this->db->insert($this->ttrx_dtl_transaksi_kasbon, [
                        'ID' => $li->NIK,
                        'Aritmatics' => '+',
                        'IN_OUT' => floatval($li->Nominal_Angsuran_Kasbon),
                        'Saldo_Before' => floatval($RowKasbon->Saldo_Kasbon),
                        'Saldo_After' => floatval($RowKasbon->Saldo_Kasbon) + floatval($li->Nominal_Angsuran_Kasbon),
                        'Remark_System' => 'DELETE PAYROLL ROLLBACK KASBON',
                        'Note' => '',
                        'Created_by' => $this->session->userdata('sys_username'),
                        'Created_at' => $this->date_time,
                        'Tag_Hdr' => $li->TagID_PerNIK,
                    ]);

                    $this->db->where('ID', $li->NIK);
                    $this->db->update($this->tmst_hdr_kasbon, [
                        'Saldo_Kasbon' => floatval($RowKasbon->Saldo_Kasbon) + floatval($li->Nominal_Angsuran_Kasbon),
                        'Last_Updated_by' => $this->session->userdata('sys_username'),
                        'Last_Updated_at' => $this->date_time
                    ]);
                }
            }
            $this->history->History_Hdr_Payroll($li, 'DELETE');
            $detail = $this->db->get_where($this->ttrx_dtl_payroll, ['TagID_PerNIK_Hdr' => $li->TagID_PerNIK]);
            foreach ($detail->result() as $dtl) {
                $lembur = $this->db->get_where($this->ttrx_over_time, ['Tanggal' => $dtl->Tanggal, 'ID' => $dtl->NIK]);
                if ($lembur->num_rows() > 0) {
                    $this->db->where('Tanggal', $dtl->Tanggal);
                    $this->db->where('ID', $dtl->NIK);
                    $this->db->update($this->ttrx_over_time, ['Calculated' => 0]);
                }

                $piket  = $this->db->get_where($this->ttrx_payroll_guru_piket, ['Tanggal' => $dtl->Tanggal, 'ID' => $dtl->NIK]);
                if ($piket->num_rows() > 0) {
                    $this->db->where('Tanggal', $dtl->Tanggal);
                    $this->db->where('ID', $dtl->NIK);
                    $this->db->update($this->ttrx_payroll_guru_piket, ['Calculated' => 0]);
                }

                $upacara  = $this->db->get_where($this->ttrx_payroll_upacara, ['Tanggal' => $dtl->Tanggal, 'ID' => $dtl->NIK]);
                if ($upacara->num_rows() > 0) {
                    $this->db->where('Tanggal', $dtl->Tanggal);
                    $this->db->where('ID', $dtl->NIK);
                    $this->db->update($this->ttrx_payroll_upacara, ['Calculated' => 0]);
                }

                $upacara  = $this->db->get_where($this->ttrx_payroll_upacara, ['Tanggal' => $dtl->Tanggal, 'ID' => $dtl->NIK]);
                if ($upacara->num_rows() > 0) {
                    $this->db->where('Tanggal', $dtl->Tanggal);
                    $this->db->where('ID', $dtl->NIK);
                    $this->db->update($this->ttrx_payroll_upacara, ['Calculated' => 0]);
                }

                $att_trans = $this->db->get_where($this->att_trans, ['Date_Att' => $dtl->Tanggal, 'Access_ID' => $dtl->NIK]);
                if ($att_trans->num_rows() > 0) {
                    $this->db->where('Date_Att', $dtl->Tanggal);
                    $this->db->where('Access_ID', $dtl->NIK);
                    $this->db->update($this->att_trans, [
                        'Calculated' => 0
                    ]);
                }

                $rapats = $this->db->get_where($this->qview_dtl_peserta_rapat, [
                    'Meeting_Date' => $dtl->Tanggal,
                    'ID' => $dtl->NIK,
                    'Approve_Leader' => 1,
                    'Approve_Admin' => 1
                ]);
                if ($rapats->num_rows() > 0) {
                    $list_rapats = $rapats->result();
                    foreach ($list_rapats as $list_rapat) {
                        $this->db->where('No_Meeting_Hdr', $list_rapat->No_Meeting_Hdr);
                        $this->db->where('UserName', $list_rapat->UserName);
                        $this->db->update($this->ttrx_dtl_peserta_rapat, [
                            'Calculated' => 0,
                        ]);
                    }
                }
            }
            $this->db->delete($this->ttrx_dtl_payroll, ['TagID_PerNIK_Hdr' => $li->TagID_PerNIK]);
        }
        $this->db->delete($this->ttrx_hdr_payroll, ['TagID_Event' => $row_event->TagID]);
        $this->db->delete($this->ttrx_event_payroll, ['SysId' => $SysId]);

        $error_msg = $this->db->error()["message"];
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => $error_msg,
            ]);
        } else {
            $this->db->trans_commit();
            return $this->help->Fn_resulting_response([
                'code' => 200,
                'msg' => 'Data Calculate Payroll successfully deleted !',
            ]);
        }
    }

    public function Event_Payroll_DataTable()
    {
        $tables = $this->ttrx_event_payroll;
        $search = ['SysId', 'TagID', 'Tot_Employee_Calculated', 'Tgl_Dari', 'Tgl_Sampai', 'Created_by', 'Payment_Status'];
        $isWhere = null;
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables($tables, $search, $isWhere);
    }

    public function Hdr_Payroll_DataTable()
    {
        $TagID = $this->input->post('TagID');
        $tables = "qview_payroll_hdr_karyawan";
        $search = array('TagID_PerNIK', 'NIK', 'Nama', 'Work_Status', 'Jabatan');
        $where  = array('TagID_Event' => $TagID);
        $isWhere = null;
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_where($tables, $search, $where, $isWhere);
    }

    public function change_status_event_payroll($sysid)
    {
        $this->db->trans_start();

        $this->db->where('SysId', $sysid);
        $this->db->update($this->ttrx_event_payroll, [
            'Payment_Status' => 1,
            'Payment_Status_Change_By' => $this->session->userdata('sys_username'),
            'Payment_Status_Change_at' => date('Y-m-d H:i:s')
        ]);

        $error_msg = $this->db->error()["message"];
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => $error_msg,
            ]);
        } else {
            $this->db->trans_commit();
            return $this->help->Fn_resulting_response([
                'code' => 200,
                'msg' => 'Data Kalkulasi Berhasil dinyatakan paid !',
            ]);
        }
    }

    public function Print_Event($sysid_event)
    {
        $this->data['Event']  = $this->db->get_where($this->ttrx_event_payroll, ['SysId' => $sysid_event])->row();
        $this->data['Hdrs']   = $this->db->get_where('qview_payroll_hdr_karyawan', ['TagID_Event' => $this->data['Event']->TagID])->result();
        $this->data['identity'] = $this->db->get_where('tmst_school_identity', ['Code' => 'School_Identity_For_Payroll'])->row();

        $this->data['Payment_Piket'] = $this->db->get_where($this->tmst_other_payment, [
            'Code' => $this->PaymentCode_Piket
        ])->row();

        $this->data['Payment_Rapat'] = $this->db->get_where($this->tmst_other_payment, [
            'Code' => $this->PaymentCode_Rapat
        ])->row();

        $this->load->view('Payroll/R_event', $this->data);
    }

    public function Report_hdr($sysid)
    {
        $this->data['Payment_Piket'] = $this->db->get_where($this->tmst_other_payment, [
            'Code' => $this->PaymentCode_Piket
        ])->row();

        $this->data['Payment_Rapat'] = $this->db->get_where($this->tmst_other_payment, [
            'Code' => $this->PaymentCode_Rapat
        ])->row();

        $this->data['Hdrs']   = $this->db->get_where('qview_payroll_hdr_karyawan', ['SysId' => $sysid])->result();

        $this->data['Event']  = $this->db->get_where($this->ttrx_event_payroll, ['TagID' => $this->data['Hdrs'][0]->TagID_Event])->row();

        $this->data['identity'] = $this->db->get_where('tmst_school_identity', ['Code' => 'School_Identity_For_Payroll'])->row();

        $this->load->view('Payroll/R_event', $this->data);
    }


    public function recalculate($sysid)
    {
        $format = "Y-m-d";

        $event = $this->db->get_where($this->ttrx_event_payroll, ['SysId' => $sysid])->row();
        $this->history->Hst_Event_Payroll($event, 'RECALCULATE');
        $start = $event->Tgl_Dari;
        $end = $event->Tgl_Sampai;

        $DatePayFormat_Start = new DateTime($start);
        $DatePayFormat_End = new DateTime($end);

        $hdr = $this->db->get_where($this->ttrx_hdr_payroll, ['TagID_Event' => $event->TagID])->result();

        $this->db->trans_start();
        foreach ($hdr as $li_hdr) {
            $this->db->delete($this->ttrx_dtl_payroll, ['TagID_PerNIK_Hdr' => $li_hdr->TagID_PerNIK]);
        }

        foreach ($hdr as $row) {
            // =============================== ttrx_hdr_payroll ========================== //
            $nik = $row->NIK;
            $karyawan = $this->db->get_where($this->qview_employee_active, ['ID' => $nik])->row();
            $currentDate = clone $DatePayFormat_Start;

            if ($row->Include_Angsuran_Kasbon == 1) {
                $RowAngsuranPayroll = $this->db->order_by('SysId', 'DESC')->get_where($this->ttrx_dtl_transaksi_kasbon, ['Tag_Hdr' => $row->TagID_PerNIK]);
                if ($RowAngsuranPayroll->num_rows() > 0) {
                    $RowAngsuranPayroll = $RowAngsuranPayroll->row();
                    $RowHdrKasbon = $this->db->get_where($this->qview_mst_hdr_kasbon_all, ['ID' => $nik])->row();
                    if ($RowAngsuranPayroll->IN_OUT != $RowHdrKasbon->Nominal_Angsuran) {

                        $this->history->History_Hdr_Payroll($row, 'RECALCULATE KASBON');
                        $this->history->Hst_Transaksi_Kasbon($RowAngsuranPayroll, 'AKSI CALCULATE : PERUBAHAN TRANSAKSI ANGSURAN, KARNA MASTER ANGSURAN KASBON TELAH BERUBAH');


                        $this->db->where('SysId', $RowAngsuranPayroll->SysId);
                        $this->db->update($this->ttrx_dtl_transaksi_kasbon, [
                            'IN_OUT' => floatval($RowHdrKasbon->Nominal_Angsuran),
                            'Saldo_Before' => floatval($RowAngsuranPayroll->Saldo_Before),
                            'Saldo_After' => floatval($RowAngsuranPayroll->Saldo_Before) - floatval($RowHdrKasbon->Nominal_Angsuran),
                            'Note' => 'TELAH RECALCULATE'
                        ]);
                        $this->db->where('ID', $nik);
                        $this->db->update('tmst_hdr_kasbon', [
                            'Saldo_Kasbon' => floatval($RowAngsuranPayroll->Saldo_Before) - floatval($RowHdrKasbon->Nominal_Angsuran),
                            'Last_Updated_by' => $this->date_time,
                            'Last_Updated_at' => $this->session->userdata('sys_username')
                        ]);
                        $this->db->where('TagID_PerNIK', $row->TagID_PerNIK);
                        $this->db->update($this->ttrx_hdr_payroll, [
                            'Nominal_Angsuran_Kasbon' => floatval($RowHdrKasbon->Nominal_Angsuran)
                        ]);
                    }
                }
            }

            while ($currentDate <= $DatePayFormat_End) {
                $date = $currentDate->format($format);

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
                $Jam_Lembur = 0;
                $Lembur = 0;
                if ($ot->num_rows() > 0) {
                    $row_ot = $ot->row();
                    $Jam_Lembur = $row_ot->Jumlah_Jam;
                    $Lembur = $row_ot->Nominal;
                }

                $piket = $this->db->query("SELECT SUM(Nominal) as Nominal_Piket, COUNT(SysId) as Jumlah_Piket FROM $this->ttrx_payroll_guru_piket WHERE Tanggal = '$date' and ID = $nik GROUP BY ID, Tanggal");
                $Jumlah_Piket = 0;
                $Piket = 0;
                if ($piket->num_rows() > 0) {
                    $row_piket = $piket->row();
                    $Jumlah_Piket = $row_piket->Jumlah_Piket;
                    $Piket = floatval($row_piket->Nominal_Piket);
                }

                $upacara = $this->db->get_where($this->ttrx_payroll_upacara, ['ID' => $nik, 'Tanggal' => $date]);
                $Jabatan_Upacara = NULL;
                $Upacara = 0;
                if ($upacara->num_rows() > 0) {
                    $row_upacara = $upacara->row();
                    $Jabatan_Upacara = $row_upacara->Jabatan_Upacara;
                    $Upacara = floatval($row_upacara->Nominal);
                }

                $rapat = $this->db->query("SELECT SUM(Nominal_Tunjangan) as Nominal_Tunjangan, COUNT(SysId) as Jumlah_Rapat, Meeting_Date, UserName FROM $this->qview_dtl_peserta_rapat 
                WHERE ID = $nik AND Meeting_Date = ' $date' and Approve_Leader = 1 and Approve_Admin = 1 group by Meeting_Date, UserName");
                $Rapat = 0;
                $Jumlah_Rapat = 0;
                if ($rapat->num_rows() > 0) {
                    $row_rapat = $rapat->row();
                    $Rapat = floatval($row_rapat->Nominal_Tunjangan);
                    $Jumlah_Rapat = $row_rapat->Jumlah_Rapat;
                }

                $this->db->insert($this->ttrx_dtl_payroll, [
                    'TagID_PerNIK_Hdr' =>  $row->TagID_PerNIK,
                    'Tanggal' => $date,
                    'NIK' => $nik,
                    'Total_Hours' => $Sum_Stand_Hour,
                    'Total_Att' => $Total_Att,
                    'Tunjangan_Pokok' => $TunjanganPokok,
                    'Tunjangan_Lain' => $TunjanganLain,
                    'Upacara' => $Upacara,
                    'Jabatan_Upacara' => $Jabatan_Upacara,
                    'Jumlah_Piket' => $Jumlah_Piket,
                    'Piket' => $Piket,
                    'Jam_Lembur' => $Jam_Lembur,
                    'Lembur' => $Lembur,
                    'Jumlah_Rapat' => $Jumlah_Rapat,
                    'Rapat' => $Rapat
                ]);

                $currentDate->modify('+1 day');
            }
        }
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
                'msg' => "Recalculate $event->TagID berhasil di lakukan !"
            ]);
        }
    }

    public function AppendModal_Dtl_Payroll()
    {
        $this->data['TagID_PerNIK'] = $this->input->post('TagID_PerNIK');

        $this->data['Hdr'] = $this->db->get_where('qview_payroll_hdr_karyawan', ['TagID_PerNIK' => $this->input->post('TagID_PerNIK')])->row();
        $this->data['Dtls'] = $this->db->get_where('qview_ttrx_dtl_payroll', ['TagID_PerNIK_Hdr' => $this->input->post('TagID_PerNIK')])->result();

        return $this->load->view('payroll/M_detail_payroll', $this->data);
    }

    public function Hdr_Payroll_DataTable_Paycheck()
    {
        $NIK = $this->input->post('NIK');
        $tables = $this->qview_payroll_hdr_karyawan;
        $search = array('SysId', 'TagID_PerNIK', 'NIK', 'Nama', 'Jabatan', 'Payment_Status', 'Tgl_Dari', 'Tgl_Sampai');
        $where  = array('NIK' => $NIK);
        $isWhere = null;
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_where($tables, $search, $where, $isWhere);
    }
}
