<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OverTime extends CI_Controller
{
    private $layout             = 'layout';
    private $tbl_employee       = 'qview_employee_active';
    private $tbl_overtime       = 'ttrx_over_time';
    private $Qview_TTrx_Lembur  = 'qview_ttrx_lembur';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Form Input Over Time";
        $this->data['page_content'] = "OverTime/index";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/OverTime/index.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function Monitoring()
    {
        $this->data['page_title'] = "Monitoring Over Time";
        $this->data['page_content'] = "OverTime/monitoring";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/OverTime/monitoring.js"></script>';

        $this->data['Teachers'] = $this->db->get_where($this->tbl_employee, ['is_active' => 1])->result();

        $this->load->view($this->layout, $this->data);
    }

    public function Store()
    {
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jumlah_jam');
        $nominal = $this->input->post('nominal');
        $note = $this->input->post('note');
        $IDs = $this->input->post('IDs');
        $TotEmploye = count($IDs);

        $this->db->trans_start();

        foreach ($IDs as $ID) {
            $Row = $this->db->get_where($this->tbl_overtime, ['Tanggal' => $tanggal, 'ID' => $ID]);
            if ($Row->num_rows() > 0) {
                $this->db->trans_rollback();
                return $this->help->Fn_resulting_response([
                    'code' => 500,
                    'msg' => "User dengan ID Access : $ID, sudah memiliki data lembur pada tanggal: $tanggal !"
                ]);
            } else {
                $this->db->insert($this->tbl_overtime, [
                    'ID' => $ID,
                    'Tanggal' => $tanggal,
                    'Jumlah_Jam' => $jam,
                    'Nominal' => $nominal,
                    'Note' => $note,
                    'created_by' => $this->session->userdata('sys_username')
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
                'msg' => 'Data lembur berhasil di tambahkan !',
            ]);
        }
    }

    public function Delete()
    {
        $SysId = $this->input->post('SysId');

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->delete($this->tbl_overtime);

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
                'msg' => 'Data lembur berhasil dihapus !',
            ]);
        }
    }

    public function Edit_OverTime()
    {
        $this->data['lembur'] = $this->db->get_where($this->Qview_TTrx_Lembur, ['Sysid' => $this->input->get('SysId')])->row();

        return $this->load->view('OverTime/m_edit', $this->data);
    }

    public function Store_Update_Overtime()
    {
        $SysId = $this->input->post('sysid');

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->update($this->tbl_overtime, [
            'Tanggal' => $this->input->post('tanggal'),
            'Jumlah_Jam' =>  $this->input->post('jumlah_jam'),
            'Nominal' =>  $this->input->post('nominal'),
            'Note' =>  $this->input->post('note')
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
                'msg' => 'Berhasil memperbarui data lembur !',
            ]);
        }
    }

    public function DT_Monitoring_OverTime()
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
            4 => "Jumlah_Jam",
            5 => "Nominal",
            6 => "Calculated",
            7 => "Note",
        );

        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];
        $from = $this->input->post('from');
        $until = $this->input->post('until');

        $sql = "SELECT * 
        from qview_ttrx_lembur 
        Where SysId is not null $sql_employee AND DATE_FORMAT(Tanggal, '%Y-%m-%d') >= '$from'
        AND DATE_FORMAT(Tanggal, '%Y-%m-%d') <= '$until' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (Nama LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR ID LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Tanggal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Jumlah_Jam LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Note LIKE '%" . $requestData['search']['value'] . "%')";
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
            $nestedData["Jumlah_Jam"] = $row["Jumlah_Jam"];
            $nestedData["Nominal"] = $row["Nominal"];
            $nestedData["Calculated"] = $row["Calculated"];
            $nestedData["Note"] = $row["Note"];

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
