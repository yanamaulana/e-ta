<div class="modal hide fade" id="modal-update" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- style="max-width: 70%;" -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FORM UPDATE SALARY : <?= $data->Nama ?></h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times"></i></span>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_update" method="post">
                    <div class="row">
                        <input type="hidden" name="SysId" id="SysId" value="<?= $SysId ?>">
                        <div class="col-xl-12 col-md-12">
                            <div class="fv-row mb-5">
                                <label class="form-label">Status Karyawan :</label>
                                <select class="form-select form-select-solid form-control" disabled data-placeholder="Select an option" id="Fk_Work_Status" name="Fk_Work_Status">
                                    <option selected disabled>-Select an option-</option>
                                    <?php foreach ($works_status as $ws) : ?>
                                        <option <?php if ($data->Fk_Work_Status == $ws->SysId) echo "selected" ?> value="<?= $ws->SysId ?>"><?= $ws->Work_Status ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Jabtan Office :</label>
                                <select class="form-select form-select-solid form-control" disabled data-placeholder="Select an option" id="Fk_Jabatan" name="Fk_Jabatan">
                                    <option selected disabled>-Select an option-</option>
                                    <?php foreach ($jabatans as $jab) : ?>
                                        <option <?php if ($data->Fk_Jabatan == $jab->SysId) echo "selected" ?> value="<?= $jab->SysId ?>"><?= $jab->Jabatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Gaji Pokok :</label>
                                <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Salary" name="Fk_Salary">
                                    <option selected disabled>-Select an option-</option>
                                    <?php foreach ($salarys as $gaji) : ?>
                                        <option <?php if ($data->Fk_Salary == $gaji->SysId) echo "selected" ?> value="<?= $gaji->SysId ?>"><?= $gaji->Kode_Salary ?> (<?= $this->help->format_idr($gaji->Nominal) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" value="1" <?php if ($data->Fk_Tunjangan_Pokok == 1) echo 'checked' ?> role="switch" id="Stand_Hour" name="Stand_Hour">
                                    <label class="form-check-label" for="flexSwitchCheckDefault" style="font-weight: 500;"><span class="text-danger">?</span> Stand Hour Allowance</label>
                                </div>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Tunjangan Jabatan 1 :</label>
                                <select class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Tunjangan_Jabatan_1" name="Fk_Tunjangan_Jabatan_1">
                                    <option selected disabled>-Select an option-</option>
                                    <option selected <?php if ($data->Fk_Tunjangan_Jabatan_1 == 0) echo 'selected' ?> value="0">TIDAK ADA</option>
                                    <?php foreach ($tunjangans as $tunjangan) : ?>
                                        <option <?php if ($data->Fk_Tunjangan_Jabatan_1 == $tunjangan->SysId) echo "selected" ?> value="<?= $tunjangan->SysId ?>"><?= $tunjangan->Nama ?> (<?= $this->help->format_idr($tunjangan->Nominal) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Tunjangan Jabatan 2 :</label>
                                <select class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Tunjangan_Jabatan_2" name="Fk_Tunjangan_Jabatan_2">
                                    <option selected disabled>-Select an option-</option>
                                    <option selected <?php if ($data->Fk_Tunjangan_Jabatan_2 == 0) echo 'selected' ?> value="0">TIDAK ADA</option>
                                    <?php foreach ($tunjangans as $tunjangan) : ?>
                                        <option <?php if ($data->Fk_Tunjangan_Jabatan_2 == $tunjangan->SysId) echo "selected" ?> value="<?= $tunjangan->SysId ?>"><?= $tunjangan->Nama ?> (<?= $this->help->format_idr($tunjangan->Nominal) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Tunjangan Jabatan 3 :</label>
                                <select class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Tunjangan_Jabatan_3" name="Fk_Tunjangan_Jabatan_3">
                                    <option selected disabled>-Select an option-</option>
                                    <option selected <?php if ($data->Fk_Tunjangan_Jabatan_3 == 0) echo 'selected' ?> value="0">TIDAK ADA</option>
                                    <?php foreach ($tunjangans as $tunjangan) : ?>
                                        <option <?php if ($data->Fk_Tunjangan_Jabatan_3 == $tunjangan->SysId) echo "selected" ?> value="<?= $tunjangan->SysId ?>"><?= $tunjangan->Nama ?> (<?= $this->help->format_idr($tunjangan->Nominal) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Tunjangan Lain-Lain :</label>
                                <select class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Tunjangan_LainLain" name="Fk_Tunjangan_LainLain">
                                    <option selected disabled>-Select an option-</option>
                                    <option selected <?php if ($data->Fk_Tunjangan_LainLain == 0) echo 'selected' ?> value="0">TIDAK ADA</option>
                                    <?php foreach ($tunjangans as $tunjangan) : ?>
                                        <option <?php if ($data->Fk_Tunjangan_LainLain == $tunjangan->SysId) echo "selected" ?> value="<?= $tunjangan->SysId ?>"><?= $tunjangan->Nama ?> (<?= $this->help->format_idr($tunjangan->Nominal) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="submit--update" class="btn btn-primary float-start"><i class="far fa-save"></i> Save changes</button>
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
            dropdownParent: $('#modal-update #form_update')
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
                    text: `Are you sure to update employee salary data ?`,
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
                url: $('meta[name="base_url"]').attr('content') + "ManageSalary/Store_Update_Employee_Salary",
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