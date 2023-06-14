<?php
class m_history extends CI_Model
{
    private $thst_hdr_payroll           = 'thst_hdr_payroll';
    private $thst_event_payroll         = 'thst_event_payroll';
    private $thst_dtl_transaksi_kasbon  = 'thst_dtl_transaksi_kasbon';

    public function History_Hdr_Payroll($data, $status)
    {
        $this->db->trans_start();
        $this->db->insert($this->thst_hdr_payroll, [
            'SysId' => $data->SysId,
            'TagID_Event' => $data->TagID_Event,
            'TagID_PerNIK' => $data->TagID_PerNIK,
            'NIK' => $data->NIK,
            'Include_Gaji' => $data->Include_Gaji,
            'Gaji' => $data->Gaji,
            'Jabatan' => $data->Jabatan,
            'Label_Tunjangan_Pokok' => $data->Label_Tunjangan_Pokok,
            'Tunjangan_Pokok' => $data->Tunjangan_Pokok,
            'Include_Tunjangan_Jabatan' => $data->Include_Tunjangan_Jabatan,
            'Fk_Tunjangan_Jabatan_1' => $data->Fk_Tunjangan_Jabatan_1,
            'Label_Tunjangan_Jabatan_1' => $data->Label_Tunjangan_Jabatan_1,
            'Tunjangan_Jabatan_1' => $data->Tunjangan_Jabatan_1,
            'Fk_Tunjangan_Jabatan_2' => $data->Fk_Tunjangan_Jabatan_2,
            'Label_Tunjangan_Jabatan_2' => $data->Label_Tunjangan_Jabatan_2,
            'Tunjangan_Jabatan_2' => $data->Tunjangan_Jabatan_2,
            'Fk_Tunjangan_Jabatan_3' => $data->Fk_Tunjangan_Jabatan_3,
            'Label_Tunjangan_Jabatan_3' => $data->Label_Tunjangan_Jabatan_3,
            'Tunjangan_Jabatan_3' => $data->Tunjangan_Jabatan_3,
            'Fk_Tunjangan_Lain' => $data->Fk_Tunjangan_Lain,
            'Label_Tunjangan_Lain' => $data->Label_Tunjangan_Lain,
            'Nominal_Tunjangan_Lain' => $data->Nominal_Tunjangan_Lain,
            'Include_Angsuran_Kasbon' => $data->Include_Angsuran_Kasbon,
            'Nominal_Angsuran_Kasbon' => $data->Nominal_Angsuran_Kasbon,
            'Nominal_Potongan_Keanggotaan_Pgri' => $data->Nominal_Potongan_Keanggotaan_Pgri,
            'Status_History' => $status,
            'History_by' => $this->session->userdata('sys_username')
        ]);
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Hst_Event_Payroll($data, $status)
    {
        $this->db->trans_start();
        $this->db->insert($this->thst_event_payroll, [
            'SysId' => $data->SysId,
            'TagID' => $data->TagID,
            'Tot_Employee_Calculated' => $data->Tot_Employee_Calculated,
            'Tgl_Dari' => $data->Tgl_Dari,
            'Tgl_Sampai' => $data->Tgl_Sampai,
            'Payment_Status' => $data->Payment_Status,
            'Payment_Status_Change_at' => $data->Payment_Status_Change_at,
            'Payment_Status_Change_By' => $data->Payment_Status_Change_By,
            'Created_by' => $data->Created_by,
            'Created_at' => $data->Created_at,
            'Status_History' => $status,
            'History_by' => $this->session->userdata('sys_username')
        ]);
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Hst_Transaksi_Kasbon($data, $status)
    {
        $this->db->trans_start();
        $this->db->insert($this->thst_dtl_transaksi_kasbon, [
            'SysId' => $data->SysId,
            'ID' => $data->ID,
            'Aritmatics' => $data->Aritmatics,
            'IN_OUT' => $data->IN_OUT,
            'Saldo_Before' => $data->Saldo_Before,
            'Saldo_After' => $data->Saldo_After,
            'Remark_System' => $data->Remark_System,
            'Note' => $data->Note,
            'Created_by' => $data->Created_by,
            'Created_at' => $data->Created_at,
            'Tag_Hdr' => $data->Tag_Hdr,
            'Status_History' => $status,
            'History_by' => $this->session->userdata('sys_username')
        ]);
        $this->db->trans_complete();
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}
