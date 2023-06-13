<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApprovalAttendance extends CI_Controller
{
    private $layout             = 'layout';
    private $trx_submission_att = 'ttrx_submission_attendance';
    private $hst_submission_att = 'thst_trx_submission_attendance';
    private $tbl_employee       = 'qview_employee_active';
    private $tbl_account        = 'tbl_account';
    private $mst_jabatan        = 'tmst_jabatan';
    private $mst_salary         = 'tmst_salary';
    private $mst_bank           = 'tmst_bank';
    private $mst_tunjangan      = 'tmst_tunjangan';
    private $mst_mapel          = 'tmst_mata_pelajaran';
    private $mst_class          = 'tmst_kelas';
    private $hdr_schedule       = 'ttrx_hdr_teaching_schedule';
    private $dtl_schedule       = 'qview_schedule_active';
    private $att_trans          = 'att_trans';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Approval Pengajuan Absensi";
        $this->data['page_content'] = "ApprovalAttendance/index";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/ApprovalAttendance/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function Approve_Submission()
    {
        $Arr_SysId = $this->input->post('SysId');

        $this->db->trans_start();

        foreach ($Arr_SysId as $SysId) {
            $RowSubss = $this->db->get_where($this->trx_submission_att, ['SysId' => $SysId])->row();

            $this->db->insert($this->hst_submission_att, [
                'SysId' => $SysId,
                'Name' => $RowSubss->Name,
                'Access_ID' => $RowSubss->Access_ID,
                'Card' => $RowSubss->Card,
                'Att_DateTime' => $RowSubss->Att_DateTime,
                'Date_Att' => $RowSubss->Date_Att,
                'Time_Att' => $RowSubss->Time_Att,
                'IO' => $RowSubss->IO,
                'Schedule_ID' => $RowSubss->Schedule_ID,
                'Schedule_Number' => $RowSubss->Schedule_Number,
                'Day' => $RowSubss->Day,
                'Kelas_ID' => $RowSubss->Kelas_ID,
                'Subject_ID' => $RowSubss->Subject_ID,
                'Time_Start' => $RowSubss->Time_Start,
                'Time_Over' => $RowSubss->Time_Over,
                'Stand_Hour' => $RowSubss->Stand_Hour,
                'Status' => '1',
                'Last_Status_by' => $this->session->userdata('sys_username'),
                'Last_Status_at' => date('Y-m-d H:i:s'),
                'Created_by' =>  $RowSubss->Created_by,
                'Created_at' =>  $RowSubss->Created_at,
                'Last_Updated_by' => $RowSubss->Last_Updated_by,
                'Last_Updated_at' => $RowSubss->Last_Updated_at,
            ]);

            $this->db->insert($this->att_trans, [
                'Name' => $RowSubss->Name,
                'Access_ID' => $RowSubss->Access_ID,
                'Card' => $RowSubss->Card,
                'Att_DateTime' => $RowSubss->Att_DateTime,
                'Date_Att' => $RowSubss->Date_Att,
                'Time_Att' => $RowSubss->Time_Att,
                'IO' => $RowSubss->IO,
                'Schedule_ID' => $RowSubss->Schedule_ID,
                'Schedule_Number' => $RowSubss->Schedule_Number,
                'Day' => $RowSubss->Day,
                'Kelas_ID' => $RowSubss->Kelas_ID,
                'Subject_ID' => $RowSubss->Subject_ID,
                'Time_Start' => $RowSubss->Time_Start,
                'Time_Over' => $RowSubss->Time_Over,
                'Stand_Hour' => $RowSubss->Stand_Hour,
                'Created_by' => $RowSubss->Created_by,
                'Last_Updated_at' => date('Y-m-d H:i:s')
            ]);

            $this->db->delete($this->trx_submission_att, ['SysId' => $SysId]);
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
                'msg' => 'Successfully approve submission attendance !',
            ]);
        }
    }

    public function Reject_Submission()
    {
        $Arr_SysId = $this->input->post('SysId');

        $this->db->trans_start();

        foreach ($Arr_SysId as $SysId) {
            $RowSubss = $this->db->get_where($this->trx_submission_att, ['SysId' => $SysId])->row();

            $this->db->insert($this->hst_submission_att, [
                'SysId' => $SysId,
                'Name' => $RowSubss->Name,
                'Access_ID' => $RowSubss->Access_ID,
                'Card' => $RowSubss->Card,
                'Att_DateTime' => $RowSubss->Att_DateTime,
                'Date_Att' => $RowSubss->Date_Att,
                'Time_Att' => $RowSubss->Time_Att,
                'IO' => $RowSubss->IO,
                'Schedule_ID' => $RowSubss->Schedule_ID,
                'Schedule_Number' => $RowSubss->Schedule_Number,
                'Day' => $RowSubss->Day,
                'Kelas_ID' => $RowSubss->Kelas_ID,
                'Subject_ID' => $RowSubss->Subject_ID,
                'Time_Start' => $RowSubss->Time_Start,
                'Time_Over' => $RowSubss->Time_Over,
                'Stand_Hour' => $RowSubss->Stand_Hour,
                'Status' => '2',
                'Last_Status_by' => $this->session->userdata('sys_username'),
                'Last_Status_at' => date('Y-m-d H:i:s'),
                'Created_by' =>  $RowSubss->Created_by,
                'Created_at' =>  $RowSubss->Created_at,
                'Last_Updated_by' => $RowSubss->Last_Updated_by,
                'Last_Updated_at' => $RowSubss->Last_Updated_at,
            ]);

            $this->db->delete($this->trx_submission_att, ['SysId' => $SysId]);
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
                'msg' => 'Successfully Reject submission attendance !',
            ]);
        }
    }

    public function DT_List_Submission()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'Name',
            2 => 'Access_ID',
            3 => 'Card',
            4 => 'Date_Att',
            5 => 'Time_Att',
            6 => 'Schedule_Number',
            7 => 'Day',
            8 => 'Kelas',
            9 => 'Mata_Pelajaran',
            10 => 'Time_Start',
            11 => 'Time_Over',
            12 => 'Stand_Hour',
            13 => 'Status'

        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];
        $ID = $this->session->userdata('sys_ID');

        $sql = "SELECT * from qview_submission_attendance where SysId is not null ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Date_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Schedule_Number LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Card LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Day LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Kelas LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Stand_Hour LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Start LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Over LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Mata_Pelajaran LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row['SysId'];
            $nestedData['Name'] = $row['Name'];
            $nestedData['Access_ID'] = $row['Access_ID'];
            $nestedData['Card'] = $row['Card'];
            $nestedData['Date_Att'] = $row['Date_Att'];
            $nestedData['Time_Att'] = $row['Time_Att'];
            $nestedData['Schedule_Number'] = $row['Schedule_Number'];
            $nestedData['Day'] = $row['Day'];
            $nestedData['Kelas'] = $row['Kelas'];
            $nestedData['Mata_Pelajaran'] = $row['Mata_Pelajaran'];
            $nestedData['Time_Start'] = $row['Time_Start'];
            $nestedData['Time_Over'] = $row['Time_Over'];
            $nestedData['Stand_Hour'] = floatval($row['Stand_Hour']);
            $nestedData['Status'] = $row['Status'];

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

    public function DT_List_History_Submission()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'Name',
            2 => 'Access_ID',
            3 => 'Card',
            4 => 'Date_Att',
            5 => 'Time_Att',
            6 => 'Schedule_Number',
            7 => 'Day',
            8 => 'Kelas',
            9 => 'Mata_Pelajaran',
            10 => 'Time_Start',
            11 => 'Time_Over',
            12 => 'Stand_Hour',
            13 => 'Status'

        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];
        $ID = $this->session->userdata('sys_ID');

        $sql = "SELECT * from qview_submission_attendance_finish WHERE SysId is not null ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Date_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Schedule_Number LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Card LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Day LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Kelas LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Stand_Hour LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Start LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Over LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Mata_Pelajaran LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row['SysId'];
            $nestedData['Name'] = $row['Name'];
            $nestedData['Access_ID'] = $row['Access_ID'];
            $nestedData['Card'] = $row['Card'];
            $nestedData['Date_Att'] = $row['Date_Att'];
            $nestedData['Time_Att'] = $row['Time_Att'];
            $nestedData['Schedule_Number'] = $row['Schedule_Number'];
            $nestedData['Day'] = $row['Day'];
            $nestedData['Kelas'] = $row['Kelas'];
            $nestedData['Mata_Pelajaran'] = $row['Mata_Pelajaran'];
            $nestedData['Time_Start'] = $row['Time_Start'];
            $nestedData['Time_Over'] = $row['Time_Over'];
            $nestedData['Stand_Hour'] = floatval($row['Stand_Hour']);
            $nestedData['Status'] = $row['Status'];

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
