<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MyAttendance extends CI_Controller
{
    public $layout          = 'layout';
    private $hdr_schedule   = 'ttrx_hdr_teaching_schedule';
    private $dtl_schedule   = 'ttrx_dtl_teaching_schedule';
    private $mst_mapel      = 'tmst_mata_pelajaran';
    private $tbl_employee   = 'tbl_employee';
    private $mst_class      = 'tmst_kelas';
    private $tbl_attendance = 'att_trans';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Absensi Saya";
        $this->data['page_content'] = "MyAttendance/index";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Monitoring/attendance.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function DT_Monitoring_Attendance()
    {
        $employee = $this->input->post('employee');
        $sql_employee = "";
        if (!empty($employee)) {
            $sql_employee = " AND A.Access_ID = $employee ";
        }

        $requestData = $_REQUEST;
        $columns = array(
            0 => "SysId",
            1 => "Name",
            2 => "Day",
            3 => "Kelas",
            4 => "Mata_Pelajaran",
            5 => "Time_Start",
            6 => "Time_Over",
            7 => "Date_Att",
            8 => "Time_Att",
            9 => "Stand_Hour",
            10 => "Card",
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];
        $from = $this->input->post('from');
        $until = $this->input->post('until');

        $sql = "SELECT A.SysId, A.Name, A.Access_ID, A.Card, A.Att_DateTime, A.Date_Att, A.Time_Att, A.IO, A.Schedule_ID, A.Schedule_Number, A.`Day`, A.Kelas_ID, B.Kelas, A.Subject_ID, 
        C.Mata_Pelajaran, A.Time_Start, A.Time_Over, A.Stand_Hour
        from $this->tbl_attendance AS A
        join $this->mst_class AS B on A.Kelas_ID = B.SysId
        join $this->mst_mapel AS C on A.Subject_ID = C.SysId 
        WHERE A.SysId IS NOT NULL $sql_employee
        AND DATE_FORMAT(A.Att_DateTime, '%Y-%m-%d') >= '$from'
        AND DATE_FORMAT(A.Att_DateTime, '%Y-%m-%d') <= '$until' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (A.Name LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR A.Day LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR B.Kelas LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR C.Mata_Pelajaran LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR A.Time_Start LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR A.Time_Over LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR A.Date_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR A.Time_Att LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR A.Stand_Hour LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR A.Card LIKE '%" . $requestData['search']['value'] . "%')";
        }
        // $sql .= " GROUP BY a.sysid ,a.no_lot ";
        //----------------------------------------------------------------------------------
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        // var_dump($sql);
        // die;
        $totalFiltered = $this->db->query($sql)->num_rows();
        $query = $this->db->query($sql);
        $data = array();
        $no = 1;
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['Name'] = $row["Name"];
            $nestedData['Day'] = $row["Day"];
            $nestedData['Kelas'] = $row["Kelas"];
            $nestedData['Mata_Pelajaran'] = $row["Mata_Pelajaran"];
            $nestedData['Time_Start'] = $row["Time_Start"];
            $nestedData['Time_Over'] = $row["Time_Over"];
            $nestedData['Date_Att'] = $row["Date_Att"];
            $nestedData['Time_Att'] = $row["Time_Att"];
            $nestedData['Stand_Hour'] = floatval($row["Stand_Hour"]);
            $nestedData['Card'] = $row["Card"];

            $data[] = $nestedData;
        }
        //----------------------------------------------------------------------------------
        $json_data = array(
            "draw"            => intval($requestData['draw']),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        //----------------------------------------------------------------------------------
        echo json_encode($json_data);
    }
}
