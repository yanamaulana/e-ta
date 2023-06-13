<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApprovalSchedule extends CI_Controller
{
    public $layout          = 'layout';
    private $hdr_schedule   = 'ttrx_hdr_teaching_schedule';
    private $dtl_schedule   = 'ttrx_dtl_teaching_schedule';
    private $qview_schedule_all   = 'qview_schedule_all';
    private $qview_hdr_schedule_all   = 'qview_hdr_schedule_all';
    private $view_schedule_approval = 'qview_hdr_schedule_need_approval';
    private $mst_mapel   = 'tmst_mata_pelajaran';
    private $mst_class   = 'tmst_kelas';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Approval Jadwal Mengajar";
        $this->data['page_content'] = "Schedule/schedule_approval";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Schedule/schedule_approval.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function Approve_Schedule()
    {
        $SysId = $this->input->post('SysId');
        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->update($this->hdr_schedule, [
            'Approve' => 1,
            'Is_Active' => 1,
            'Approve_Time' => date('Y-m-d H:i:s'),
            'Approve_By' => $this->session->userdata('sys_username')
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
                'msg' => 'Successfully approve schedule !',
            ]);
        }
    }

    public function Reject_Schedule()
    {
        $SysId = $this->input->post('SysId');
        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->update($this->hdr_schedule, [
            'Approve' => 2,
            'Is_Active' => 2,
            'Approve_Time' => date('Y-m-d H:i:s'),
            'Approve_By' => $this->session->userdata('sys_username')
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
                'msg' => 'Successfully approve schedule !',
            ]);
        }
    }

    public function Preview_Schedule()
    {
        // qview_schedule_all
        $this->data['Hdr'] = $this->db->get_where($this->qview_hdr_schedule_all, ['SysId' => $this->input->get('SysId')])->row();
        $this->data['Dtls'] = $this->db->get_where($this->qview_schedule_all, ['SysId_Hdr' => $this->input->get('SysId')])->result();

        return $this->load->view('Schedule/m_detail_schedule', $this->data);
    }

    public function DT_list_schedule_need_Approval()
    {

        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'Schedule_Number',
            2 => 'Nama',
            3 => 'Jabatan',
            4 => 'Work_Status',
            5 => 'Date_create',
            6 => 'Approve',

        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * from $this->view_schedule_approval WHERE SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Schedule_Number LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Access_ID LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Gender LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Jabatan LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Date_create LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Work_Status LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['Schedule_Number'] = $row['Schedule_Number'];
            $nestedData['Employee_ID'] = $row['Employee_ID'];
            $nestedData['Access_ID'] = $row['Access_ID'];
            $nestedData['UserName'] = $row['UserName'];
            $nestedData['Nama'] = $row['Nama'];
            $nestedData['Gender'] = $row['Gender'];
            $nestedData['Jabatan'] = $row['Jabatan'];
            $nestedData['Kode_Jabatan'] = $row['Kode_Jabatan'];
            $nestedData['Work_Status'] = $row['Work_Status'];
            $nestedData['Approve'] = $row['Approve'];
            $nestedData['Date_create'] = $row['Date_create'];

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
