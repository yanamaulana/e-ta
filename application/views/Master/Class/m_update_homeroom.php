<div class="modal hide fade" id="modal-update" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- style="max-width: 70%;" -->
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">UPDATE HOMEROOM TEACHER, CLASS : <?= $class->Kelas ?></h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times fs-2"></i></span>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_update" method="post">
                    <div class="row">
                        <input type="hidden" name="SysId" id="SysId" value="<?= $class->SysId ?>">
                        <div class="col-xl-12 col-md-12">
                            <div class="fv-row mb-5">
                                <label class="form-label">Class Name :</label>
                                <input type="text" required class="form-control" id="Kelas" name="Kelas" disabled placeholder="Class Name...">
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="fv-row mb-5">
                                <label class="form-label">HomeRoom Teacher :</label>
                                <select required class="form-select form-control" id="Employe_ID_Wali_Kelas" name="Employe_ID_Wali_Kelas">
                                    <option selected disabled value="">-Homeroom Teacher-</option>
                                    <?php foreach ($Teachers as $teacher) : ?>
                                        <option <?php if ($class->Employe_ID_Wali_Kelas == $teacher->SysId) echo 'selected' ?> value="<?= $teacher->SysId ?>"><?= $teacher->Nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-warning">
                <button type="button" id="submit--update" class="btn btn-primary float-start"><i class="far fa-save"></i> Submit</button>
                <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
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

        $('#form_update').validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.fv-row').append(error);
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

        $('#submit--update').click(function(e) {
            e.preventDefault();
            if ($("#form_update").valid()) {
                Swal.fire({
                    title: 'System Message !',
                    text: `Are you sure to update this data ?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Init_Submit_Form($('#form_update'))
                    }
                })
            } else {
                $('html, body').animate({
                    scrollTop: ($('.error:visible').offset().top - 200)
                }, 400);
            }
        });

        function Init_Submit_Form(DataForm) {
            let BtnAction = $('#submit--update');
            $.ajax({
                dataType: "json",
                type: "POST",
                url: $('meta[name="base_url"]').attr('content') + "Master/Store_Update_Homeroom_Teacher",
                data: DataForm.serialize(),
                beforeSend: function() {
                    BtnAction.prop("disabled", true);
                    Swal.fire({
                        title: 'Loading....',
                        html: '<div class="spinner-border text-primary"></div>',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    })
                },
                success: function(response) {
                    Swal.close()
                    if (response.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: response.msg
                        });
                        $('#modal-update').modal('hide');
                        $("#TableData").DataTable().ajax.reload(null, false);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.msg
                        });
                    }
                    BtnAction.prop("disabled", false);
                },
                error: function() {
                    Swal.close()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'A error occured, please report this error to administrator !',
                        footer: '<a href="javascript:void(0)">Notifikasi System</a>'
                    });
                    BtnAction.prop("disabled", false);
                }
            });
        }
    })
</script>