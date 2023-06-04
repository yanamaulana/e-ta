<div class="modal hide fade" id="modal-update" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- style="max-width: 70%;" -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FORM UPDATE : <?= $data->Nama ?></h5>
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
                                <label class="form-label">ID Access Control :</label>
                                <input type="number" required class="form-control" readonly value="<?= $data->ID ?>" id="ID" name="ID" maxlength="3" placeholder="ID Access Control...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">User Name :</label>
                                <input type="text" required class="form-control" readonly value="<?= $data->UserName ?>" id="UserName" name="UserName" minlength="3" maxlength="12" placeholder="User name...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Name :</label>
                                <input type="text" required class="form-control" value="<?= $data->Nama ?>" id="Nama" name="Nama" placeholder="Name...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">KTP :</label>
                                <input type="number" required class="form-control" value="<?= $data->KTP ?>" id="KTP" name="KTP" maxlength="17" placeholder="KTP...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Gender :</label>
                                <select class="form-control" id="Gender" name="Gender" required class="form-select form-control" data-control="select2" data-placeholder="Select an option">
                                    <option></option>
                                    <option <?php if ($data->Gender == 'LAKI-LAKI') echo "selected" ?> value="LAKI-LAKI">LAKI-LAKI</option>
                                    <option <?php if ($data->Gender == 'PEREMPUAN') echo "selected" ?> value="PEREMPUAN">PEREMPUAN</option>

                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Place of Birth :</label>
                                <input type="text" required class="form-control" value="<?= $data->Tempat_Lahir ?>" id="Tempat_Lahir" name="Tempat_Lahir" placeholder="Place of Birth...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Date of Birth :</label>
                                <input type="text" required class="form-control date-picker" value="<?= $data->Tanggal_Lahir ?>" id="Tanggal_Lahir" name="Tanggal_Lahir" placeholder="Date of Birth...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Telephone Number :</label>
                                <input type="text" required class="form-control date-picker" value="<?= $data->Telpon ?>" id="Telpon" name="Telpon" placeholder="Telephone Number...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">E-mail :</label>
                                <input type="email" class="form-control date-picker" value="<?= $data->Email ?>" id="Email" name="Email" placeholder="Email...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Martial Status :</label>
                                <select class="form-control" id="Status_Pernikahan" name="Status_Pernikahan" required class="form-select form-control" data-control="select2" data-placeholder="Select an option">
                                    <option></option>
                                    <option <?php if ($data->Status_Pernikahan == 'LAJANG') echo "selected" ?> value="LAJANG">LAJANG</option>
                                    <option <?php if ($data->Status_Pernikahan == 'MENIKAH') echo "selected" ?> value="MENIKAH">MENIKAH</option>
                                    <option <?php if ($data->Status_Pernikahan == 'CERAI') echo "selected" ?> value="CERAI">CERAI</option>

                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Date Join :</label>
                                <input type="text" required class="form-control date-picker" value="<?= $data->Tanggal_Join ?>" id="Tanggal_Join" name="Tanggal_Join" placeholder="Date Join...">
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Address :</label>
                                <textarea required class="form-control" id="Full_address" name="Full_address" placeholder="Address..."><?= $data->Full_address ?></textarea>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Work Status :</label>
                                <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Work_Status" name="Fk_Work_Status">
                                    <option selected disabled>-Select an option-</option>
                                    <?php foreach ($works_status as $ws) : ?>
                                        <option <?php if ($data->Fk_Work_Status == $ws->SysId) echo "selected" ?> value="<?= $ws->SysId ?>"><?= $ws->Work_Status ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Office Position :</label>
                                <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Jabatan" name="Fk_Jabatan">
                                    <option selected disabled>-Select an option-</option>
                                    <?php foreach ($jabatans as $jab) : ?>
                                        <option <?php if ($data->Fk_Jabatan == $jab->SysId) echo "selected" ?> value="<?= $jab->SysId ?>"><?= $jab->Jabatan ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- <div class="fv-row mb-5">
                                <label class="form-label">Basic Salary :</label>
                                <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Salary" name="Fk_Salary">
                                    <option selected disabled>-Select an option-</option>
                                    <php foreach ($salarys as $gaji) : ?>
                                        <option <php if ($data->Fk_Salary == $gaji->SysId) echo "selected" ?> value="<?= $gaji->SysId ?>"><?= $gaji->Kode_Salary ?> (<?= $this->help->format_idr($gaji->Nominal) ?>)</option>
                                    <php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Allowance :</label>
                                <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Tunjangan_Pokok" name="Fk_Tunjangan_Pokok">
                                    <option selected disabled>-Select an option-</option>
                                    <php foreach ($tunjangans as $tunjangan) : ?>
                                        <option <php if ($data->Fk_Tunjangan_Pokok == $tunjangan->SysId) echo "selected" ?> value="<?= $tunjangan->SysId ?>"><?= $tunjangan->Nama ?> (<?= $this->help->format_idr($tunjangan->Nominal) ?>)</option>
                                    <php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Other Allowance :</label>
                                <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Tunjangan_LainLain" name="Fk_Tunjangan_LainLain">
                                    <option selected disabled>-Select an option-</option>
                                    <php foreach ($tunjangans as $tunjangan) : ?>
                                        <option <php if ($data->Fk_Tunjangan_LainLain == $tunjangan->SysId) echo "selected" ?> value="<?= $tunjangan->SysId ?>"><?= $tunjangan->Nama ?> (<?= $this->help->format_idr($tunjangan->Nominal) ?>)</option>
                                    <php endforeach; ?>
                                </select>
                            </div> -->
                            <div class="fv-row mb-5">
                                <label class="form-label">Bank :</label>
                                <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Bank" name="Fk_Bank">
                                    <option selected disabled>-Select an option-</option>
                                    <?php foreach ($banks as $bank) : ?>
                                        <option <?php if ($data->Fk_Bank == $bank->SysId) echo "selected" ?> value="<?= $bank->SysId ?>"><?= $bank->Bank ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="fv-row mb-5">
                                <label class="form-label">Account Bank Number :</label>
                                <input type="text" class="form-control" value="<?= $data->No_Rekening ?>" id="No_Rekening" name="No_Rekening" placeholder="Account Number...">
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

        $("#Tanggal_Lahir").flatpickr();
        $("#Tanggal_Join").flatpickr();

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
                    text: `Are you sure to update employee data ?`,
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
                url: $('meta[name="base_url"]').attr('content') + "Master/Store_Update_Employee",
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