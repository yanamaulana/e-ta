<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HistoryPayroll extends CI_Controller
{
    private $layout             = 'layout';
    private $date_time;
    private $tbl_employee       = 'qview_employee_active';
    private $tbl_overtime       = 'ttrx_over_time';
    private $Qview_TTrx_Lembur  = 'qview_ttrx_lembur';

    private $tmst_other_payment         = 'tmst_other_payment';
    private $PaymentCode_Piket                = 'GURU_PIKET';
    private $PaymentCode_Rapat                = 'K_RAPAT';

    private $ttrx_over_time = 'ttrx_over_time';
    private $ttrx_payroll_guru_piket = 'ttrx_payroll_guru_piket';

    private $ttrx_hdr_payroll       = 'ttrx_hdr_payroll';
    private $qview_employee_active  = 'qview_employee_active';
    private $att_trans  = 'att_trans';
    private $ttrx_dtl_payroll = 'ttrx_dtl_payroll';
    private $ttrx_event_payroll = 'ttrx_event_payroll';
    private $ttrx_payroll_upacara = 'ttrx_payroll_upacara';

    private $qview_dtl_peserta_rapat = 'qview_dtl_peserta_rapat';
    private $ttrx_dtl_peserta_rapat = 'ttrx_dtl_peserta_rapat';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->date_time = date("Y-m-d H:i:s");
        $this->load->model('m_helper', 'help');
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
        $this->db->insert('thst_deleted_event_payroll', [
            'SysId' => $row_event->SysId,
            'TagID' => $row_event->TagID,
            'Tot_Employee_Calculated' => $row_event->Tot_Employee_Calculated,
            'Tgl_Dari' => $row_event->Tgl_Dari,
            'Tgl_Sampai' => $row_event->Tgl_Sampai,
            'Payment_Status' => $row_event->Payment_Status,
            'Payment_Status_Change_at' => $row_event->Payment_Status_Change_at,
            'Payment_Status_Change_By' => $row_event->Payment_Status_Change_By,
            'Created_by' => $row_event->Created_by,
            'Created_at' => $row_event->Created_at,
            'deleted_by' => $this->session->userdata('sys_username')
        ]);
        foreach ($row_hdr as $li) {
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
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            2 => 'TagID',
            3 => 'Tot_Employee_Calculated',
            4 => 'Tgl_Dari',
            5 => 'Tgl_Sampai',
            6 => 'Created_by',
            7 => 'Payment_Status',

        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * from ttrx_event_payroll WHERE SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (TagID LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tot_Employee_Calculated LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tgl_Dari LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tgl_Sampai LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Created_by LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['TagID'] = $row["TagID"];
            $nestedData['Tot_Employee_Calculated'] = $row["Tot_Employee_Calculated"];
            $nestedData['Tgl_Dari'] = $row["Tgl_Dari"];
            $nestedData['Tgl_Sampai'] = $row["Tgl_Sampai"];
            $nestedData['Payment_Status'] = $row["Payment_Status"];
            $nestedData['Created_by'] = $row["Created_by"];
            $nestedData['Created_at'] = $row["Created_at"];

            $data[] = $nestedData;
        }
        //----------------------------------------------------------------------------------
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );
        //----------------------------------------------------------------------------------
        echo json_encode($json_data);
    }

    public function Hdr_Payroll_DataTable()
    {
        $TagID = $this->input->post('TagID');
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'TagID_PerNIK',
            2 => 'NIK',
            3 => 'Nama',
            4 => 'Work_Status',
            5 => 'Jabatan',
            6 => 'is_active',
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * from qview_payroll_hdr_karyawan WHERE TagID_Event  = '$TagID' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (TagID_PerNIK LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR NIK LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Work_Status LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Jabatan LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['TagID_Event'] = $row["TagID_Event"];
            $nestedData['TagID_PerNIK'] = $row["TagID_PerNIK"];
            $nestedData['NIK'] = $row["NIK"];
            $nestedData['Nama'] = $row["Nama"];
            $nestedData['Jabatan'] = $row["Jabatan"];
            $nestedData['Work_Status'] = $row["Work_Status"];
            $nestedData['is_active'] = $row["is_active"];
            $nestedData['Tgl_Dari'] = $row["Tgl_Dari"];
            $nestedData['Tgl_Sampai'] = $row["Tgl_Sampai"];
            $nestedData['Payment_Status'] = $row["Payment_Status"];

            $data[] = $nestedData;
        }
        //----------------------------------------------------------------------------------
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );
        //----------------------------------------------------------------------------------
        echo json_encode($json_data);
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

        $start = $event->Tgl_Dari;
        $end = $event->Tgl_Sampai;

        $DatePayFormat_Start = new DateTime($start);
        $DatePayFormat_End = new DateTime($end);
        // $currentDate = clone $DatePayFormat_Start;

        $hdr = $this->db->get_where($this->ttrx_hdr_payroll, ['TagID_Event' => $event->TagID])->result();

        $this->db->trans_start();
        foreach ($hdr as $li_hdr) {
            $detail = $this->db->get_where($this->ttrx_dtl_payroll, ['TagID_PerNIK_Hdr' => $li_hdr->TagID_PerNIK]);
            foreach ($detail->result() as $li) {
                $lembur = $this->db->get_where($this->ttrx_over_time, ['Tanggal' => $li->Tanggal, 'ID' => $li->NIK]);
                if ($lembur->num_rows() > 0) {
                    $this->db->where('Tanggal', $li->Tanggal);
                    $this->db->where('ID', $li->Tanggal);
                    $this->db->update($this->ttrx_over_time, ['Calculated' => 0]);
                }
            }
            $this->db->delete($this->ttrx_dtl_payroll, ['TagID_PerNIK_Hdr' => $li_hdr->TagID_PerNIK]);
        }

        foreach ($hdr as $row) {
            // =============================== ttrx_hdr_payroll ========================== //
            $nik = $row->NIK;
            $karyawan = $this->db->get_where($this->qview_employee_active, ['ID' => $nik])->row();
            $currentDate = clone $DatePayFormat_Start;
            while ($currentDate <= $DatePayFormat_End) {
                $date = $currentDate->format($format);

                $Att_Per_Day = $this->db->query("SELECT Access_ID, Date_Att, COALESCE(SUM(Stand_Hour),0) AS Sum_Stand_Hour, COALESCE(count(Stand_Hour),0) as Total_Att
                FROM $this->att_trans 
                WHERE Date_Att = '$date'
                AND Access_ID = $karyawan->ID
                group by Access_ID, Date_Att")->row();

                if (empty($Att_Per_Day)) {
                    $TunjanganPokok = 0;
                    // $TunjanganJabatan = 0;
                    $TunjanganLain  = 0;
                    $Sum_Stand_Hour = 0;
                    $Total_Att = 0;
                } else {
                    $TunjanganPokok = floatval($karyawan->Nominal_Tunjangan_Pokok) * floatval($Att_Per_Day->Sum_Stand_Hour);
                    // $TunjanganJabatan  = floatval($karyawan->Nominal_Tunjangan_Jabatan) * 1;
                    $TunjanganLain  = floatval($karyawan->Nominal_Tunjangan_Lain) * 1;
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
                    $Lembur = $row_ot->Nominal;
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
                WHERE ID = $nik AND Meeting_Date = ' $date' and Approve_Leader = 1 and Approve_Admin = 1 group by Meeting_Date, UserName");
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

                $this->db->where('Date_Att', $date);
                $this->db->where('Access_ID', $nik);
                $this->db->update($this->att_trans, [
                    'Calculated' => 1
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
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'TagID_PerNIK',
            2 => 'NIK',
            3 => 'Nama',
            4 => 'Work_Status',
            5 => 'Jabatan',
            6 => 'Payment_Status',
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * from qview_payroll_hdr_karyawan WHERE NIK  = '$NIK' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (TagID_PerNIK LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR NIK LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Work_Status LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Jabatan LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['TagID_Event'] = $row["TagID_Event"];
            $nestedData['TagID_PerNIK'] = $row["TagID_PerNIK"];
            $nestedData['NIK'] = $row["NIK"];
            $nestedData['Nama'] = $row["Nama"];
            $nestedData['Jabatan'] = $row["Jabatan"];
            $nestedData['Work_Status'] = $row["Work_Status"];
            $nestedData['Payment_Status'] = $row["is_active"];
            $nestedData['Tgl_Dari'] = $row["Tgl_Dari"];
            $nestedData['Tgl_Sampai'] = $row["Tgl_Sampai"];
            $nestedData['Payment_Status'] = $row["Payment_Status"];

            $data[] = $nestedData;
        }
        //----------------------------------------------------------------------------------
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );
        //----------------------------------------------------------------------------------
        echo json_encode($json_data);
    }
}
