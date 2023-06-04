<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FormSchedule extends CI_Controller
{
    public $layout          = 'layout';
    public $mst_mapel       = 'tmst_mata_pelajaran';
    private $hdr_schedule   = 'ttrx_hdr_teaching_schedule';
    private $dtl_schedule   = 'ttrx_dtl_teaching_schedule';
    private $tbl_employee   = 'tbl_employee';
    private $tmst_mapel     = 'tmst_mata_pelajaran';
    private $mst_class      = 'tmst_kelas';

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('m_helper', 'help');
    }

    public function index()
    {
        $this->data['page_title'] = "Form Teaching Schedule";
        $this->data['page_content'] = "Schedule/form_schedule";
        $this->data['script_page'] = '<script src="' . base_url() . 'assets/Schedule/form_schedule.js"></script>';

        $this->data['Subjects'] = $this->db->order_by('Mata_Pelajaran', 'ASC')->get_where($this->mst_mapel, ['is_active' => 1])->result();
        $this->data['Class'] = $this->db->order_by('Kelas', 'ASC')->get_where($this->mst_class, ['is_active' => 1])->result();

        $this->data['HavingActiveAndApproveSchedule'] = $this->db->get_where($this->hdr_schedule, [
            'Is_Active' => 1,
            'Approve'   => 1,
            'Access_ID' => $this->session->userdata('sys_ID')
        ])->num_rows();

        $this->data['HavingActiveAndUnApproveSchedule'] = $this->db->get_where($this->hdr_schedule, [
            'Is_Active' => 0,
            'Approve'   => 0,
            'Access_ID' => $this->session->userdata('sys_ID')
        ])->num_rows();

        $this->load->view($this->layout, $this->data);
    }

    public function Store_New_Schedule()
    {
        $subject = count($this->input->post('subject')) - 1;
        for ($x = 0; $x <= $subject; $x++) {
            if (empty($this->input->post('day')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'You must select day, on row ' . $x + 1 . ' !'
                ]);
            }
            if (empty($this->input->post('class')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'You must select class, on row ' . $x + 1 . ' !'
                ]);
            }
            if (empty($this->input->post('subject')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'You must select subjects, on row ' . $x + 1 . ' !'
                ]);
            }
            if (empty($this->input->post('time_start')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'You must select start time, on row ' . $x + 1 . ' !'
                ]);
            }
            if (empty($this->input->post('time_over')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'You must select end time, on row ' . $x + 1 . ' !'
                ]);
            }
            if ($this->input->post('time_start')[$x] == $this->input->post('time_over')[$x]) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'time start and time over, on row ' . $x + 1 . ' is equal, please select other time !'
                ]);
            }
            // $start = strtotime($this->input->post('time_start')[$x]);
            // $end = strtotime($this->input->post('time_over')[$x]);
            // $mins = ($end - $start) / 60;
            // if ($mins != 35 * floatval($this->input->post('hour_stand')[$x])) {
            //     return $this->help->Fn_resulting_response([
            //         'code' => 505,
            //         'msg' => 'time range between start and end time, must ' . 35 * floatval($this->input->post('hour_stand')[$x]) . ' minutes for ' . floatval($this->input->post('hour_stand')) . ' stand hour, on row ' . $x + 1 . ' !'
            //     ]);
            // }
            if (empty($this->input->post('hour_stand')[$x])) {
                return $this->help->Fn_resulting_response([
                    'code' => 505,
                    'msg' => 'You must select stand hour, on row ' . $x + 1 . ' !'
                ]);
            }
        }

        $ID = $this->session->userdata('sys_ID');
        $Sch_Numb = $this->help->Gnrt_Identity_Number_PerYear('SCH', 'TEACHING_SCHEDULE');
        $RowEMployee = $this->db->get_where('tbl_employee', ['ID' => $ID])->row();

        $this->db->trans_start();

        $this->db->insert($this->hdr_schedule, [
            'Schedule_Number'   => $Sch_Numb,
            'Employee_ID'       => $RowEMployee->SysId,
            'Access_ID'         => $ID,
            'UserName'          => $this->session->userdata('sys_username'),
            'Created_at'        => date('Y-m-d H:i:s'),
            'Created_by'        => $this->session->userdata('sys_username'),
        ]);
        $insert_id = $this->db->insert_id();

        for ($x = 0; $x <= $subject; $x++) {
            $RowMapel = $this->db->get_where($this->tmst_mapel, ['SysId' => $this->input->post('subject')[$x]])->row();
            $this->db->insert($this->dtl_schedule, [
                'SysId_Hdr'         => $insert_id,
                'Schedule_Number'   => $Sch_Numb,
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
                'Schedule_Number' => $Sch_Numb,
                'ID' => $insert_id,
                'msg' => 'Successfully insert new records !',
            ]);
        }
    }
}
