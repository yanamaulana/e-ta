<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?= base_url() ?>assets/E-TA_assets/web-logo/favicon.ico" />
<link rel="stylesheet" href="<?= base_url() ?>assets/Bootstrap-print/css/bootstrap.min.css">
<style>
    @page {
        size: A4;
        margin: 30px 30px 30px 30px;
        font-size: 9pt !important;
        font-family: sans-serif;
        background: white;
    }

    /* table {
        page-break-before: always;
    } */

    @media print {
        @page {
            size: A4;
            margin: 30px 30px 30px 30px;
            font-size: 9pt !important;
            font-family: sans-serif;
            background: white;
        }

        table {
            page-break-inside: avoid;
        }
    }

    html,
    body {
        width: 210mm;
        /* height: 205mm; */
        background: #FFF;
        overflow: visible;
    }

    .table-ttd {
        border-collapse: collapse;
        width: 100%;
        font-size: 9pt !important;
        font-weight: bolder;
        /* font-family: sans-serif; */
    }

    input,
    textarea,
    select {
        font-family: inherit;
    }

    .table-ttd {
        border-collapse: collapse;
        width: 10cm;
        font-size: 9pt !important;
    }

    .table-ttd tbody tr,
    .table-ttd tbody tr td {
        /* border: 1px solid black; */
        padding: 2px;
        font-size: 9pt !important;
        font-weight: bold;
    }


    ul,
    li {
        list-style-type: none;
        font-size: 9pt !important;
    }
</style>

<head>
    <title>Print Slip Gaji <?= $Event->Tot_Employee_Calculated ?> Karyawan : <?= date("d F Y", strtotime($Event->Tgl_Dari))  ?> S/d
        <?= date("d F Y", strtotime($Event->Tgl_Sampai)) ?>
    </title>
</head>

