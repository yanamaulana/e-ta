<div class="modal hide fade" id="Modal-Detail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="table-title-detail">List Peserta Rapat : <?= $Hdr->No_Meeting ?></h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times"></i></span>
                </div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="No_Meeting" value="<?= $Hdr->No_Meeting ?>">
                <input type="hidden" id="Role" value="<?= $Role ?>">
                <div class="pb-5 table-responsive">
                    <table id="Table-Detail" style="width: 100%;" class="table-sm align-middle display compact dt-nowrap table-rounded table-bordered border gy-5 gs-5">
                        <thead style="background-color: #3B6D8C;">
                            <tr class="text-start text-white fw-bolder text-uppercase">
                                <th class="text-center align-middle text-white">#</th>
                                <th class="text-center align-middle text-white">Nama Peserta</th>
                                <th class="text-center align-middle text-white">Tunjangan Rapat</th>
                                <th class="text-center align-middle text-white">Waktu Join</th>
                                <th class="text-center align-middle text-white">Status</th>
                                <th class="text-center align-middle text-white"><i class="fas fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>

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

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(number);
        }

        $("#Table-Detail").DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            paging: true,
            dom: 'lBfrtip',
            orderCellsTop: true,
            fixedHeader: {
                header: true,
                headerOffset: 48
            },
            "lengthMenu": [
                [15, 30, 90, 1000],
                [15, 30, 90, 1000]
            ],
            ajax: {
                url: $('meta[name="base_url"]').attr('content') + "Rapat/DT_Peserta_Rapat",
                dataType: "json",
                type: "POST",
                data: {
                    No_Meeting: $('#No_Meeting').val()
                }
            },
            columns: [{
                    data: "No_Meeting_Hdr",
                    name: "No_Meeting_Hdr",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "Nama",
                    name: "Nama",
                },
                {
                    data: "Nominal_Tunjangan",
                    name: "Nominal_Tunjangan",
                    render: function(data) {
                        return rupiah(data);
                    }
                },
                {
                    data: "Join_at",
                    name: "Join_at",
                },
                {
                    data: "Calculated",
                    name: "Calculated",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        if (data == 1) {
                            return `<button class="badge badge-success btn-sm"><i class="fas fa-check"></i> Paid</button>`;
                        } else {
                            return `<button class="badge badge-secondary btn-sm"><i class="fas fa-hourglass-half"></i> Un-Paid</button>`;
                        }
                    }
                },
                {
                    data: "Join_by",
                    name: "Join_by",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        if (row.Calculated == 1) {
                            return `<button class="badge badge-success btn-sm"><i class="fas fa-check"></i> Paid</button>`;
                        } else {
                            return `<button  class="btn btn-danger btn-sm btn-delete-dtl" data-toggle="tooltip" title="Hapus Keikutsertaan"><i class="fas fa-trash"></i></button>`;
                        }
                    }
                }
            ],
            order: [
                [3, "DESC"]
            ],
            columnDefs: [{
                className: "align-middle text-center",
                targets: [0, 1, 2, 3, 4, 5],
            }],
            autoWidth: false,
            responsive: true,
            "rowCallback": function(row, data) {
                // if (data.Approve == "0") {
                // $('td', row).css('background-color', 'pink');
                // }
            },
            preDrawCallback: function() {
                $("#TableData tbody td").addClass("blurry");
            },
            language: {
                processing: '<i style="color:#4a4a4a" class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><p><span style="color:#4a4a4a" style="text-align:center" class="loading-text"></span> ',
                searchPlaceholder: "Search..."
            },
            drawCallback: function() {
                $("#Table-Detail tbody td").addClass("blurry");
                $('[data-toggle="tooltip"]').tooltip();
            },
            initComplete: function() {
                var api = this.api();
                $("#Table-Detail tbody td").removeClass("blurry");
                if ($('#Role').val() != 'Administrator') {
                    api.column(5).visible(false);
                }
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

        $(document).on('click', '.btn-delete-dtl', function() {
            let data = $("#Table-Detail").DataTable().row($(this).parents('tr')).data();
            let SysId = data.SysId;
            let nama = data.Nama;
            Swal.fire({
                title: 'System message!',
                text: `Apakah anda yakin untuk menghapus kepesertaan : ${nama}, Data tidak dapat dikembalikan !`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $('meta[name="base_url"]').attr('content') + "Rapat/Delete_Dtl",
                        type: "post",
                        dataType: "json",
                        data: {
                            SysId: SysId
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Loading....',
                                html: '<div class="spinner-border text-primary"></div>',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            })
                        },
                        success: function(response) {
                            if (response.code == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.msg,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, Confirm!'
                                })
                                $("#TableData").DataTable().ajax.reload();
                                $("#Table-Detail").DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.msg,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, Confirm!',
                                    footer: '<a href="javascript:void(0)">Notification System</a>'
                                });
                            }
                        },
                        error: function() {
                            Swal.close()
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'A error occured, please report this error to administrator !',
                                footer: '<a href="javascript:void(0)">Notification System</a>'
                            });
                        }
                    });
                }
            })
        })
    })
</script>