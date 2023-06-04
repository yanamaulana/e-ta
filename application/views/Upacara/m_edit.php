<?php
function rupiah($angka)
{
    $hasil_rupiah = 'Rp. ' . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
} ?>
<div class="modal fade show" id="Modal-Form-Edit" data-bs-backdrop="static" data-bs-keyboard="false" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Petugas Upacara : <?= $data->Nama ?></h4>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times fs-2"></i></span>
                </div>
            </div>
            <form class="form-horizontal" id="form-update">
                <input type="hidden" name="sysid" id="sysid" value="<?= $data->SysId ?>">
                <div class="modal-body">
                    <div class="container">
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group row">
                                <label for="tanggal" class="col-form-label">Tanggal Upacara :</label>
                                <div class="col-md-12 col-xl-12">
                                    <input type="text" class="form-control date-picker" readonly required id="tanggal" name="tanggal" placeholder="Tanggal Upacara ..." value="<?= $data->Tanggal ?>">
                                </div>
                            </div>
                            <div class="form-group row mt-5">
                                <label for="jumlah_jam" class="col-form-label">Jabatan Upacara :</label>
                                <div class="col-md-12 col-xl-12">
                                    <select required class="form-select select2" id="jabatan_upacara" name="jabatan_upacara">
                                        <option selected disabled>-Pilih Jabatan Upacara-</option>
                                        <?php foreach ($Jabatan_Upacara as $li) : ?>
                                            <option <?php if ($li->Code == $data->Jabatan_Upacara) echo 'selected' ?> value="<?= $li->Code ?>"><?= $li->Code . ' (' . rupiah($li->Nominal) . ')' ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-12">
                            <div class="form-group row mt-5">
                                <label for="nominal" class="col-form-label">Nominal :</label>
                                <div class="col-md-12 col-xl-12">
                                    <input type="number" min="1000" readonly required class="form-control onlyfloat" value="<?= floatval($data->Nominal) ?>" id="nominal" name="nominal" placeholder="Nominal...">
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
                url: $('meta[name="base_url"]').attr('content') + "Upacara/Update",
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