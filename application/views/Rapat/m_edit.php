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
                <h4 class="modal-title">Edit Data Petugas Upacara : <?= $data->No_Meeting ?></h4>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times fs-2"></i></span>
                </div>
            </div>
            <form class="form-horizontal" id="form-update">
                <input type="hidden" name="sysid" id="sysid" value="<?= $data->SysId ?>">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group py-3">
                                    <label for="tanggal" class="col-form-label">Tanggal Rapat :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" readonly required id="tanggal" name="tanggal" value="<?= $data->Meeting_Date ?>" placeholder="Date Over Time ...">
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Waktu Rapat Mulai :</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="start" name="start" value="<?= substr($data->Time_Start, 0, 5) ?>" placeholder="Waktu Mulai Rapat...">
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Tema Rapat :</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="tema" name="tema" value="<?= $data->Theme ?>" placeholder="Tema Rapat...">
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="note" class="col-form-label">Note/Catatan :</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" id="note" name="note" placeholder="Note..."><?= $data->Note ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group py-3">
                                    <label for="jumlah_jam" class="col-form-label">Ketua Rapat :</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control select2" id="ketua_rapat" name="ketua_rapat">
                                            <option selected value="<?= $data->Leader ?>"><?= $data->Leader_Name ?></option>
                                            <?php foreach ($Employees as $li) :  ?>
                                                <option value="<?= $li->UserName ?>"><?= $li->Nama ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Waktu Rapat Selesai :</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="end" name="end" value="<?= substr($data->Time_End, 0, 5) ?>" placeholder="Waktu Rapat Selesai...">
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Ruangan Rapat :</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="ruangan" name="ruangan" value="<?= $data->Meeting_Room ?>" placeholder="Ruangan Rapat...">
                                    </div>
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
            static: true,
        });

        $('input[name="start"]').flatpickr({
            dateFormat: "H:i",
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            static: true,
        });

        $('input[name="end"]').flatpickr({
            dateFormat: "H:i",
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            static: true,
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
                url: $('meta[name="base_url"]').attr('content') + "Rapat/Update",
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