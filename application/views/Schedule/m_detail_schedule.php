<div class="modal hide fade" id="Modal-Detail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="table-title-detail">Detail Jadwal Mengajar, <?= $Hdr->Nama ?> : <?= $Hdr->Schedule_Number ?></h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times"></i></span>
                </div>
            </div>
            <div class="modal-body">
                <div class="pb-5 table-responsive">
                    <table id="Table-Detail" style="width: 100%;" class="table-sm align-middle display compact dt-nowrap table-rounded table-bordered border gy-5 gs-5">
                        <thead style="background-color: #3B6D8C;">
                            <tr class="text-start text-white fw-bolder text-uppercase">
                                <th class="text-center text-white">#</th>
                                <th class="text-center text-white">HARI</th>
                                <th class="text-center text-white">KELAS</th>
                                <th class="text-center text-white">MAPEL</th>
                                <th class="text-center text-white">MULAI PADA</th>
                                <th class="text-center text-white">SELESAI PADA</th>
                                <th class="text-center text-white">JAM BERDIRI</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark fw-bold" id="tbody">
                            <?php $i = 1; ?>
                            <?php foreach ($Dtls as $dtl) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $dtl->Hari ?></td>
                                    <td><?= $dtl->Kelas ?></td>
                                    <td><?= $dtl->Mata_Pelajaran ?></td>
                                    <td><?= $dtl->Start_Time ?></td>
                                    <td><?= $dtl->Time_Over ?></td>
                                    <td><?= floatval($dtl->Stand_Hour) ?></td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach ?>
                        </tbody>

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
            dom: 'Bfrtip',
            orderCellsTop: true,
            // select: true,
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
                targets: [0, 1, 2, 3, 4, 5, 6],
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