<?php
function rupiah($angka)
{
    $hasil_rupiah = 'Rp. ' . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<body>
    <?php foreach ($Hdrs as $Hdr) : ?>
        <br>
        <p class="text-center font-weight-bold" style="width: 10cm; font-size: 9pt;"><?= $identity->Extra ?><br><?= $identity->Address ?></p>
        <hr style="border: solid black 1px; width: 10cm; margin: 0px;">
        <hr style="border: solid black 1px; width: 10cm; margin: 2px 0px 0px 0px;">

        <table class="table-ttd" style="margin: 5px 0px 5px 0px;">
            <tbody>
                <tr>
                    <td colspan="3" class="text-center">SLIP GAJI <?php if ($Event->Payment_Status == 1) : ?> <i>(LEGITIMATE)</i> <?php else : ?> [DRAFT] <?php endif; ?></td>
                </tr>
                <tr>
                    <td>NAMA</td>
                    <td>:</td>
                    <td><?= $Hdr->Nama ?> [<?= $Hdr->NIK ?>]</td>
                </tr>
                <tr>
                    <td>PERIODE</td>
                    <td>:</td>
                    <td><?= date("d F Y", strtotime($Event->Tgl_Dari))  ?> S/d <?= date("d F Y", strtotime($Event->Tgl_Sampai)) ?></td>
                </tr>
            </tbody>
        </table>

        <hr style="border: solid black 1px; width: 10cm; margin: 0px;">
        <hr style="border: solid black 1px; width: 10cm; margin: 2px 0px 0px 0px;">

        <table class="table-ttd" style="margin: 5px 0px 5px 0px;">
            <thead>
                <tr>
                    <td>No.</td>
                    <td>Deskripsi</td>
                    <td>Jumlah</td>
                    <td>Nilai Pokok</td>
                    <td>Sub Total</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Gaji Pokok</td>
                    <td><?= ($Hdr->Include_Gaji == 1) ? '1' : '-' ?></td>
                    <td><?= rupiah(floatval($Hdr->Gaji)) ?></td>
                    <td><?= rupiah(floatval($Hdr->Gaji)) ?></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Tunjangan Jabatan</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>➤</td>
                    <td><?= ucwords(strtolower($Hdr->Label_Tunjangan_Jabatan_1)) ?></td>
                    <td><?= ($Hdr->Tunjangan_Jabatan_1 != 0) ? '1' : '-' ?></td>
                    <td><?= rupiah(floatval($Hdr->Tunjangan_Jabatan_1)) ?></td>
                    <td><?= rupiah(floatval($Hdr->Tunjangan_Jabatan_1)) ?></td>
                </tr>
                <tr>
                    <td>➤</td>
                    <td><?= ucwords(strtolower($Hdr->Label_Tunjangan_Jabatan_2)) ?></td>
                    <td><?= ($Hdr->Tunjangan_Jabatan_2 != 0) ? '1' : '-' ?></td>
                    <td><?= rupiah(floatval($Hdr->Tunjangan_Jabatan_2)) ?></td>
                    <td><?= rupiah(floatval($Hdr->Tunjangan_Jabatan_2)) ?></td>
                </tr>
                <tr>
                    <td>➤</td>
                    <td><?= ucwords(strtolower($Hdr->Label_Tunjangan_Jabatan_3)) ?></td>
                    <td><?= ($Hdr->Tunjangan_Jabatan_3 != 0) ? '1' : '-' ?></td>
                    <td><?= rupiah(floatval($Hdr->Tunjangan_Jabatan_3)) ?></td>
                    <td><?= rupiah(floatval($Hdr->Tunjangan_Jabatan_3)) ?></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Piket</td>
                    <td> <?= $Hdr->Jumlah_Waktu_Piket ?></td>
                    <td><?= rupiah($Payment_Piket->Nominal) ?></td>
                    <td><?= rupiah($Hdr->Nominal_Piket) ?></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Upacara</td>
                    <td> <?= $Hdr->Jumlah_Upacara ?></td>
                    <td>Rp. -</td>
                    <td><?= rupiah($Hdr->Nominal_Upacara) ?></td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td><?= $Hdr->Label_Tunjangan_Pokok ?></td>
                    <td><?= floatval($Hdr->Total_Jam_Beridiri) ?> Jam</td>
                    <td><?= rupiah($Hdr->Tunjangan_Pokok) ?></td>
                    <td><?= rupiah($Hdr->Nominal_Jam_Berdiri) ?></td>
                </tr>
                <tr>
                    <td>➤</td>
                    <td>Daring</td>
                    <td>&nbsp;</td>
                    <td>Rp. -</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>K. Rapat</td>
                    <td><?= floatval($Hdr->Jumlah_Rapat) ?></td>
                    <td><?= rupiah($Payment_Rapat->Nominal) ?></td>
                    <td><?= rupiah($Hdr->Rapat) ?></td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td><?= 'Lembur' ?></td>
                    <td><?= floatval($Hdr->Total_Jam_Lembur) ?> Jam</td>
                    <td>Rp. -</td>
                    <td><?= rupiah($Hdr->Nominal_Lembur) ?></td>
                </tr>
                <tr style="border-top: solid black 2px;">
                    <td>8</td>
                    <td>JUMLAH</td>
                    <td></td>
                    <td class="text-right">:</td>
                    <td><?= rupiah($Hdr->Nominal_Jam_Berdiri + $Hdr->Gaji + $Hdr->Nominal_Lembur + $Hdr->Nominal_Piket + $Hdr->Nominal_Upacara + $Hdr->Tunjangan_Jabatan_1 + $Hdr->Tunjangan_Jabatan_2 + $Hdr->Tunjangan_Jabatan_3 + $Hdr->Rapat) ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <!-- ================================== START POTONGAN ============================ -->
                <tr>
                    <td>9</td>
                    <td>Kasbon</td>
                    <td><?= $Hdr->Include_Angsuran_Kasbon ?></td>
                    <td><?= rupiah($Hdr->Nominal_Angsuran_Kasbon) ?></td>
                    <td><?= rupiah($Hdr->Nominal_Angsuran_Kasbon) ?></td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>PGRI</td>
                    <td>1</td>
                    <td><?= rupiah($Hdr->Nominal_Potongan_Keanggotaan_Pgri) ?></td>
                    <td><?= rupiah($Hdr->Nominal_Potongan_Keanggotaan_Pgri) ?></td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>KOPERASI</td>
                    <td>1</td>
                    <td><?= rupiah($Hdr->Nominal_Angsuran_Utang_Koperasi) ?></td>
                    <td><?= rupiah($Hdr->Nominal_Angsuran_Utang_Koperasi) ?></td>
                </tr>
                <!-- <tr>
                    <td>12</td>
                    <td>BJB 2</td>
                    <td>&nbsp;</td>
                    <td>Rp. -</td>
                    <td>Rp. -</td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>BJB 3</td>
                    <td>&nbsp;</td>
                    <td>Rp. -</td>
                    <td>Rp. -</td>
                </tr> -->
                <!-- ================ TOTAL SETELAH DI POTONG =================-->
                <tr style="border-top: solid black 2px;">
                    <td>14</td>
                    <td>JUMLAH</td>
                    <td></td>
                    <td class="text-right">:</td>
                    <td><?= rupiah(($Hdr->Nominal_Jam_Berdiri + $Hdr->Gaji + $Hdr->Nominal_Lembur + $Hdr->Nominal_Piket + $Hdr->Nominal_Upacara + $Hdr->Tunjangan_Jabatan_1 + $Hdr->Tunjangan_Jabatan_2 + $Hdr->Tunjangan_Jabatan_3 + $Hdr->Rapat) - ($Hdr->Nominal_Angsuran_Kasbon + $Hdr->Nominal_Potongan_Keanggotaan_Pgri + $Hdr->Nominal_Angsuran_Utang_Koperasi)) ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table-ttd" style="margin: 5px 0px 5px 0px;">
            <tbody>
                <tr>
                    <td class="text-center"></td>
                    <td class="text-right pr-4"><?= ($Event->Payment_Status_Change_at == null) ? '[DRAFT]' : 'Gandoang, ' . tgl_indo($Event->Payment_Status_Change_at); ?></td>
                </tr>
                <tr>
                    <td class="text-center">Menyetujui</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td class="text-center">Kepala Sekolah</td>
                    <td class="text-center">TU. Keuangan</td>
                </tr>
                <tr>
                    <td class="text-center">[DIGITAL SIGN]</td>
                    <td class="text-center">[DIGITAL SIGN]</td>
                </tr>
                <tr>
                    <td class="text-center"><u>Taufik Rusmayana, M. Pd.</u></td>
                    <td class="text-center"><u>Mei Citra S, S.E.</u></td>
                </tr>
            </tbody>
        </table>
        <table style="page-break-before: always; border: none;"></table>
    <?php endforeach; ?>
</body>

</html>
<script>
    setTimeout(window.print(), 2000);
</script>