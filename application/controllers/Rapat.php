<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rapat extends CI_Controller
{
    private $layout                     = 'layout';
    private $tbl_employee               = 'qview_employee_active';

    private $ttrx_hdr_rapat             = 'ttrx_hdr_rapat';
    private $ttrx_dtl_peserta_rapat     = 'ttrx_dtl_peserta_rapat';
    private $qview_hdr_rapat            = 'qview_hdr_rapat';
    private $qview_dtl_peserta_rapat    = 'qview_dtl_peserta_rapat';

    private $tmst_other_payment         = 'tmst_other_payment';
    private $PaymentCode                = 'K_RAPAT';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Form Kegiatan Rapat";
        $this->data['page_content'] = "Rapat/index";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Rapat/index.js"></script>';

        $this->data['Employees'] = $this->db->get_where($this->tbl_employee)->result();

        $this->load->view($this->layout, $this->data);
    }

    public function Monitoring()
    {
        $this->data['page_title'] = "Monitoring Kegiatan Rapat";
        $this->data['page_content'] = "Rapat/monitoring";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Rapat/monitoring.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function Store()
    {
        $Payment = $this->db->get_where($this->tmst_other_payment, [
            'Code' => $this->PaymentCode
        ])->row();

        $DocNumber = 'RPT-' . date('y/m') . '-' . $this->help->Gnrt_Identity_Number_PerMonth('K-RAPAT');

        $this->db->trans_start();

        $this->db->insert($this->ttrx_hdr_rapat, [
            'No_Meeting' => $DocNumber,
            'Meeting_Date' => $this->input->post('tanggal'),
            'Time_Start' => $this->input->post('start'),
            'Time_End' => $this->input->post('end'),
            'Theme' => $this->input->post('tema'),
            'Meeting_Room' => $this->input->post('ruangan'),
            'Leader' => $this->input->post('ketua_rapat'),
            'Note' => $this->input->post('note'),
            'Nominal_Tunjangan' => floatval($Payment->Nominal),
            'Created_at' => date('Y-m-d H:i:s'),
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
                'msg' => 'Memo rapat berhasil di simpan, peserta rapat dapat di lihat pada menu Monitoring Rapat !',
            ]);
        }
    }

    public function Delete()
    {
        $SysId = $this->input->post('SysId');

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->delete($this->ttrx_hdr_rapat);

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
                'msg' => 'Data Rapat berhasil dihapus !',
            ]);
        }
    }

    public function Edit()
    {
        $this->data['data'] = $this->db->get_where($this->qview_hdr_rapat, ['Sysid' => $this->input->get('SysId')])->row();
        $this->data['Employees'] = $this->db->get_where($this->tbl_employee)->result();

        return $this->load->view('Rapat/m_edit', $this->data);
    }

    public function M_list_peserta()
    {
        $this->data['Hdr'] = $this->db->get_where($this->qview_hdr_rapat, ['Sysid' => $this->input->get('SysId')])->row();
        $this->data['Dtls'] = $this->db->get_where($this->qview_dtl_peserta_rapat, ['No_Meeting_Hdr' => $this->data['Hdr']->No_Meeting])->result();

        return $this->load->view('Rapat/m_peserta_rapat', $this->data);
    }

    public function Update()
    {
        $SysId = $this->input->post('sysid');

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->update($this->ttrx_hdr_rapat, [
            'Meeting_Date' => $this->input->post('tanggal'),
            'Time_Start' => $this->input->post('start'),
            'Time_End' => $this->input->post('end'),
            'Theme' => $this->input->post('tema'),
            'Meeting_Room' => $this->input->post('ruangan'),
            'Leader' => $this->input->post('ketua_rapat'),
            'Note' => $this->input->post('note'),
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
                'msg' => 'Data Rapat berhasil diperbarui !',
            ]);
        }
    }

    public function Approve_Leader()
    {
        $SysId = $this->input->post('SysId');
        $No_Meeting = $this->input->post('No_Meeting');

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->update($this->ttrx_hdr_rapat, [
            'Approve_Leader' => 1,
            'Approve_Leader_by' => $this->session->userdata('sys_username'),
            'Approve_Leader_at' => date('Y-m-d H:i:s'),
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
                'msg' => "Rapat : $No_Meeting dinyatakan disetujui oleh leader  !",
            ]);
        }
    }

    public function Approve_Admin()
    {
        $SysId = $this->input->post('SysId');
        $No_Meeting = $this->input->post('No_Meeting');

        $this->db->trans_start();

        $this->db->where('SysId', $SysId);
        $this->db->update($this->ttrx_hdr_rapat, [
            'Approve_Admin' => 1,
            'Approve_Admin_by' => $this->session->userdata('sys_username'),
            'Approve_Admin_at' => date('Y-m-d H:i:s'),
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
                'msg' => "Rapat : $No_Meeting dinyatakan disetujui oleh leader  !",
            ]);
        }
    }

    public function DT_Monitoring()
    {
        $requestData = $_REQUEST;
        $columns = array(
            0 => "No_Meeting",
            1 => "Meeting_Date",
            2 => "Time_Start",
            3 => "Time_End",
            4 => "Theme",
            5 => "Meeting_Room",
            6 => "Leader_Name",
            7 => "Nominal_Tunjangan",
            8 => "Total_Participant",
            9 => "Approve_Leader",
            10 => "Approve_Admin",
        );

        $order = $columns[$requestData['order']['0']['column']];
        $dir = $requestData['order']['0']['dir'];
        $from = $this->input->post('from');
        $until = $this->input->post('until');

        $sql = "SELECT * from $this->qview_hdr_rapat 
        Where SysId is not null 
        AND DATE_FORMAT(Meeting_Date, '%Y-%m-%d') >= '$from'
        AND DATE_FORMAT(Meeting_Date, '%Y-%m-%d') <= '$until' ";

        $totalData = $this->db->query($sql)->num_rows();
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (No_Meeting LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Meeting_Date LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_Start LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Time_End LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Theme LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Meeting_Room LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Leader_Name LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Nominal_Tunjangan LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR Total_Participant LIKE '%" . $requestData['search']['value'] . "%')";
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
            $nestedData['No_Meeting']           = $row['No_Meeting'];
            $nestedData['Meeting_Date']         = $row['Meeting_Date'];
            $nestedData['Time_Start']           = substr($row['Time_Start'], 0, 5);
            $nestedData['Time_End']             = substr($row['Time_End'], 0, 5);
            $nestedData['Theme']                = $row['Theme'];
            $nestedData['Meeting_Room']         = $row['Meeting_Room'];
            $nestedData['Leader']               = $row['Leader'];
            $nestedData['Leader_Name']          = $row['Leader_Name'];
            $nestedData['Note']                 = $row['Note'];
            $nestedData['Nominal_Tunjangan']    = $row['Nominal_Tunjangan'];
            $nestedData['Total_Participant']    = $row['Total_Participant'] . ' Peserta';
            $nestedData['Approve_Admin']        = $row['Approve_Admin'];
            $nestedData['Approve_Admin_by']     = $row['Approve_Admin_by'];
            $nestedData['Approve_Admin_at']     = $row['Approve_Admin_at'];
            $nestedData['Approve_Leader']       = $row['Approve_Leader'];
            $nestedData['Approve_Leader_by']    = $row['Approve_Leader_by'];
            $nestedData['Approve_Leader_at']    = $row['Approve_Leader_at'];
            $nestedData['Created_at']           = $row['Created_at'];
            $nestedData['Created_by']           = $row['Created_by'];

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
