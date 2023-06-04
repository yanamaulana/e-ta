<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GuruPiket extends CI_Controller
{
    private $layout                     = 'layout';
    private $tbl_employee               = 'qview_employee_active';
    private $ttrx_payroll_guru_piket    = 'ttrx_payroll_guru_piket';
    private $qview_payroll_guru_piket   = 'qview_payroll_guru_piket';
    private $qview_employee_active      = 'qview_employee_active';
    private $tmst_other_payment         = 'tmst_other_payment';
    private $PaymentCode                = 'GURU_PIKET';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Form Input Guru Piket";
        $this->data['page_content'] = "GuruPiket/index";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/GuruPiket/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function Monitoring()
    {
        $this->data['page_title'] = "Monitoring Guru Piket";
        $this->data['page_content'] = "GuruPiket/monitoring";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/GuruPiket/monitoring.js"></script>';

        $this->data['Teachers'] = $this->db->get_where($this->tbl_employee, ['is_active' => 1])->result();

        $this->load->view($this->layout, $this->data);
    }

    public function Store()
    {
        $IDs            = $this->input->post('IDs');
        $tanggal        = $this->input->post('tanggal');
        $waktu_piket    = $this->input->post('waktu_piket');

        $Payment = $this->db->get_where($this->tmst_other_payment, [
            'Code' => $this->PaymentCode
        ])->row();

        $this->db->trans_start();

        foreach ($IDs as $ID) {
            $ValidateGuruPiket = $this->db->get_where($this->ttrx_payroll_guru_piket, [
                'Tanggal'       => $tanggal,
                'Waktu_Piket'   => $waktu_piket,
                'ID'            => $ID
            ]);

            if ($ValidateGuruPiket->num_rows() > 0) {
                $this->db->trans_rollback();
                $Employee = $this->db->get_where($this->qview_employee_active, ['ID' => $ID])->row();
                return $this->help->Fn_resulting_response([
                    'code' => 500,
                    'msg' => "Terjadi redudansi data untuk Employee : $Employee->Nama pada tanggal $tanggal, waktu piket $waktu_piket !"
                ]);
            } else {
                $this->db->insert($this->ttrx_payroll_guru_piket, [
                    'ID'            => $ID,
                    'Tanggal'       => $tanggal,
                    'Waktu_Piket'   => $waktu_piket,
                    'Nominal'       => floatval($Payment->Nominal),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'created_by'    => $this->session->userdata('sys_username')
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
                'msg' => 'Data guru piket berhasil di tambahkan, hasil perhitungan akan di kalkulasikan pada menu Calculate Payroll !',
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

        $requestData = $_REQUEST;
        $columns = array(
            0 => "SysId",
            1 => "ID",
            2 => "Nama",
            3 => "Tanggal",
            4 => "Waktu_Piket",
            5 => "Nominal",
            6 => "Calculated",
        );

        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];
        $from = $this->input->post('from');
        $until = $this->input->post('until');

        $sql = "SELECT * 
        from $this->qview_payroll_guru_piket 
        Where SysId is not null $sql_employee AND DATE_FORMAT(Tanggal, '%Y-%m-%d') >= '$from'
        AND DATE_FORMAT(Tanggal, '%Y-%m-%d') <= '$until' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR ID LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tanggal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Waktu_Piket LIKE '%" . $requestData['search']['value'] . "%')";
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
            $nestedData["Waktu_Piket"] = $row["Waktu_Piket"];
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
        $this->db->delete($this->ttrx_payroll_guru_piket);

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
                'msg' => 'Data guru piket berhasil dihapus !',
            ]);
        }
    }

    public function Edit()
    {
        $this->data['piket'] = $this->db->get_where($this->qview_payroll_guru_piket, ['Sysid' => $this->input->get('SysId')])->row();

        return $this->load->view('GuruPiket/m_edit', $this->data);
    }

    public function Update()
    {
        $SysId = $this->input->post('sysid');

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->update($this->ttrx_payroll_guru_piket, [
            'Tanggal' => $this->input->post('tanggal'),
            'Waktu_Piket' =>  $this->input->post('waktu_piket')
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

// SELECT SysId, ID, Tanggal, Waktu_Piket, Calculated, created_at, created_by
// FROM eta_db.ttrx_payroll_guru_piket;
