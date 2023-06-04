<div class="modal fade show" data-bs-backdrop="static" data-bs-keyboard="false" data-backdrop="static" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update/Edit Overtime Data : <?= $lembur->Nama ?></h4>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times fs-2"></i></span>
                </div>
            </div>
            <form class="form-horizontal" id="form-update">
                <input type="hidden" name="sysid" id="sysid" value="<?= $lembur->SysId ?>">
                <div class="modal-body">
                    <div class="container">
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group row">
                                <label for="tanggal" class="col-form-label">Date Over Time :</label>
                                <div class="col-md-12 col-xl-12">
                                    <input type="text" class="form-control date-picker" readonly required id="tanggal" name="tanggal" placeholder="Date Overtime ..." value="<?= $lembur->Tanggal ?>">
                                </div>
                            </div>
                            <div class="form-group row mt-5">
                                <label for="jumlah_jam" class="col-form-label">Total Hours :</label>
                                <div class="col-md-12 col-xl-12">
                                    <select required class="form-select form-control" id="jumlah_jam" name="jumlah_jam">
                                        <option disabled>-Pick Total Hours-</option>
                                        <?php for ($x = 0; $x <= 10; $x++) : ?>
                                            <option <?php if ($lembur->Jumlah_Jam == $x) echo 'selected' ?> value="<?= $x ?>"><?= $x ?> Jam</option>
                                        <?php endfor; ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group row mt-5">
                                <label for="nominal" class="col-form-label">Nominal :</label>
                                <div class="col-md-12 col-xl-12">
                                    <input type="number" min="1000" required class="form-control onlyfloat" value="<?= floatval($lembur->Nominal) ?>" id="nominal" name="nominal" placeholder="Nominal...">
                                </div>
                            </div>
                            <div class="form-group row mt-5">
                                <label for="note" class="col-form-label">Note :</label>
                                <div class="col-md-12 col-xl-12">
                                    <input type="text" class="form-control" value="<?= $lembur->Note ?>" id="note" name="note" placeholder="Note...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type=" button" class="btn btn-primary" id="btn-submit-update">
                        <i class="fas fa-download"></i> &nbsp;Save Change
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {

        $('input[name="tanggal"]').flatpickr({
            dateFormat: "Y-m-d",
            maxDate: "today"
        });

        $('#form-update').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback text-center');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        $.validator.setDefaults({
            debug: true,
            success: 'valid'
        });

        $('#btn-submit-update').click(function(e) {
            e.preventDefault();
            if ($("#form-update").valid()) {
                Swal.fire({
                    title: 'Loading....',
                    html: '<div class="spinner-border text-primary"></div>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
                Fn_Submit_Form($('#form-update').serialize())
            } else {
                $('html, body').animate({
                    scrollTop: ($('.error:visible').offset().top - 200)
                }, 400);
            }
        });

        function Fn_Submit_Form(DataForm) {
            $.ajax({
                dataType: "json",
                type: "POST",
                url: $('meta[name="base_url"]').attr('content') + "OverTime/Store_Update_Overtime",
                data: DataForm,
                success: function(response) {
                    Swal.close()
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success !',
                            text: response.msg,
                            footer: '<a href="javascript:void(0)">Notification System</a>'
                        });
                        $('#TableData').DataTable().ajax.reload(null, false);
                        $("#Modal-Form-Edit").modal('hide');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.msg,
                            footer: '<a href="javascript:void(0)">Notification System</a>'
                        });
                    }
                },
                error: function() {
                    Swal.close()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan teknis segera lapor pada admin!',
                        footer: '<a href="javascript:void(0)">Notification System</a>'
                    });
                }
            });
        }
    })
</script>