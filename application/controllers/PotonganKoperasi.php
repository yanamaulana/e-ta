<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PotonganKoperasi extends CI_Controller
{
    private $date_time;
    public $layout = 'layout';
    private $qview_employee_active = 'qview_employee_active';
    private $qview_mst_hdr_koperasi = 'qview_mst_hdr_koperasi';
    private $qview_dtl_transaksi_koperasi = 'qview_dtl_transaksi_koperasi';

    private $tmst_hdr_utang_koperasi = 'tmst_hdr_utang_koperasi';
    private $tmst_angsuran_utang_koperasi = 'tmst_angsuran_utang_koperasi';
    private $ttrx_dtl_transaksi_koperasi = 'ttrx_dtl_transaksi_koperasi';
    private $thst_angsuran_koperasi = 'thst_angsuran_koperasi';
    private $thst_dtl_transaksi_koperasi = 'thst_dtl_transaksi_koperasi';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->date_time = date("Y-m-d H:i:s");
        $this->load->model('m_helper', 'help');
        $this->load->model('m_DataTable', 'M_Datatables');
    }

    public function index()
    {
        $this->data['page_title'] = "Hutang & Angsuran Koperasi";
        $this->data['page_content'] = "Potongan/koperasi";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Potongan/koperasi.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function store()
    {
        $ID_employee = $this->input->post('employee');
        $nominal_utang = floatval($this->input->post('nominal_utang'));
        $note = $this->input->post('note');
        $jumlah_angsuran = floatval($this->input->post('jumlah_angsuran'));
        $sisa_utang = floatval($this->input->post('saldo_utang'));
        $nominal_angsuran = floatval($this->input->post('nominal_angsuran'));

        $this->db->trans_start();
        $ValidationRedundanHdr = $this->db->get_where($this->tmst_hdr_utang_koperasi, ['ID' => $ID_employee]);
        if ($ValidationRedundanHdr->num_rows() == 0) {
            $this->db->insert($this->tmst_hdr_utang_koperasi, [
                'ID' => $ID_employee,
                'Saldo_Utang' => $nominal_utang,
                'created_at' => $this->date_time,
                'created_by' => $this->session->userdata('sys_username'),
            ]);

            $this->db->insert($this->ttrx_dtl_transaksi_koperasi, [
                'ID' => $ID_employee,
                'Aritmatics' => '+',
                'IN_OUT' => $nominal_utang,
                'Saldo_Before' => 0,
                'Saldo_After' => $nominal_utang,
                'Remark_System' => 'PENGAMBILAN UTANG KOPERASI',
                'Note' => $note,
                'Created_by' => $this->session->userdata('sys_username'),
                'Created_at' => $this->date_time,
                'Tag_Hdr' => NULL,
            ]);

            $this->db->insert($this->tmst_angsuran_utang_koperasi, [
                'ID' => $ID_employee,
                'Nominal_Angsuran' => $nominal_angsuran,
                'Remark_System' => 'PENGAMBILAN UTANG KOPERASI',
                'Last_Updated_by' => NULL,
                'Last_Updated_at' => NULL,
                'Created_by' => $this->session->userdata('sys_username'),
                'Created_at' => $this->date_time,
            ]);
        } else {
            $RowUtangHdr = $ValidationRedundanHdr->row();
            if ($RowUtangHdr->Saldo_Utang == 0) {
                $this->db->insert($this->ttrx_dtl_transaksi_koperasi, [
                    'ID' => $ID_employee,
                    'Aritmatics' => '+',
                    'IN_OUT' => $nominal_utang,
                    'Saldo_Before' => $RowUtangHdr->Saldo_Utang,
                    'Saldo_After' => $nominal_utang,
                    'Remark_System' => 'PENGAMBILAN UTANG KOPERASI ++',
                    'Note' => $note,
                    'Created_by' => $this->session->userdata('sys_username'),
                    'Created_at' => $this->date_time,
                    'Tag_Hdr' => NULL,
                ]);

                $AngsuranBefore = $this->db->get_where($this->tmst_angsuran_utang_koperasi, ['ID' => $ID_employee])->row();

                $this->db->insert($this->thst_angsuran_koperasi, [
                    'ID' => $AngsuranBefore->ID,
                    'Nominal_Angsuran' => $AngsuranBefore->Nominal_Angsuran,
                    'Remark_System' => $AngsuranBefore->Remark_System,
                    'Created_by' => $this->session->userdata('sys_username'),
                    'Created_at' => $this->date_time,
                ]);

                $this->db->where('ID', $ID_employee);
                $this->db->update($this->tmst_angsuran_utang_koperasi, [
                    'Nominal_Angsuran' => $nominal_angsuran,
                    'Remark_System' => 'PENGAMBILAN UTANG KOPERASI ++',
                    'Last_Updated_by' => $this->session->userdata('sys_username'),
                    'Last_Updated_at' => $this->date_time,
                ]);

                $this->db->where('ID', $ID_employee);
                $this->db->update($this->tmst_hdr_utang_koperasi, [
                    'Saldo_Utang' => $nominal_utang,
                    'Last_Updated_at' => $this->date_time,
                    'Last_Updated_by' => $this->session->userdata('sys_username'),
                ]);
            } else {
                return $this->help->Fn_resulting_response([
                    'code' => 500,
                    'msg'  => "Yang bersangkutan masih memiliki tunggakan utang koperasi, tunggu sampai hutang koperasinya lunas !",
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

    public function DT_Master_Hdr_Koperasi()
    {
        $tables = $this->qview_mst_hdr_koperasi;
        $search = ['ID', 'Nama', 'Saldo_Utang', 'Nominal_Angsuran', 'Sisa_Jumlah_Angsuran'];
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables($tables, $search, $isWhere);
    }

    public function M_detail_transaksi_koperasi()
    {
        $this->data['Hdr'] = $this->db->get_where($this->qview_mst_hdr_koperasi, ['Sysid' => $this->input->get('SysId')])->row();

        return $this->load->view('Potongan/m_transaksi_koperasi', $this->data);
    }

    public function DT_List_Trx_Employee()
    {
        $tables = $this->qview_dtl_transaksi_koperasi;
        $search = ['Aritmatics', 'IN_OUT', 'Tgl_Tran', 'Tag_Hdr', 'Note', 'Remark_System', 'Saldo_After', 'Saldo_Before'];
        $where  = ['ID' => $this->input->post('ID')];
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_where($tables, $search, $where, $isWhere);
    }
}
