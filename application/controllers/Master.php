<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    private $layout = 'layout';
    private $mst_work_status = 'tmst_work_status';
    private $tbl_employee    = 'tbl_employee';
    private $tbl_account     = 'tbl_account';
    private $mst_jabatan     = 'tmst_jabatan';
    private $mst_salary      = 'tmst_salary';
    private $mst_bank        = 'tmst_bank';
    private $mst_tunjangan   = 'tmst_tunjangan';
    private $mst_mapel       = 'tmst_mata_pelajaran';
    private $mst_class      = 'tmst_kelas';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Master Data";
        $this->data['page_content'] = "Master/index";
        $this->data['script_page'] =  '';

        $this->load->view($this->layout, $this->data);
    }

    public function Toggle_status_general()
    {
        $SysId = $this->input->post('SysId');
        $Table = $this->input->post('TabelData');


        $RowData = $this->db->get_where($Table, ['SysId' => $SysId])->row();

        if ($RowData->is_active == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $this->db->trans_start();
        $this->db->where('SysId', $SysId);
        $this->db->update($Table, [
            'is_active' => $status
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
                'msg' => 'Successfully change activation status !',
            ]);
        }
    }

    // ============================= EMPLOYEE =============================//
    public function index_employee()
    {
        $this->data['page_title'] = "Master Data Employee";
        $this->data['page_content'] = "Master/Employee/index";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/Employee/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function select_employee_active()
    {
        $search = $this->input->get('search');
        $query = $this->db->query(
            "SELECT ID, Nama from qview_employee_active where is_active = 1 and nama like '%$search%'"
        );

        if ($query->num_rows() > 0) {
            $list = array();
            $key = 1;
            foreach ($query->result_array() as $row) {
                $list[$key]['id'] = $row['ID'];
                $list[$key]['text'] = $row['Nama'];
                $key++;
            }
            echo json_encode($list);
        } else {
            echo "hasil kosong";
        }
    }

    public function Add_Employee()
    {
        $this->data['page_title'] = "Add New Employee";
        $this->data['page_content'] = "Master/Employee/form_new_employee";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/Employee/form_new_employee.js"></script>';

        $this->data['works_status'] = $this->db->get_where($this->mst_work_status, ['Is_Active' => 1])->result();
        $this->data['jabatans'] = $this->db->get_where($this->mst_jabatan, ['is_active' => 1])->result();
        $this->data['salarys'] = $this->db->get_where($this->mst_salary, ['is_active' => 1])->result();
        $this->data['banks'] = $this->db->get_where($this->mst_bank, ['is_active' => 1])->result();
        $this->data['tunjangans'] = $this->db->get_where($this->mst_tunjangan, ['is_active' => 1])->result();

        $this->load->view($this->layout, $this->data);
    }

    public function Store_New_Employee()
    {
        $ValidateID = $this->db->get_where($this->tbl_account, ['ID' => $this->input->post('ID')]);
        if ($ValidateID->num_rows() > 0) {
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => "ID Access Control has been taken by other user !",
            ]);
        }

        $ValidateUname = $this->db->get_where($this->tbl_account, ['UserName' => $this->input->post('UserName')]);
        if ($ValidateUname->num_rows() > 0) {
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => "Username has been taken by other user !",
            ]);
        }

        $this->db->trans_start();
        $this->db->insert($this->tbl_employee, [
            'ID' => $this->input->post('ID'),
            'UserName' => $this->input->post('UserName'),
            'Nama' => ucwords(strtolower($this->input->post('Nama'))),
            'Fk_Work_Status' => $this->input->post('Fk_Work_Status'),
            'Fk_Jabatan' => $this->input->post('Fk_Jabatan'),
            'Fk_Salary' => 0,
            'Fk_Bank' => $this->input->post('Fk_Bank'),
            'Fk_Tunjangan_Pokok' => 1,
            'Fk_Tunjangan_Jabatan' => 1,
            'Fk_Tunjangan_LainLain' => 1,
            'KTP' => $this->input->post('KTP'),
            'Tanggal_Lahir' => $this->input->post('Tanggal_Lahir'),
            'Tempat_Lahir' => strtoupper($this->input->post('Tempat_Lahir')),
            'Gender' => $this->input->post('Gender'),
            'Telpon' => $this->input->post('Telpon'),
            'No_Rekening' => $this->input->post('No_Rekening'),
            'Email' => $this->input->post('Email'),
            'Status_Pernikahan' => $this->input->post('Status_Pernikahan'),
            'Tanggal_Join' => $this->input->post('Tanggal_Join'),
            'Full_address' => $this->input->post('Full_address'),
            'Created_at' => date('Y-m-d H:i:s'),
            'Created_by' => $this->session->userdata('sys_username'),
        ]);

        $this->db->insert($this->tbl_account, [
            'ID' => $this->input->post('ID'),
            'Nama' =>  ucwords(strtolower($this->input->post('Nama'))),
            'UserName' => $this->input->post('UserName'),
            'Password' => md5(date('Ymd', strtotime($this->input->post('Tanggal_Lahir')))),
            'Role' => 'USER',
            'Telpon' => $this->input->post('Telpon'),
            'Email' => $this->input->post('Email'),
            'Created_at' => date('Y-m-d H:i:s'),
            'Created_by' => $this->session->userdata('sys_username'),
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
                'msg' => 'Successfully insert new records !',
            ]);
        }
    }

    public function Store_Update_Employee()
    {
        $this->db->trans_start();
        $this->db->where('SysId', $this->input->post('SysId'));
        $this->db->update($this->tbl_employee, [
            'Nama' => ucwords(strtolower($this->input->post('Nama'))),
            'Fk_Work_Status' => $this->input->post('Fk_Work_Status'),
            'Fk_Jabatan' => $this->input->post('Fk_Jabatan'),
            // 'Fk_Salary' => $this->input->post('Fk_Salary'),
            'Fk_Bank' => $this->input->post('Fk_Bank'),
            // 'Fk_Tunjangan_Pokok' => $this->input->post('Fk_Tunjangan_Pokok'),
            // 'Fk_Tunjangan_LainLain' => $this->input->post('Fk_Tunjangan_LainLain'),
            'KTP' => $this->input->post('KTP'),
            'Tanggal_Lahir' => $this->input->post('Tanggal_Lahir'),
            'Tempat_Lahir' => strtoupper($this->input->post('Tempat_Lahir')),
            'Gender' => $this->input->post('Gender'),
            'Telpon' => $this->input->post('Telpon'),
            'No_Rekening' => $this->input->post('No_Rekening'),
            'Email' => $this->input->post('Email'),
            'Status_Pernikahan' => $this->input->post('Status_Pernikahan'),
            'Tanggal_Join' => $this->input->post('Tanggal_Join'),
            'Full_address' => $this->input->post('Full_address'),
            'Last_Updated_at' => date('Y-m-d H:i:s'),
            'Last_Updated_by' => $this->session->userdata('sys_username'),
        ]);

        $this->db->where('ID', $this->input->post('ID'));
        $this->db->update($this->tbl_account, [
            'Nama' => ucwords(strtolower($this->input->post('Nama'))),
            'Telpon' => $this->input->post('Telpon'),
            'Email' => $this->input->post('Email'),
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
                'msg' => 'Successfully update records data !',
            ]);
        }
    }

    public function Append_modal_update_employee()
    {
        $this->data['SysId'] = $this->input->get('SysId');
        $this->data['data'] = $this->db->get_where($this->tbl_employee, ['SysId' => $this->data['SysId']])->row();

        $this->data['works_status'] = $this->db->get_where($this->mst_work_status, ['Is_Active' => 1])->result();
        $this->data['jabatans'] = $this->db->get_where($this->mst_jabatan, ['is_active' => 1])->result();
        $this->data['salarys'] = $this->db->get_where($this->mst_salary, ['is_active' => 1])->result();
        $this->data['banks'] = $this->db->get_where($this->mst_bank, ['is_active' => 1])->result();
        $this->data['tunjangans'] = $this->db->get_where($this->mst_tunjangan, ['is_active' => 1])->result();

        $this->load->view('Master/Employee/m_update_employee', $this->data);
    }

    public function Change_Password()
    {
        $this->data['page_title'] = "Change My Password";
        $this->data['page_content'] = "Master/Employee/change_password";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/Employee/change_password.js"></script>';

        $this->data['user'] = $this->db->get_where($this->tbl_employee, ['Is_Active' => 1, 'UserName' => $this->session->userdata('sys_username')])->row();


        $this->load->view($this->layout, $this->data);
    }

    public function Store_Change_Password()
    {
        $Account = $this->db->get_where($this->tbl_account, ['UserName' => $this->input->post('UserName')])->row();
        $old_pw = $this->input->post('old_password');
        $new_pw = $this->input->post('new_password1');
        $new_pw_rpt = $this->input->post('new_password2');
        $UserName = $this->input->post('UserName');

        if ($Account->Password != md5($old_pw)) {
            return $this->help->Fn_resulting_response([
                'code' => 500,
                'msg' => 'Wrong Password, Please correct your current password !'
            ]);
        }

        if ($new_pw != $new_pw_rpt) {
            return $this->help->Fn_resulting_response([
                'code' => 500,
                'msg' => 'Please Repeat your new password correctly !'
            ]);
        }

        $this->db->trans_start();

        $this->db->where('UserName', $UserName);
        $this->db->update($this->tbl_account, [
            'Password' => md5($new_pw_rpt),
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
                'msg' => 'Your Password has change !',
            ]);
        }
    }

    public function Toggle_status_employee()
    {
        $SysId = $this->input->post('SysId');
        $employee = $this->db->get_where($this->tbl_employee, ['SysId' => $SysId])->row();

        if ($employee->is_active == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        $this->db->trans_start();
        $this->db->where('SysId', $SysId);
        $this->db->update($this->tbl_employee, [
            'is_active' => $status
        ]);

        $this->db->where('ID', $employee->ID);
        $this->db->update($this->tbl_account, [
            'is_active' => $status
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
                'msg' => 'Successfully change activation status !',
            ]);
        }
    }

    public function DT_List_Employee_All()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'ID',
            2 => 'Nama',
            3 => 'Work_Status',
            4 => 'Jabatan',
            5 => 'Kode_Salary',
            6 => 'Nominal_Salary',
            7 => 'Tunjangan_Pokok',
            8 => 'Nominal_Tunjangan_Pokok',
            9 => 'Tunjangan_Lain',
            10 => 'Nominal_Tunjangan_Lain',
            11 => 'Bank',
            12 => 'No_Rekening',
            13 => 'KTP',
            14 => 'Telpon',
            15 => 'Email',
            16 => 'Gender',
            17 => 'Status_Pernikahan',
            18 => 'Tanggal_Join',
            19 => 'Full_address',
            20 => 'is_active',

        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * from qview_employee_all WHERE SysId is not null";

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
            $nestedData['Tunjangan_Lain'] = $row["Tunjangan_Lain"];
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

    public function DT_List_Employee_Active()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'ID',
            2 => 'Nama',
            3 => 'Work_Status',
            4 => 'Jabatan',
            5 => 'Kode_Salary',
            6 => 'Nominal_Salary',
            7 => 'Tunjangan_Pokok',
            8 => 'Nominal_Tunjangan_Pokok',
            9 => 'Tunjangan_Lain',
            10 => 'Nominal_Tunjangan_Lain',
            11 => 'Bank',
            12 => 'No_Rekening',
            13 => 'KTP',
            14 => 'Telpon',
            15 => 'Email',
            16 => 'Gender',
            17 => 'Status_Pernikahan',
            18 => 'Tanggal_Join',
            19 => 'Full_address',
            20 => 'is_active',

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
            $nestedData['UserName'] = $row["UserName"];
            $nestedData['Work_Status'] = $row["Work_Status"];
            $nestedData['Jabatan'] = $row["Jabatan"];
            $nestedData['Kode_Salary'] = $row["Kode_Salary"];
            $nestedData['Nominal_Salary'] = $this->help->format_idr($row["Nominal_Salary"]);
            $nestedData['Tunjangan_Pokok'] = $row["Tunjangan_Pokok"];
            $nestedData['Nominal_Tunjangan_Pokok'] = $this->help->format_idr($row["Nominal_Tunjangan_Pokok"]);
            $nestedData['Tunjangan_Lain'] = $row["Tunjangan_Lain"];
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

    // ======================== END EMPLOYEE ==============================//
    // ======================== BEGIN SUBJECT ==============================//
    public function index_subjects()
    {
        $this->data['page_title'] = "Master Data Subjects";
        $this->data['page_content'] = "Master/Subjects/index";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/Subjects/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function DT_List_Subjects_All()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'Mata_Pelajaran',
            2 => 'Kode_Mapel',
            3 => 'is_active',
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * from $this->mst_mapel WHERE SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Mata_Pelajaran LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Kode_Mapel LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['Mata_Pelajaran'] = $row["Mata_Pelajaran"];
            $nestedData['Kode_Mapel'] = $row["Kode_Mapel"];
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

    public function Store_New_Subjects()
    {
        $ValidateCode = $this->db->get_where($this->mst_mapel, ['Kode_Mapel' => $this->input->post('Kode_Mapel')]);
        if ($ValidateCode->num_rows() > 0) {
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => "Subjects code already taken !",
            ]);
        }

        $this->db->trans_start();

        $this->db->insert($this->mst_mapel, [
            'Mata_Pelajaran' => ucfirst($this->input->post('Mata_Pelajaran')),
            'Kode_Mapel' => strtoupper($this->input->post('Kode_Mapel')),
            'is_active' => 1,
            'Created_at' => date('Y-m-d H:i:s'),
            'Created_by' => $this->session->userdata('sys_username'),
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
                'msg' => 'Successfully insert new records !',
            ]);
        }
    }
    //============================= BEGIN SUBJECT ==================================//
    public function index_class()
    {
        $this->data['page_title'] = "Master Data Class";
        $this->data['page_content'] = "Master/Class/index";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/Class/index.js"></script>';

        $this->data['Teachers'] = $this->db->get_where('qview_employee_all', ['is_active' => 1])->result();

        $this->load->view($this->layout, $this->data);
    }

    public function Store_New_Class()
    {
        $ValidateClass = $this->db->get_where($this->mst_class, ['Kelas' => $this->input->post('Kelas')]);
        if ($ValidateClass->num_rows() > 0) {
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => "Class name already taken !",
            ]);
        }

        $this->db->trans_start();

        $this->db->insert($this->mst_class, [
            'Kelas' => ucfirst($this->input->post('Kelas')),
            'Employe_ID_Wali_Kelas' => $this->input->post('Employe_ID_Wali_Kelas'),
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('sys_username'),
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
                'msg' => 'Successfully insert new records !',
            ]);
        }
    }

    public function DT_List_Class()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'class.SysId',
            1 => 'class.Kelas',
            2 => 'employee.Nama',
            3 => 'class.is_active'
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT class.* , employee.Nama
                from $this->mst_class as class
                LEFT JOIN $this->tbl_employee as employee on class.Employe_ID_Wali_Kelas = employee.SysId 
                WHERE class.SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (class.Kelas LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR employee.Nama LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['Kelas'] = $row["Kelas"];
            $nestedData['Nama'] = $row["Nama"];
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

    public function Append_modal_update_homeroom_teacher()
    {
        $SysId = $this->input->get('SysId');

        $this->data['class'] = $this->db->get_where($this->mst_class, ['SysId' => $SysId])->row();
        $this->data['Teachers'] = $this->db->get_where('qview_employee_all', ['is_active' => 1])->result();

        $this->load->view('Master/Class/m_update_homeroom', $this->data);
    }

    public function Store_Update_Homeroom_Teacher()
    {
        $this->db->trans_start();
        $this->db->where('SysId', $this->input->post('SysId'));
        $this->db->update($this->mst_class, [
            'Employe_ID_Wali_Kelas' => $this->input->post('Employe_ID_Wali_Kelas'),
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
                'msg' => 'Successfully update records data !',
            ]);
        }
    }

    //=================================== Office Position ============================//

    public function index_office_position()
    {
        $this->data['page_title'] = "Master Office Position";
        $this->data['page_content'] = "Master/OfficePosition/index";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/OfficePosition/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function DT_List_Office_Position()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'Jabatan',
            2 => 'Kode_Jabatan',
            3 => 'is_active'
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * FROM $this->mst_jabatan
                WHERE SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Jabatan LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Kode_Jabatan LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['Jabatan'] = $row["Jabatan"];
            $nestedData['Kode_Jabatan'] = $row["Kode_Jabatan"];
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

    public function Store_New_Office_Position()
    {
        $ValidateOfficePositionCode = $this->db->get_where($this->mst_jabatan, ['Kode_Jabatan' => $this->input->post('kode_jabatan')]);
        if ($ValidateOfficePositionCode->num_rows() > 0) {
            return $this->help->Fn_resulting_response([
                'code' => 505,
                'msg'  => "Office Position Code already taken !",
            ]);
        }

        $this->db->trans_start();

        $this->db->insert($this->mst_jabatan, [
            'Kode_Jabatan' => strtoupper($this->input->post('kode_jabatan')),
            'Jabatan' => strtoupper($this->input->post('jabatan')),
            'Created_by' => $this->session->userdata('sys_username'),
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
                'msg' => 'Successfully insert new records !',
            ]);
        }
    }

    //=================================== Work Status ============================//

    public function index_Work_Status()
    {
        $this->data['page_title'] = "Master Work Status";
        $this->data['page_content'] = "Master/WorkStatus/index";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/WorkStatus/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function DT_List_Work_Status()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'Work_Status',
            2 => 'Is_Active'
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * FROM $this->mst_work_status
                WHERE SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Work_Status LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['Work_Status'] = $row["Work_Status"];
            $nestedData['Is_Active'] = $row["Is_Active"];

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

    public function Store_New_Work_Status()
    {
        $this->db->trans_start();

        $this->db->insert($this->mst_work_status, [
            'Work_Status' => strtoupper($this->input->post('Work_Status')),
            'Created_by' => $this->session->userdata('sys_username')
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
                'msg' => 'Successfully insert new records !',
            ]);
        }
    }

    //=================================== Allowance (Tunjangan) ============================//

    public function index_allowance()
    {
        $this->data['page_title'] = "Master Allowance";
        $this->data['page_content'] = "Master/Allowance/index";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/Allowance/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function DT_List_Allowance()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'Nama',
            2 => 'Label',
            3 => 'Nominal',
            4 => 'Pay_Type',
            5 => 'Deskripsi',
            6 => 'is_active'
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * FROM $this->mst_tunjangan
                WHERE SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Label LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Deskripsi LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Pay_Type LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();
        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['Nama'] = $row['Nama'];
            $nestedData['Label'] = $row['Label'];
            $nestedData['Nominal'] = $row['Nominal'];
            $nestedData['Pay_Type'] = $row['Pay_Type'];
            $nestedData['Deskripsi'] = $row['Deskripsi'];
            $nestedData['is_active'] = $row['is_active'];

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

    public function Store_New_Allowance()
    {
        $this->db->trans_start();

        $this->db->insert($this->mst_tunjangan, [
            'Nama' => strtoupper($this->input->post('Nama')),
            'Label' => ucwords($this->input->post('Label')),
            'Nominal' => floatval($this->input->post('Nominal')),
            'Pay_Type' => $this->input->post('Pay_Type'),
            'Deskripsi' => $this->input->post('Deskripsi'),
            'Created_by' => $this->session->userdata('sys_username')
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
                'msg' => 'Successfully insert new records !',
            ]);
        }
    }

    //=================================== Salary (gaji) ============================//

    public function index_salary()
    {
        $this->data['page_title'] = "Master Salary";
        $this->data['page_content'] = "Master/Salary/index";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/Salary/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function DT_List_Salary()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'SysId',
            1 => 'Kode_Salary',
            2 => 'Nominal',
            3 => 'Terbilang',
            4 => 'TOP',
            5 => 'is_active'
        );
        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];

        $sql = "SELECT * FROM $this->mst_salary
                WHERE SysId is not null";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Kode_Salary LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Terbilang LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR TOP LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        //----------------------------------------------------------------------------------
        $totalFiltered = $this->db->query($sql)->num_rows();
        $sql .= " ORDER BY $order $dir LIMIT " . $requestData['start'] . " ," . $requestData['length'] . " ";
        $query = $this->db->query($sql);
        $data = array();

        foreach ($query->result_array() as $row) {
            $nestedData = array();
            $nestedData['SysId'] = $row["SysId"];
            $nestedData['Kode_Salary'] = $row['Kode_Salary'];
            $nestedData['Nominal'] = $row['Nominal'];
            $nestedData['Terbilang'] = $row['Terbilang'];
            $nestedData['TOP'] = $row['TOP'];
            $nestedData['is_active'] = $row['is_active'];

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

    public function Store_New_Salary()
    {
        $this->db->trans_start();
        $this->db->insert($this->mst_salary, [
            'Kode_Salary' => strtoupper($this->input->post('Kode_Salary')),
            'Nominal' => floatval($this->input->post('Nominal')),
            'Terbilang' => ucwords($this->input->post('Terbilang')),
            'TOP' => $this->input->post('TOP'),
            'Created_by' => $this->session->userdata('sys_username')
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
                'msg' => 'Successfully insert new records !',
            ]);
        }
    }
}
