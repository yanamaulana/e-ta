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
        // $PerJam = 11000;
        // $Nominal_Walas = 200000;
        // $Kelass = $this->db->get('tmst_kelas')->result();
        // foreach ($Kelass as $li) {
        //     $this->db->insert('tmst_tunjangan', [
        //         'Kategori' => "JABATAN",
        //         'Nama' => "WALI KELAS - $li->Kelas",
        //         'Label' => "Wali Kelas $li->Kelas",
        //         'Nominal' => $Nominal_Walas,
        //         'Terbilang' => $this->help->terbilangRupiah($Nominal_Walas),
        //         'Pay_Type' => "BULANAN",
        //         'Deskripsi' => "Tunjangan wali kelas perbulan",
        //         'is_active' => 1,
        //         'Created_at' => date('Y-m-d H:i:s'),
        //         'Created_by' => 'SYSTEM'
        //     ]);
        // }
        // for ($i = 50; $i <= 50; $i++) {
        //     $this->db->insert('tmst_salary', [
        //         'Kategory' => 'TATAP MUKA BULANAN',
        //         'Kode_Salary' => $i . ' JAM PERBULAN',
        //         'Nominal' => $i * $PerJam,
        //         'Terbilang' => $this->help->terbilangRupiah($i * $PerJam),
        //         'TOP' => 'BULANAN',
        //         'is_active' => 1,
        //         'Created_at' => date('Y-m-d H:i:s'),
        //         'Created_by' => 'SYSTEM'
        //     ]);
        // }



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
