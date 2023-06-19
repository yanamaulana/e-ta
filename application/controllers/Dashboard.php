<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    protected $Day;
    protected $Date;
    protected $layout = 'layout';
    protected $qview_payroll_guru_piket = 'qview_payroll_guru_piket';
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->Day = date("l");
        $this->Date = date("Y-m-d");
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
        $this->data['do_jadwal'] = $this->db->get_where('qview_schedule_active', ['Day' => $this->Day]);
        $this->data['Pikets'] = $this->db->get_where($this->qview_payroll_guru_piket, ['Tanggal' => $this->Date]);

        $this->load->view($this->layout, $this->data);
    }
}
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


//     INSERT INTO `ttrx_dtl_teaching_schedule` VALUES (37,10,'SCH-2302009',38,4,'Thursday',8,'07:00','07:30',10,'TIK',1.00,'2023-02-13 21:52:45','ARIFIN'),
// (38,10,'SCH-2302009',38,4,'Thursday',4,'08:00','08:30',10,'TIK',1.00,'2023-02-13 21:52:45','ARIFIN'),
// (39,10,'SCH-2302009',38,4,'Thursday',12,'09:00','09:30',10,'TIK',1.00,'2023-02-13 21:52:45','ARIFIN'),
// (41,9,'SCH-2302008',37,3,'Monday',1,'08:00','09:00',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (42,9,'SCH-2302008',37,3,'Monday',2,'10:50','11:50',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (43,9,'SCH-2302008',37,3,'Tuesday',3,'07:30','08:30',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (44,9,'SCH-2302008',37,3,'Tuesday',4,'08:30','09:30',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (45,9,'SCH-2302008',37,3,'Tuesday',5,'10:20','11:50',7,'BI',3.00,'2023-02-20 20:18:34','WAHYU'),
// (46,9,'SCH-2302008',37,3,'Tuesday',8,'14:30','15:30',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (47,9,'SCH-2302008',37,3,'Tuesday',11,'16:00','17:00',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (48,9,'SCH-2302008',37,3,'Wednesday',12,'10:50','11:50',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (49,9,'SCH-2302008',37,3,'Wednesday',5,'14:00','14:30',7,'BI',1.00,'2023-02-20 20:18:34','WAHYU'),
// (50,9,'SCH-2302008',37,3,'Wednesday',12,'14:30','15:00',7,'BI',1.00,'2023-02-20 20:18:34','WAHYU'),
// (51,9,'SCH-2302008',37,3,'Thursday',8,'07:30','08:30',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (52,9,'SCH-2302008',37,3,'Thursday',7,'09:50','10:50',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (53,9,'SCH-2302008',37,3,'Thursday',9,'13:30','15:00',7,'BI',3.00,'2023-02-20 20:18:34','WAHYU'),
// (54,9,'SCH-2302008',37,3,'Friday',11,'08:30','09:30',7,'BI',2.00,'2023-02-20 20:18:34','WAHYU'),
// (55,8,'SCH-2302007',36,2,'Tuesday',3,'10:15','12:00',13,'TLJ',3.00,'2023-02-20 20:19:55','SUHANDI'),
// (56,8,'SCH-2302007',36,2,'Monday',3,'09:00','10:50',16,'PKK',3.00,'2023-02-20 20:19:55','SUHANDI'),
// (57,8,'SCH-2302007',36,2,'Tuesday',2,'07:30','08:30',14,'TJBL',2.00,'2023-02-20 20:19:55','SUHANDI'),
// (58,8,'SCH-2302007',36,2,'Tuesday',1,'08:30','10:20',15,'DTJKT',3.00,'2023-02-20 20:19:55','SUHANDI'),
// (59,8,'SCH-2302007',36,2,'Wednesday',5,'07:30','09:00',13,'TLJ',3.00,'2023-02-20 20:19:55','SUHANDI'),
// (60,8,'SCH-2302007',36,2,'Wednesday',6,'09:00','10:20',14,'TJBL',2.00,'2023-02-20 20:19:55','SUHANDI'),
// (61,8,'SCH-2302007',36,2,'Wednesday',7,'10:50','11:50',15,'DTJKT',2.00,'2023-02-20 20:19:55','SUHANDI'),
// (62,8,'SCH-2302007',36,2,'Thursday',8,'07:30','09:00',13,'TLJ',3.00,'2023-02-20 20:19:55','SUHANDI'),
// (63,8,'SCH-2302007',36,2,'Thursday',9,'09:00','10:20',14,'TJBL',2.00,'2023-02-20 20:19:55','SUHANDI'),
// (64,8,'SCH-2302007',36,2,'Thursday',10,'10:50','11:50',13,'TLJ',2.00,'2023-02-20 20:19:55','SUHANDI'),
// (65,8,'SCH-2302007',36,2,'Saturday',11,'07:30','09:30',16,'PKK',4.00,'2023-02-20 20:19:55','SUHANDI'),
// (66,8,'SCH-2302007',36,2,'Saturday',12,'10:20','11:50',13,'TLJ',1.00,'2023-02-20 20:19:55','SUHANDI'),
// (67,12,'SCH-2303011',37,3,'Monday',1,'07:00','08:00',28,'AIJ',2.00,'2023-03-04 13:34:03','WAHYU');


// INSERT INTO `ttrx_hdr_teaching_schedule` VALUES (8,1,'SCH-2302007',36,2,'SUHANDI',1,'2023-02-11 11:49:31','Taufik',1,NULL,NULL,'2023-02-11 11:49:00','SUHANDI',NULL,NULL),
// (9,1,'SCH-2302008',37,3,'WAHYU',1,'2023-02-11 12:08:01','Taufik',1,'WAHYU','2023-03-04 00:00:00','2023-02-11 12:07:21','WAHYU',NULL,NULL),
// (10,1,'SCH-2302009',38,4,'ARIFIN',1,'2023-02-13 22:28:47','ARIFIN',1,'ARIFIN','2023-02-13 00:00:00','2023-02-11 22:15:38','ARIFIN',NULL,NULL),
// (12,0,'SCH-2303011',37,3,'WAHYU',1,'2023-03-04 13:34:48','WAHYU',1,NULL,NULL,'2023-03-04 13:34:03','WAHYU',NULL,NULL);
