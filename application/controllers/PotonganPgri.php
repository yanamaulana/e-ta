<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PotonganPgri extends CI_Controller
{
    public $layout                      = 'layout';
    private $tbl_employee               = 'tbl_employee';
    private $qview_payroll_cuts_pgri    = 'qview_payroll_cuts_pgri';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Potongan Keanggotaan PGRI";
        $this->data['page_content'] = "Potongan/pgri";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Potongan/pgri.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function DT_Potongan_karyawan()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => "SysId",
            1 => "ID",
            2 => "UserName",
            3 => "Nama",
            4 => "Nominal",
            5 => "Terbilang",
        );

        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * from $this->qview_payroll_cuts_pgri 
        Where SysId is not null ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (ID LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR UserName LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Terbilang LIKE '%" . $requestData['search']['value'] . "%')";
        }
        // $sql .= " GROUP BY a.sysid ,a.no_lot ";
        //----------------------------------------------------------------------------------
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";

        $totalFiltered = $this->db->query($sql)->num_rows();
        $query = $this->db->query($sql);
        $data = array();
        $no = 1;
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData["SysId"]                = $row["SysId"];
            $nestedData['ID']       = $row['ID'];
            $nestedData['UserName']       = $row['UserName'];
            $nestedData['Nama']       = $row['Nama'];
            $nestedData['Nominal']       = $row['Nominal'];
            $nestedData['Terbilang']       = $row['Terbilang'];

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
