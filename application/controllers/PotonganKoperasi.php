<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PotonganKoperasi extends CI_Controller
{
    public $layout                      = 'layout';
    private $date_time;
    private $qview_employee_active      = 'qview_employee_active';

    private $tmst_hdr_kasbon            = 'tmst_hdr_kasbon';
    private $ttrx_dtl_transaksi_kasbon  = 'ttrx_dtl_transaksi_kasbon';
    private $tmst_angsuran_kasbon       = 'tmst_angsuran_kasbon';
    private $thst_angsuran_kasbon       = 'thst_angsuran_kasbon';
    private $qview_mst_hdr_kasbon       = 'qview_mst_hdr_kasbon';
    private $qview_dtl_transaksi_kasbon       = 'qview_dtl_transaksi_kasbon';

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
}
