<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MyArchiveSchedule extends CI_Controller
{
    public $layout          = 'layout';
    private $mst_mapel       = 'tmst_mata_pelajaran';
    private $hdr_schedule   = 'ttrx_hdr_teaching_schedule';
    private $dtl_schedule   = 'ttrx_dtl_teaching_schedule';
    private $tbl_employee   = 'tbl_employee';
    private $tmst_mapel   = 'tmst_mata_pelajaran';
    private $mst_class   = 'tmst_kelas';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Arsip Jadwal Mengajar Saya";
        $this->data['page_content'] = "Schedule/my_archive_schedule";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Schedule/my_archive_schedule.js"></script>';

        $this->data['Subjects'] = $this->db->order_by('Mata_Pelajaran', 'ASC')->get_where($this->mst_mapel, ['is_active' => 1])->result();
        $this->data['Class'] = $this->db->order_by('Kelas', 'ASC')->get_where($this->mst_class, ['is_active' => 1])->result();
        $this->data['Hdr_Schedules'] = $this->db->get_where($this->hdr_schedule, ['Is_Active' => 2]);
        $this->data['employee'] = $this->db->get_where($this->tbl_employee, ['ID' => $this->session->userdata('sys_ID')])->row();

        $this->load->view($this->layout, $this->data);
    }
}
