<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SubmissionAttendance extends CI_Controller
{
    private $layout             = 'layout';
    private $trx_submission_att = 'ttrx_submission_attendance';
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
        $this->data['page_title'] = "Pengajuan Absensi";
        $this->data['page_content'] = "SubmissionAttendance/index";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/SubmissionAttendance/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function form_submission_attendance()
    {
        $this->data['page_title'] = "Form Submission Attendance";
        $this->data['page_content'] = "SubmissionAttendance/form_submission";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/SubmissionAttendance/form_submission.js"></script>';

        $this->data['Sql_Schedule'] = $this->db->get_where($this->hdr_schedule, [
            'Approve' => 1,
            'Is_Active' => 1,
            'Access_ID' => $this->session->userdata('sys_ID')
        ]);


        if ($this->data['Sql_Schedule']->num_rows() > 0) {
            $this->data['Hdr_Schedule'] = $this->data['Sql_Schedule']->row();
            $this->data['Dtl_Schedule'] = $this->db->get_where($this->dtl_schedule, ['Schedule_Number' => $this->data['Hdr_Schedule']->Schedule_Number])->result();
        }

        $this->load->view($this->layout, $this->data);
    }

    public function Store_New_SubmissionAttendance()
    {
        $Employee = $this->db->get_where($this->tbl_employee, ['ID' => $this->input->post('ID')])->row();
        $Schedule = $this->db->get_where($this->dtl_schedule, ['SysId' => $this->input->post('Schedule_ID')])->row();

        $day = date_format(date_create($this->input->post('Date_Att')), 'l');

        if ($Schedule->Day != $day) {
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => "Anda harus memilih tanggal dengan hari $Schedule->Day untuk absensi yang anda ajukan !",
            ]);
        }

        $ValidateRedundanAttTran = $this->db->get_where($this->att_trans, [
            'Access_ID'     => $this->input->post('ID'),
            'Schedule_ID'   => $this->input->post('Schedule_ID'),
            'Date_Att'      => $this->input->post('Date_Att')
        ]);
        if ($ValidateRedundanAttTran->num_rows() > 0) {
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => "Data yang anda ajukan telah terdaftar dalam system, anda mungkin melakukan absensi pada tanggal dan jadwal tersebut atau melakukan pengajuan dengan tanggal dan jadwal yang sama 2x !",
            ]);
        }

        $ValidateSubmission = $this->db->get_where($this->trx_submission_att, [
            'Access_ID'     => $this->input->post('ID'),
            'Schedule_ID'   => $this->input->post('Schedule_ID'),
            'Date_Att'      => $this->input->post('Date_Att')
        ]);
        if ($ValidateSubmission->num_rows() > 0) {
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => "The data you entered already exists in the attendance system !",
            ]);
        }

        $this->db->trans_start();
        $this->db->insert($this->trx_submission_att, [
            'Name'          => $this->input->post('Nama'),
            'Access_ID'     => $this->input->post('ID'),
            'Card'          => $this->input->post('Card'),
            'Att_DateTime'  => $this->input->post('Date_Att') . ' ' . $Schedule->Start_Time,
            'Date_Att'      => $this->input->post('Date_Att'),
            'Time_Att'      => $Schedule->Start_Time,
            'Schedule_ID'   => $this->input->post('Schedule_ID'),
            'Schedule_Number' => $Schedule->Schedule_Number,
            'Day'           => $Schedule->Day,
            'Kelas_ID'      => $Schedule->Kelas_ID,
            'Subject_ID'    => $Schedule->Subject_ID,
            'Time_Start'    => $Schedule->Start_Time,
            'Time_Over'     => $Schedule->Time_Over,
            'Stand_Hour'    => $Schedule->Stand_Hour,
            // 'Status',
            // 'Last_Status_by',
            // 'Last_Status_at',
            'Created_at'    => date('Y-m-d H:i:s'),
            'Created_by'    => $this->session->userdata('sys_username'),
            // 'Last_Updated_by',
            // 'Last_Updated_at'
        ]);

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
                'msg' => 'Berhasil menambahkan data pengajuan absensi !',
            ]);
        }
    }

    public function Delete_Submission()
    {
        $this->db->trans_start();
        $this->db->where('SysId', $this->input->post('SysId'));
        $this->db->delete($this->trx_submission_att);

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
                'msg' => 'Pengajuan absensi anda berhasil di hapus !',
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
            7 => 'Hari',
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

        $sql = "SELECT * from qview_submission_attendance WHERE Access_ID = '$ID' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Date_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Schedule_Number LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Card LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Hari LIKE '%" . $requestData['search']['value'] . "%' ";
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
            $nestedData['Hari'] = $row['Hari'];
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
            7 => 'Hari',
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

        $sql = "SELECT * from qview_submission_attendance_finish WHERE Access_ID = '$ID' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Date_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Schedule_Number LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Card LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Hari LIKE '%" . $requestData['search']['value'] . "%' ";
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
            $nestedData['Hari'] = $row['Hari'];
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
