<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public $layout = 'layout';
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Dashboard";
        $this->data['page_content'] = "Dashboard/index";
        $this->data['script_page'] =  '<script src="' . base_url() . 'assets/Dashboard/index.js"></script>';
        $this->data['date'] = date('Y-m-d');


        $this->data['jam_lembur'] = $this->db->query("SELECT coalesce(sum(Jumlah_Jam), 0) as Jumlah_Jam 
        FROM eta_db.ttrx_over_time
        where  DATE_FORMAT(Tanggal, '%Y-%m') = '" . date('Y-m') . "'")->row();

        $this->data['employee'] = $this->db->get('qview_employee_active');
        $this->data['do_jadwal'] = $this->db->get_where('qview_schedule_active', ['Day' => 'MONDAY']);

        $this->load->view($this->layout, $this->data);
    }
}
