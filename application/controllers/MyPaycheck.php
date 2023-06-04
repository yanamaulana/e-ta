<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MyPaycheck extends CI_Controller
{
    private $layout             = 'layout';
    private $tbl_employee       = 'qview_employee_active';
    private $tbl_overtime       = 'ttrx_over_time';
    private $Qview_TTrx_Lembur  = 'qview_ttrx_lembur';

    private $ttrx_hdr_payroll       = 'ttrx_hdr_payroll';
    private $qview_employee_active  = 'qview_employee_active';
    private $att_trans  = 'att_trans';
    private $ttrx_over_time = 'ttrx_over_time';
    private $ttrx_dtl_payroll = 'ttrx_dtl_payroll';
    private $ttrx_event_payroll = 'ttrx_event_payroll';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "My Paycheck";
        $this->data['page_content'] = "Payroll/my_paycheck";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Payroll/my_paycheck.js"></script>';

        $this->load->view($this->layout, $this->data);
    }
}
