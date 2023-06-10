<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PotonganKasbon extends CI_Controller
{
    public $layout                      = 'layout';
    private $date_time;
    private $qview_employee_active      = 'qview_employee_active';

    private $tmst_hdr_kasbon            = 'tmst_hdr_kasbon';
    private $ttrx_dtl_transaksi_kasbon  = 'ttrx_dtl_transaksi_kasbon';
    private $tmst_angsuran_kasbon       = 'tmst_angsuran_kasbon';
    private $thst_angsuran_kasbon       = 'thst_angsuran_kasbon';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->date_time = date("Y-m-d H:i:s");
        $this->load->model('m_helper', 'help');
        $this->load->model('m_DataTable', 'DataTable');
    }

    public function index()
    {
        $this->data['page_title'] = "Kasbon";
        $this->data['page_content'] = "Potongan/kasbon";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Potongan/kasbon.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function Store()
    {
        $ID_employee = $this->input->post('employee');
        $nominal_kasbon = floatval($this->input->post('nominal_kasbon'));
        $note = $this->input->post('note');
        $jumlah_angsuran = floatval($this->input->post('jumlah_angsuran'));
        $sisa_kasbon = floatval($this->input->post('saldo_kasbon'));
        $nominal_angsuran = floatval($this->input->post('nominal_angsuran'));

        $this->db->trans_start();
        $ValidationRedundanHdr = $this->db->get_where($this->tmst_hdr_kasbon, ['ID' => $ID_employee]);
        if ($ValidationRedundanHdr->num_rows() == 0) {
            $this->db->insert($this->tmst_hdr_kasbon, [
                'ID' => $ID_employee,
                'Saldo_Kasbon' => $nominal_kasbon,
                'created_at' => $this->date_time,
                'created_by' => $this->session->userdata('sys_username'),
            ]);

            $this->db->insert($this->ttrx_dtl_transaksi_kasbon, [
                'Aritmatics' => '+',
                'IN_OUT' => $nominal_kasbon,
                'Saldo_Before' => 0,
                'Saldo_After' => $nominal_kasbon,
                'Remark_System' => 'NEW KASBON',
                'Note' => $note,
                'Created_by' => $this->session->userdata('sys_username'),
                'Created_at' => $this->date_time,
                'Tag_Hdr' => NULL,
            ]);

            $this->db->insert($this->tmst_angsuran_kasbon, [
                'ID' => $ID_employee,
                'Nominal_Angsuran' => $nominal_angsuran,
                'Remark_System' => 'NEW KASBON',
                'Last_Updated_by' => NULL,
                'Last_Updated_at' => NULL,
                'Created_by' => $this->session->userdata('sys_username'),
                'Created_at' => $this->date_time,
            ]);
        } else {
            $RowKasbonHdr = $ValidationRedundanHdr->row();
            if ($RowKasbonHdr->Saldo_Kasbon == 0) {
                $this->db->where('ID', $ID_employee);
                $this->db->update($this->tmst_hdr_kasbon, [
                    'Saldo_Kasbon' => $nominal_kasbon,
                    'Last_Updated_at' => $this->date_time,
                    'Last_Updated_by' => $this->session->userdata('sys_username'),
                ]);

                $this->db->insert($this->ttrx_dtl_transaksi_kasbon, [
                    'Aritmatics' => '+',
                    'IN_OUT' => $nominal_kasbon,
                    'Saldo_Before' => $RowKasbonHdr->Saldo_Kasbon,
                    'Saldo_After' => $nominal_kasbon,
                    'Remark_System' => 'NEW KASBON ++',
                    'Note' => $note,
                    'Created_by' => $this->session->userdata('sys_username'),
                    'Created_at' => $this->date_time,
                    'Tag_Hdr' => NULL,
                ]);

                $AngsuranBefore = $this->db->get_where($this->tmst_angsuran_kasbon, ['ID' => $ID_employee])->row();

                $this->db->insert($this->thst_angsuran_kasbon, [
                    'ID' => $AngsuranBefore->ID,
                    'Nominal_Angsuran' => $AngsuranBefore->Nominal_Angsuran,
                    'Remark_System' => $AngsuranBefore->Remark_System,
                    'Created_by' => $this->session->userdata('sys_username'),
                    'Created_at' => $this->date_time,
                ]);

                $this->db->where('ID', $ID_employee);
                $this->db->update($this->tmst_angsuran_kasbon, [
                    'Nominal_Angsuran' => $nominal_angsuran,
                    'Remark_System' => 'NEW KASBON ++',
                    'Last_Updated_by' => $this->session->userdata('sys_username'),
                    'Last_Updated_at' => $this->date_time,
                ]);
            } else if ($sisa_kasbon > 0) {
                $this->db->where('ID', $ID_employee);
                $this->db->update($this->tmst_hdr_kasbon, [
                    'Saldo_Kasbon' => floatval($RowKasbonHdr->Saldo_Kasbon) + $nominal_kasbon,
                    'Last_Updated_at' => $this->date_time,
                    'Last_Updated_by' => $this->session->userdata('sys_username'),
                ]);

                $this->db->insert($this->ttrx_dtl_transaksi_kasbon, [
                    'Aritmatics' => '+',
                    'IN_OUT' => $nominal_kasbon,
                    'Saldo_Before' => $RowKasbonHdr->Saldo_Kasbon,
                    'Saldo_After' => floatval($RowKasbonHdr->Saldo_Kasbon) + $nominal_kasbon,
                    'Remark_System' => 'PENAMBAHAN SALDO KASBON',
                    'Note' => $note,
                    'Created_by' => $this->session->userdata('sys_username'),
                    'Created_at' => $this->date_time,
                    'Tag_Hdr' => NULL,
                ]);

                $AngsuranBefore = $this->db->get_where($this->tmst_angsuran_kasbon, ['ID' => $ID_employee])->row();

                $this->db->insert($this->thst_angsuran_kasbon, [
                    'ID' => $AngsuranBefore->ID,
                    'Nominal_Angsuran' => $AngsuranBefore->Nominal_Angsuran,
                    'Remark_System' => $AngsuranBefore->Remark_System,
                    'Created_by' => $this->session->userdata('sys_username'),
                    'Created_at' => $this->date_time,
                ]);

                $this->db->where('ID', $ID_employee);
                $this->db->update($this->tmst_angsuran_kasbon, [
                    'Nominal_Angsuran' => floatval($RowKasbonHdr->Saldo_Kasbon) + $nominal_kasbon / $jumlah_angsuran,
                    'Remark_System' => 'PENAMBAHAN SALDO KASBON',
                    'Last_Updated_by' => $this->session->userdata('sys_username'),
                    'Last_Updated_at' => $this->date_time,
                ]);
            } else {
                return $this->help->Fn_resulting_response([
                    'code' => 302,
                    'saldo' => floatval($RowKasbonHdr->Saldo_Kasbon),
                    'msg'  => "Yang bersangkutan masih memiliki tunggakan kasbon, harp kalkulasikan kembali dengan jumlah angsuran !",
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
                'msg' => 'Berhasil menambahkan data kasbon !',
            ]);
        }
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
