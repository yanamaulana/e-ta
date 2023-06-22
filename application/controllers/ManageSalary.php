<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ManageSalary extends CI_Controller
{
    private $layout             = 'layout';
    private $mst_work_status    = 'tmst_work_status';
    private $tbl_employee       = 'tbl_employee';
    private $tbl_account        = 'tbl_account';
    private $mst_jabatan        = 'tmst_jabatan';
    private $mst_salary         = 'tmst_salary';
    private $mst_bank           = 'tmst_bank';
    private $mst_tunjangan      = 'tmst_tunjangan';
    private $mst_mapel          = 'tmst_mata_pelajaran';
    private $mst_class          = 'tmst_kelas';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Manage Salary";
        $this->data['page_content'] = "ManageSalary/index";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/ManageSalary/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function Append_modal_update_salary()
    {
        $this->data['SysId'] = $this->input->get('SysId');
        $this->data['data'] = $this->db->get_where($this->tbl_employee, ['SysId' => $this->data['SysId']])->row();

        $this->data['works_status'] = $this->db->get_where($this->mst_work_status, ['Is_Active' => 1])->result();
        $this->data['jabatans'] = $this->db->get_where($this->mst_jabatan, ['is_active' => 1])->result();
        $this->data['salarys'] = $this->db->get_where($this->mst_salary, ['is_active' => 1])->result();
        $this->data['banks'] = $this->db->get_where($this->mst_bank, ['is_active' => 1])->result();

        $this->data['tunjangans'] = $this->db->get_where($this->mst_tunjangan, ['Pay_Type' => 'PER-BULAN', 'is_active' => 1])->result();

        $this->load->view('ManageSalary/m_update_salary', $this->data);
    }

    public function Store_Update_Employee_Salary()
    {
        $Stand_Hour = 1;
        if ($this->input->post('Stand_Hour') == null) {
            $Stand_Hour = 0;
        }
        $this->db->trans_start();
        $this->db->where('SysId', $this->input->post('SysId'));
        $this->db->update($this->tbl_employee, [
            'Fk_Salary' => $this->input->post('Fk_Salary'),
            'Fk_Tunjangan_Pokok' => $Stand_Hour,
            'Fk_Tunjangan_Jabatan_1' => $this->input->post('Fk_Tunjangan_Jabatan_1'),
            'Fk_Tunjangan_Jabatan_2' => $this->input->post('Fk_Tunjangan_Jabatan_2'),
            'Fk_Tunjangan_Jabatan_3' => $this->input->post('Fk_Tunjangan_Jabatan_3'),
            'Fk_Tunjangan_LainLain' => $this->input->post('Fk_Tunjangan_LainLain'),
            'Last_Updated_at' => date('Y-m-d H:i:s'),
            'Last_Updated_by' => $this->session->userdata('sys_username'),
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
                'msg' => 'Berhasil memperbarui data tunjangan !',
            ]);
        }
    }

    public function DT_List_Employee_Active()
    {
        $requestData = $_REQUEST;
        $columns = array(
            // 0 => 'SysId',
            0 => 'ID',
            1 => 'Nama',
            2 => 'Work_Status',
            3 => 'Jabatan',
            4 => 'Kode_Salary',
            5 => 'Nominal_Salary',
            6 => 'Tunjangan_Pokok',
            7 => 'Nominal_Tunjangan_Pokok',
            8 => 'Tunjangan_Jabatan_1',
            9 => 'Nominal_Tunjangan_Jabatan_1',
            10 => 'Tunjangan_Jabatan_2',
            11 => 'Nominal_Tunjangan_Jabatan_2',
            12 => 'Tunjangan_Jabatan_3',
            13 => 'Nominal_Tunjangan_Jabatan_3',
            14 => 'Label_Tunjangan_Lain',
            15 => 'Nominal_Tunjangan_Lain',
            16 => 'Bank',
            17 => 'No_Rekening',
            18 => 'KTP',
            19 => 'Telpon',
            20 => 'Email',
            21 => 'Gender',
            22 => 'Status_Pernikahan',
            23 => 'Tanggal_Join',
            24 => 'Full_address',
            25 => 'is_active',

        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * from qview_employee_active WHERE SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (ID LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Work_Status LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Jabatan LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Kode_Salary LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal_Salary LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tunjangan_Pokok LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal_Tunjangan_Pokok LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tunjangan_Lain LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tunjangan_Jabatan_1 LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tunjangan_Jabatan_2 LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tunjangan_Jabatan_3 LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal_Tunjangan_Lain LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Bank LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR No_Rekening LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR KTP LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Telpon LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Email LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Gender LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Status_Pernikahan LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tanggal_Join LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Full_address LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR is_active LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['ID'] = $row["ID"];
            $nestedData['Nama'] = $row["Nama"];
            $nestedData['Work_Status'] = $row["Work_Status"];
            $nestedData['Jabatan'] = $row["Jabatan"];
            $nestedData['Kode_Salary'] = $row["Kode_Salary"];
            $nestedData['Nominal_Salary'] = $this->help->format_idr($row["Nominal_Salary"]);
            $nestedData['Tunjangan_Pokok'] = $row["Tunjangan_Pokok"];
            $nestedData['Nominal_Tunjangan_Pokok'] = $this->help->format_idr($row["Nominal_Tunjangan_Pokok"]);
            $nestedData['Fk_Tunjangan_Jabatan_1'] = $row["Fk_Tunjangan_Jabatan_3"];
            $nestedData['Tunjangan_Jabatan_1'] = $row["Tunjangan_Jabatan_1"];
            $nestedData['Nominal_Tunjangan_Jabatan_1'] = $this->help->format_idr($row["Nominal_Tunjangan_Jabatan_1"]);
            $nestedData['Fk_Tunjangan_Jabatan_2'] = $row["Fk_Tunjangan_Jabatan_3"];
            $nestedData['Tunjangan_Jabatan_2'] = $row["Tunjangan_Jabatan_2"];
            $nestedData['Nominal_Tunjangan_Jabatan_2'] = $this->help->format_idr($row["Nominal_Tunjangan_Jabatan_2"]);
            $nestedData['Fk_Tunjangan_Jabatan_3'] = $row["Fk_Tunjangan_Jabatan_3"];
            $nestedData['Tunjangan_Jabatan_3'] = $row["Tunjangan_Jabatan_3"];
            $nestedData['Nominal_Tunjangan_Jabatan_3'] = $this->help->format_idr($row["Nominal_Tunjangan_Jabatan_3"]);
            $nestedData['Label_Tunjangan_Lain'] = $row["Label_Tunjangan_Lain"];
            $nestedData['Nominal_Tunjangan_Lain'] = $this->help->format_idr($row["Nominal_Tunjangan_Lain"]);
            $nestedData['Bank'] = $row["Bank"];
            $nestedData['No_Rekening'] = $row["No_Rekening"];
            $nestedData['KTP'] = $row["KTP"];
            $nestedData['Telpon'] = $row["Telpon"];
            $nestedData['Email'] = $row["Email"];
            $nestedData['Gender'] = $row["Gender"];
            $nestedData['Status_Pernikahan'] = $row["Status_Pernikahan"];
            $nestedData['Tanggal_Join'] = $row["Tanggal_Join"];
            $nestedData['Full_address'] = $row["Full_address"];
            $nestedData['is_active'] = $row["is_active"];

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
