<div class="modal hide fade" id="Modal-Detail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="table-title-detail">Rincian Payroll <?= $Hdr->Nama ?> (<?= $Hdr->TagID_PerNIK ?>)</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times"></i></span>
                </div>
            </div>
            <div class="modal-body">
                <div class="pb-5 table-responsive">
                    <table id="Table-Detail" style="width: 100%;" class="table-sm align-middle display compact dt-nowrap table-rounded table-bordered border gy-5 gs-5">
                        <thead style="background-color: #3B6D8C;">
                            <tr class="text-start text-white fw-bolder text-uppercase">
                                <th class="text-center align-middle text-uppercase text-white">#</th>
                                <th class="text-center align-middle text-uppercase text-white">Tanggal</th>
                                <th class="text-center align-middle text-uppercase text-white">Jumlah Tap</th>
                                <th class="text-center align-middle text-uppercase text-white">Jumlah Jam</th>
                                <th class="text-center align-middle text-uppercase text-white">$ Jam berdiri</th>
                                <th class="text-center align-middle text-uppercase text-white">Jumlah Piket</th>
                                <th class="text-center align-middle text-uppercase text-white">$ Piket</th>
                                <th class="text-center align-middle text-uppercase text-white">$ Upacara</th>
                                <th class="text-center align-middle text-uppercase text-white">Jabatan Upacara</th>
                                <th class="text-center align-middle text-uppercase text-white">Tunjangan Lain</th>
                                <th class="text-center align-middle text-uppercase text-white">Jumlah Jam Lembur</th>
                                <th class="text-center align-middle text-uppercase text-white">Nominal Lembur</th>
                                <th class="text-center align-middle text-uppercase text-white">Jumlah Rapat</th>
                                <th class="text-center align-middle text-uppercase text-white">$ Rapat</th>
                            </tr>
                        </thead>
                        <?php function rupiah($angka)
                        {
                            $hasil_rupiah = 'Rp. ' . number_format($angka, 0, ',', '.');
                            return $hasil_rupiah;
                        } ?>
                        <tbody class="text-dark fw-bold">
                            <?php
                            $i = 1;
                            $Total_Att = 0;
                            $Total_Hours = 0;
                            $Tunjangan_Pokok = 0;
                            $Jumlah_Piket = 0;
                            $Piket = 0;
                            $Upacara = 0;
                            $Tunjangan_Lain = 0;
                            $Jam_Lembur = 0;
                            $Lembur = 0;
                            $Jumlah_Rapat = 0;
                            $Rapat = 0;
                            ?>
                            <?php foreach ($Dtls as $dtl) : ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $dtl->Tanggal ?></td>
                                    <td><?= floatval($dtl->Total_Att) ?></td>
                                    <td><?= floatval($dtl->Total_Hours) ?></td>
                                    <td><?= rupiah($dtl->Tunjangan_Pokok) ?></td>
                                    <td><?= $dtl->Jumlah_Piket ?></td>
                                    <td><?= rupiah($dtl->Piket) ?></td>
                                    <td><?= rupiah($dtl->Upacara) ?></td>
                                    <td><?= $dtl->Jabatan_Upacara ?></td>
                                    <td><?= rupiah($dtl->Tunjangan_Lain) ?></td>
                                    <td><?= floatval($dtl->Jam_Lembur) ?></td>
                                    <td><?= rupiah($dtl->Lembur) ?></td>
                                    <td><?= $dtl->Jumlah_Rapat ?></td>
                                    <td><?= rupiah($dtl->Rapat) ?></td>
                                </tr>
                                <?php
                                $i++;
                                $Total_Att += floatval($dtl->Total_Att);
                                $Total_Hours += floatval($dtl->Total_Hours);
                                $Tunjangan_Pokok += floatval($dtl->Tunjangan_Pokok);
                                $Piket += floatval($dtl->Piket);
                                $Jumlah_Piket += floatval($dtl->Jumlah_Piket);
                                $Upacara += floatval($dtl->Upacara);
                                $Tunjangan_Lain += floatval($dtl->Tunjangan_Lain);
                                $Jam_Lembur += floatval($dtl->Jam_Lembur);
                                $Lembur += floatval($dtl->Lembur);
                                $Jumlah_Rapat += floatval($dtl->Jumlah_Rapat);
                                $Rapat += floatval($dtl->Rapat);
                                ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot style="background-color: #3B6D8C;" class="text-white fw-bold">
                            <tr>
                                <td>#</td>
                                <td><i class="fas fa-calendar text-white"></i></td>
                                <td><?= floatval($Total_Att) ?> Tap</td>
                                <td><?= floatval($Total_Hours) ?> JAM</td>
                                <td><?= rupiah($Tunjangan_Pokok) ?></td>
                                <td><?= $Jumlah_Piket ?></td>
                                <td><?= rupiah($Piket) ?></td>
                                <td><?= rupiah($Upacara) ?></td>
                                <td>-</td>
                                <td><?= rupiah($Tunjangan_Lain) ?></td>
                                <td><?= floatval($Jam_Lembur) ?> JAM</td>
                                <td><?= rupiah($Lembur) ?></td>
                                <td><?= $Jumlah_Rapat ?></td>
                                <td><?= rupiah($Rapat) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {
        $('select').select2({
            dropdownParent: $('#Modal-Detail .modal-body')
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        var TableData = $("#Table-Detail").DataTable({
            destroy: true,
            // processing: true,
            // serverSide: true,
            paging: true,
            dom: 'lBfrtip',
            orderCellsTop: true,
            select: true,
            fixedHeader: {
                header: true,
                headerOffset: 48
            },
            "lengthMenu": [
                [1000],
                [1000]
            ],
            columnDefs: [{
                className: "align-middle text-center",
                targets: [0, 1, 6, 8],
            }],
            autoWidth: false,
            responsive: true,
            // "rowCallback": function(row, data) {
            //     if (data.is_active == "0") {
            //         $('td', row).css('background-color', 'pink');
            //     }
            // },
            preDrawCallback: function() {
                $("#Table-Detail tbody td").addClass("blurry");
            },
            language: {
                processing: '<i style="color:#4a4a4a" class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><p><span style="color:#4a4a4a" style="text-align:center" class="loading-text"></span> ',
                searchPlaceholder: "Search..."
            },
            drawCallback: function() {
                $("#Table-Detail tbody td").addClass("blurry");
                setTimeout(function() {
                    $("#Table-Detail tbody td").removeClass("blurry");
                });
                $('[data-toggle="tooltip"]').tooltip();
            },
            "buttons": [{
                text: `Export to :`,
                className: "btn disabled text-dark bg-white",
            }, {
                text: `<i class="far fa-copy fs-2"></i>`,
                extend: 'copy',
                className: "btn btn-light-warning",
            }, {
                text: `<i class="far fa-file-excel fs-2"></i>`,
                extend: 'excelHtml5',
                footer: true,
                title: $('#table-title-detail').text() + '~' + moment().format("YYYY-MM-DD"),
                className: "btn btn-light-success",
            }, {
                text: `<i class="far fa-file-pdf fs-2"></i>`,
                extend: 'pdfHtml5',
                title: $('#table-title-detail').text() + '~' + moment().format("YYYY-MM-DD"),
                className: "btn btn-light-danger",
                footer: true,
                orientation: "landscape"
            }, {
                text: `<i class="fas fa-print fs-2"></i>`,
                extend: 'print',
                footer: true,
                className: "btn btn-light-dark",
            }],
        }).buttons().container().appendTo('#Table-Detail_wrapper .col-md-6:eq(0)');

    })
</script>