<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ScheduleActive extends CI_Controller
{
    public $layout          = 'layout';
    private $hdr_schedule   = 'ttrx_hdr_teaching_schedule';
    private $dtl_schedule   = 'ttrx_dtl_teaching_schedule';
    private $qview_schedule_all   = 'qview_schedule_all';
    private $qview_hdr_schedule_all   = 'qview_hdr_schedule_all';
    private $view_schedule_approval = 'qview_hdr_schedule_need_approval';
    private $mst_mapel   = 'tmst_mata_pelajaran';
    private $mst_class   = 'tmst_kelas';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
        $this->load->model('m_DataTable', 'M_Datatables');
    }

    public function index()
    {
        $this->data['page_title'] = "Jadwal Mengajar Aktif";
        $this->data['page_content'] = "Schedule/monitoring_schedule";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Schedule/monitoring-schedule.js"></script>';

        $this->load->view($this->layout, $this->data);
    }

    public function DT_list_schedule_active_all()
    {
        $tables = $this->qview_schedule_all;
        $search = array('Schedule_Number', 'ID_Access', 'Nama', 'Hari', 'Kelas', 'Subject_Code', 'Mata_Pelajaran', 'Start_Time', 'Time_Over', 'Stand_Hour');
        $isWhere = null;
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables($tables, $search, $isWhere);
    }

    public function DT_list_schedule_active_rekap_guru()
    {
        $tables = $this->qview_hdr_schedule_all;
        $search = ['Schedule_Number', 'Nama', 'Jabatan', 'Date_create'];
        $where  = ['Approve' => 1];
        // jika memakai IS NULL pada where sql
        $isWhere = null;
        // $isWhere = 'artikel.deleted_at IS NULL';
        header('Content-Type: application/json');
        echo $this->M_Datatables->get_tables_where($tables, $search, $where, $isWhere);
    }
}
