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
        $this->load->model('m_DataTable', 'M_Datatables');
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
        $tables = $this->qview_payroll_cuts_pgri;
        $search = array('ID', 'UserName', 'Nama', 'Nominal', 'Terbilang');
        $isWhere = null;
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables($tables, $search, $isWhere);
    }
}
