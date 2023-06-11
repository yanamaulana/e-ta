<div class="modal hide fade" id="Modal-Detail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="table-title-detail">List Angsuran dan Kasbon : <?= $Hdr->Nama ?></h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times"></i></span>
                </div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ID" value="<?= $Hdr->ID ?>">
                <div class="pb-5 table-responsive">
                    <table id="Table-Detail" style="width: 100%;" class="table-sm align-middle display compact dt-nowrap table-rounded table-bordered border gy-5 gs-5">
                        <thead style="background-color: #3B6D8C;">
                            <tr class="text-start text-white fw-bolder text-uppercase">
                                <th class="text-center text-white">#</th>
                                <th class="text-center text-white">TANGGAL</th>
                                <th class="text-center text-white">IN/OUT</th>
                                <th class="text-center text-white">ARITMATIK</th>
                                <th class="text-center text-white">NOMINAL SEBELUMNYA</th>
                                <th class="text-center text-white">NOMINAL SETELAH</th>
                                <th class="text-center text-white">REMARK SYSTEM</th>
                                <th class="text-center text-white">CATATAN</th>
                                <th class="text-center text-white">NOMOR SLIP</th>
                                <th class="text-center text-white">DATE TIME</th>
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
                url: $('meta[name="base_url"]').attr('content') + "PotonganKasbon/DT_List_Trx_Employee",
                dataType: "json",
                type: "POST",
                data: {
                    ID: $('#ID').val()
                }
            },
            columns: [{
                    data: "SysId",
                    name: "SysId",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "Tgl_Tran",
                    name: "Tgl_Tran",
                    orderable: false,
                },
                {
                    data: "IN_OUT",
                    name: "IN_OUT",
                    orderable: false,
                    render: function(data) {
                        return rupiah(data);
                    }
                },
                {
                    data: "Aritmatics",
                    name: "Aritmatics",
                    orderable: false,
                },
                {
                    data: "Saldo_Before",
                    name: "Saldo_Before",
                    orderable: false,
                    render: function(data) {
                        return rupiah(data);
                    }
                }, {
                    data: "Saldo_After",
                    name: "Saldo_After",
                    orderable: false,
                    render: function(data) {
                        return rupiah(data);
                    }
                },
                {
                    data: "Remark_System",
                    name: "Remark_System",
                    orderable: false,
                },
                {
                    data: "Note",
                    name: "Note",
                    orderable: false,
                },
                {
                    data: "Tag_Hdr",
                    name: "Tag_Hdr",
                    orderable: false,
                },
                {
                    data: "Created_at",
                    name: "Created_at",
                    visible: false,
                },

            ],
            order: [
                [9, "DESC"]
            ],
            columnDefs: [{
                className: "align-middle text-center",
                targets: [0, 1, 3, 6, 7, 8],
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
                title: $('#table-title-modal').text() + '--' + moment().format("YYYY-MM-DD"),
                className: "btn btn-light-success",
            }, {
                text: `<i class="far fa-file-pdf fs-2"></i>`,
                extend: 'pdfHtml5',
                title: $('#table-title-modal').text() + '--' + moment().format("YYYY-MM-DD"),
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