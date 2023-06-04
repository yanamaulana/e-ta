<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upacara extends CI_Controller
{
    private $layout                     = 'layout';

    private $qview_employee_active      = 'qview_employee_active';

    private $tmst_other_payment         = 'tmst_other_payment';
    private $CategoryPayment            = 'Tunjangan_Upacara';
    private $ttrx_payroll_upacara       = 'ttrx_payroll_upacara';
    private $qview_payroll_upacara      = 'qview_payroll_upacara';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Form Input Petugas Upacara";
        $this->data['page_content'] = "Upacara/index";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Upacara/index.js"></script>';

        $this->data['Jabatan_Upacara'] = $this->db->get_where($this->tmst_other_payment, ['Category' => $this->CategoryPayment])->result();

        $this->load->view($this->layout, $this->data);
    }

    public function Monitoring()
    {
        $this->data['page_title'] = "Monitoring Petugas Upacara";
        $this->data['page_content'] = "Upacara/monitoring";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Upacara/monitoring.js"></script>';

        $this->data['Teachers'] = $this->db->get_where($this->qview_employee_active, ['is_active' => 1])->result();

        $this->load->view($this->layout, $this->data);
    }

    public function Store()
    {
        $IDs            = $this->input->post('IDs');
        $tanggal        = $this->input->post('tanggal');
        $jabatan_upacara    = $this->input->post('jabatan_upacara');

        $Payment = $this->db->get_where($this->tmst_other_payment, [
            'Code' => $jabatan_upacara
        ])->row();

        $this->db->trans_start();

        foreach ($IDs as $ID) {
            $ValidateUpacara = $this->db->get_where($this->ttrx_payroll_upacara, [
                'Tanggal' => $tanggal,
                'ID'      => $ID
            ]);

            if ($ValidateUpacara->num_rows() > 0) {
                $this->db->trans_rollback();
                $Employee = $this->db->get_where($this->qview_employee_active, ['ID' => $ID])->row();
                return $this->help->Fn_resulting_response([
                    'code' => 500,
                    'msg' => "Terjadi redudansi data untuk Employee : $Employee->Nama pada tanggal $tanggal !"
                ]);
            } else {
                $this->db->insert($this->ttrx_payroll_upacara, [
                    'ID'                => $ID,
                    'Tanggal'           => $tanggal,
                    'Jabatan_Upacara'   => $jabatan_upacara,
                    'Nominal'           => floatval($Payment->Nominal),
                    'created_at'        => date('Y-m-d H:i:s'),
                    'created_by'        => $this->session->userdata('sys_username')
                ]);
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
                'msg' => 'Data petugas upacara berhasil di tambahkan, hasil perhitungan akan di kalkulasikan pada menu Calculate Payroll !',
            ]);
        }
    }

    public function DT_Monitoring()
    {
        $employee = $this->input->post('employee');
        $sql_employee = "";
        if (!empty($employee)) {
            $sql_employee = " AND ID = $employee ";
        }
        // SELECT SysId, ID, Nama, UserName, Tanggal, Jabatan_Upacara, Nominal, Calculated, created_at, created_by
        // FROM eta_db.qview_payroll_upacara;
        $requestData = $_REQUEST;
        $columns = array(
            0 => "SysId",
            1 => "ID",
            2 => "Nama",
            3 => "Tanggal",
            4 => "Jabatan_Upacara",
            5 => "Nominal",
            6 => "Calculated",
        );

        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];
        $from = $this->input->post('from');
        $until = $this->input->post('until');

        $sql = "SELECT * 
        from $this->qview_payroll_upacara 
        Where SysId is not null $sql_employee AND DATE_FORMAT(Tanggal, '%Y-%m-%d') >= '$from'
        AND DATE_FORMAT(Tanggal, '%Y-%m-%d') <= '$until' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR ID LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tanggal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Jabatan_Upacara LIKE '%" . $requestData['search']['value'] . "%')";
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
            $nestedData["SysId"] = $row["SysId"];
            $nestedData["ID"] = $row["ID"];
            $nestedData["Nama"] = $row["Nama"];
            $nestedData["Tanggal"] = $row["Tanggal"];
            $nestedData["Jabatan_Upacara"] = $row["Jabatan_Upacara"];
            $nestedData["Nominal"] = $row["Nominal"];
            $nestedData["Calculated"] = $row["Calculated"];

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

    public function Delete()
    {
        $SysId = $this->input->post('SysId');

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->delete($this->ttrx_payroll_upacara);

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
                'msg' => 'Data petugas upacara berhasil dihapus !',
            ]);
        }
    }

    public function Edit()
    {
        $this->data['data'] = $this->db->get_where($this->qview_payroll_upacara, ['Sysid' => $this->input->get('SysId')])->row();
        $this->data['Jabatan_Upacara'] = $this->db->get_where($this->tmst_other_payment, ['Category' => $this->CategoryPayment])->result();

        return $this->load->view('Upacara/m_edit', $this->data);
    }

    public function Update()
    {
        $SysId = $this->input->post('sysid');

        $Payment = $this->db->get_where($this->tmst_other_payment, [
            'Code' => $this->input->post('jabatan_upacara')
        ])->row();

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->update($this->ttrx_payroll_upacara, [
            'Tanggal' => $this->input->post('tanggal'),
            'Jabatan_Upacara' =>  $this->input->post('jabatan_upacara'),
            'Nominal' => floatval($Payment->Nominal)
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
                'msg' => 'Data piket berhasil diperbarui !',
            ]);
        }
    }
}
