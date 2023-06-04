<?php
class m_helper extends CI_Model
{
    private $tbl_CounterDocNumber = 'tsys_counterdocnumber';

    public function Fn_resulting_response($responses)
    {
        $response = json_encode($responses);
        echo $response;
    }

    public function format_idr($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }

    public function Gnrt_Identity_Number_PerYear($param, $trxName)
    {
        $rows = $this->db->get_where($this->tbl_CounterDocNumber, array(
            "TrxName" => $trxName,
            "TrxYear" => date('Y'),
            // "month" => date('m'),
        ));
        // TrxName, TrxMonth, TrxYear, TrxDate, CurrDocNumber
        $length = 3;
        if ($rows->num_rows() > 0) {
            $row = $rows->row();
            $newCount = intval($row->CurrDocNumber) + 1;

            $this->db->where('TrxName', $trxName);
            $this->db->where('TrxYear', date('Y'));
            // $this->db->where('TrxMonth', date('m'));
            $this->db->update($this->tbl_CounterDocNumber, [
                'CurrDocNumber' => $newCount,
            ]);

            $string = substr(str_repeat(0, $length) . $newCount, -$length);
            $identity_number = date("y") . date("m") . $string;
        } else {
            $this->db->insert($this->tbl_CounterDocNumber, [
                "TrxName" => $trxName,
                "TrxYear" => date('Y'),
                // "TrxMonth" => date('m'),
                "CurrDocNumber" => 1,
            ]);
            $newCount = 1;
            $string = substr(str_repeat(0, $length) . $newCount, -$length);
            $identity_number = date("y") . date("m") . $string;
        }

        return $param . '-' . $identity_number;
    }

    public function Gnrt_Identity_Number_PerMonth($trxName)
    {
        $rows = $this->db->get_where($this->tbl_CounterDocNumber, array(
            "TrxName" => $trxName,
            "TrxYear" => date('Y'),
            "TrxMonth" => intval(date('m')),
        ));
        // TrxName, TrxMonth, TrxYear, TrxDate, CurrDocNumber
        $length = 3;
        if ($rows->num_rows() > 0) {
            $row = $rows->row();
            $newCount = intval($row->CurrDocNumber) + 1;

            $this->db->where('TrxName', $trxName);
            $this->db->where('TrxYear', date('Y'));
            $this->db->where('TrxMonth', intval(date('m')));
            $this->db->update($this->tbl_CounterDocNumber, [
                'CurrDocNumber' => $newCount,
            ]);

            $string = substr(str_repeat(0, $length) . $newCount, -$length);
            $identity_number = $string;
        } else {
            $this->db->insert($this->tbl_CounterDocNumber, [
                "TrxName" => $trxName,
                "TrxYear" => date('Y'),
                "TrxMonth" => intval(date('m')),
                "CurrDocNumber" => 1,
            ]);
            $newCount = 1;
            $string = substr(str_repeat(0, $length) . $newCount, -$length);
            $identity_number = $string;
        }

        return $identity_number;
    }

    public function Counter_Payroll_Number($trxName)
    {
        $rows = $this->db->get_where($this->tbl_CounterDocNumber, array(
            "TrxName" => $trxName,
            "TrxYear" => date('Y'),
            // "month" => date('m'),
        ));
        // TrxName, TrxMonth, TrxYear, TrxDate, CurrDocNumber
        $length = 3;
        if ($rows->num_rows() > 0) {
            $row = $rows->row();
            $newCount = intval($row->CurrDocNumber) + 1;

            $this->db->where('TrxName', $trxName);
            $this->db->where('TrxYear', date('Y'));
            // $this->db->where('TrxMonth', date('m'));
            $this->db->update($this->tbl_CounterDocNumber, [
                'CurrDocNumber' => $newCount,
            ]);

            $string = substr(str_repeat(0, $length) . $newCount, -$length);
            $identity_number = $string;
        } else {
            $this->db->insert($this->tbl_CounterDocNumber, [
                "TrxName" => $trxName,
                "TrxYear" => date('Y'),
                // "TrxMonth" => date('m'),
                "CurrDocNumber" => 1,
            ]);
            $newCount = 1;
            $string = substr(str_repeat(0, $length) . $newCount, -$length);
            $identity_number = $string;
        }

        return $identity_number;
    }
}
