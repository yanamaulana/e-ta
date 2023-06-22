<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_Schedule extends CI_Controller
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

    public function index($SysId = null)
    {
        $this->data['page_title'] = "Jadwal Mengajar Saya";
        $this->data['page_content'] = "Schedule/my_schedule";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Schedule/my_schedule.js"></script>';

        $this->data['Subjects'] = $this->db->order_by('Mata_Pelajaran', 'ASC')->get_where($this->mst_mapel, ['is_active' => 1])->result();
        $this->data['Class'] = $this->db->order_by('Kelas', 'ASC')->get_where($this->mst_class, ['is_active' => 1])->result();

        $this->data['employee'] = $this->db->get_where($this->tbl_employee, ['ID' => $this->session->userdata('sys_ID')])->row();
        if ($SysId == null) {
            $this->data['Sql_Schedule'] = $this->db->get_where($this->hdr_schedule, [
                'Approve' => 1,
                'Is_Active' => 1,
                'Access_ID' => $this->session->userdata('sys_ID')
            ]);
        } else {
            $this->data['Sql_Schedule'] = $this->db->get_where($this->hdr_schedule, ['SysId' => $SysId]);
        }

        if ($this->data['Sql_Schedule']->num_rows() > 0) {
            $this->data['Hdr_Schedule'] = $this->data['Sql_Schedule']->row();
            $this->data['Dtl_Schedule'] = $this->db->get_where('qview_schedule_all', ['Schedule_Number' => $this->data['Hdr_Schedule']->Schedule_Number])->result();
        }

        $this->data['HavingUnApproveSchedule'] = $this->db->get_where($this->hdr_schedule, [
            'Is_Active' => 0,
            'Approve'   => 0,
            'Access_ID' => $this->session->userdata('sys_ID')
        ])->num_rows();

        $this->load->view($this->layout, $this->data);
    }

    public function Store_Archive_Schedule()
    {
        $this->db->trans_start();
        $this->db->where('SysId', $this->input->post('SysId'));
        $this->db->update($this->hdr_schedule, [
            'Is_Active' => 2,
            'Archive_by' => $this->session->userdata('sys_username'),
            'Archive_at' => date('Y-m-d')
        ]);

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
                'msg' => 'Successfully archive your schedule, you dont have any schedule active right now, click OK to open create new schedule !',
                'msg' => 'Berhasil mengarsipkan jadwal, sekarang anda tidak memiliki jadwal aktif, click OK untuk membuat jadwal baru !',
            ]);
        }
    }

    public function Form_Revision_Schedule($SysId)
    {
        $this->data['page_title'] = "Form Revisi Jadwal Mengajar";
        $this->data['page_content'] = "Schedule/form_revision_schedule";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Schedule/form_revision_schedule.js"></script>';

        $this->data['Hdr_Schedule'] = $this->db->get_where($this->hdr_schedule, ['SysId' => $SysId])->row();
        $this->data['Dtl_Schedule'] = $this->db->get_where($this->dtl_schedule, ['Schedule_Number' => $this->data['Hdr_Schedule']->Schedule_Number])->result();

        $this->data['Subjects'] = $this->db->order_by('Mata_Pelajaran', 'ASC')->get_where($this->mst_mapel, ['is_active' => 1])->result();
        $this->data['Class'] = $this->db->order_by('Kelas', 'ASC')->get_where($this->mst_class, ['is_active' => 1])->result();
        $this->data['employee'] = $this->db->get_where($this->tbl_employee, ['ID' => $this->data['Hdr_Schedule']->Access_ID])->row();

        $this->load->view($this->layout, $this->data);
    }

    public function Store_Update_Schedule()
    {
        $SysId = $this->input->post('SysId');
        // var_dump($this->input->post('time_start'));
        // die;
        $subject = count($this->input->post('time_start')) - 1;
        for ($x = 0; $x <= $subject; $x++) {
            if (empty($this->input->post('day')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'Pilih hari, pada baris ' . $x + 1 . ' !'
                ]);
            }
            if (empty($this->input->post('class')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'Pilih kelas, pada baris ' . $x + 1 . ' !'
                ]);
            }
            if (empty($this->input->post('subject')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'pilih mata pelajaran, pada baris ' . $x + 1 . ' !'
                ]);
            }
            if (empty($this->input->post('time_start')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'Pilih waktu mulai, pada baris ' . $x + 1 . ' !'
                ]);
            }
            if (empty($this->input->post('time_over')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'Pilih waktu selesai, pada baris ' . $x + 1 . ' !'
                ]);
            }
            if ($this->input->post('time_start')[$x] == $this->input->post('time_over')[$x]) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'Waktu mulai dan Waktu selesai, pada baris ' . $x + 1 . ' memiliki nilai yang sama !'
                ]);
            }
            if (empty($this->input->post('hour_stand')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'Pilih jam beridiri, pada baris ' . $x + 1 . ' !'
                ]);
            }
        }

        $ID = $this->session->userdata('sys_ID');
        $RowHdr = $this->db->get_where($this->hdr_schedule, ['SysId' => $SysId])->row();
        $RowEMployee = $this->db->get_where('tbl_employee', ['ID' => $ID])->row();

        $this->db->trans_start();
        $this->db->where('SysId_Hdr', $RowHdr->SysId);
        $this->db->delete($this->dtl_schedule);

        for ($x = 0; $x <= $subject; $x++) {
            $RowMapel = $this->db->get_where($this->tmst_mapel, ['SysId' => $this->input->post('subject')[$x]])->row();
            $this->db->insert($this->dtl_schedule, [
                'SysId_Hdr'         => $RowHdr->SysId,
                'Schedule_Number'   => $RowHdr->Schedule_Number,
                'ID_Employee'       => $RowEMployee->SysId,
                'ID_Access'         => $ID,
                'Day'               => $this->input->post('day')[$x],
                'Kelas_ID'          => $this->input->post('class')[$x],
                'Start_Time'        => $this->input->post('time_start')[$x],
                'Time_Over'         => $this->input->post('time_over')[$x],
                'Subject_Code'      => $RowMapel->Kode_Mapel,
                'Subject_ID'        => $this->input->post('subject')[$x],
                'Stand_Hour'        => $this->input->post('hour_stand')[$x],
                'Created_at'        => date('Y-m-d H:i:s'),
                'Created_by'        => $this->session->userdata('sys_username'),
            ]);
        }

        $this->db->where('SysId', $SysId);
        $this->db->update($this->hdr_schedule, [
            'Sch_Rev' => floatval($RowHdr->Sch_Rev) + 1
        ]);

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
                'code'              => 200,
                'Schedule_Number'   => $RowHdr->Schedule_Number,
                'ID'                => $RowHdr->SysId,
                'msg'               => 'Data jadwal berhasil diperbarui !',
            ]);
        }
    }
}
