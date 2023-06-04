<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="py-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><?= $page_title ?></h3>
                    <div class="card-toolbar">
                        <a href="<?= base_url('Master/index_employee') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="form_add">
                        <div class="row">
                            <div class="col-xl-8 col-md-12">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Name :</label>
                                    <input type="text" required class="form-control" id="Nama" name="Nama" placeholder="Name...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">ID Access Control :</label>
                                    <input type="number" required class="form-control" id="ID" name="ID" maxlength="3" placeholder="ID Access Control...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">User Name :</label>
                                    <input type="text" required class="form-control" id="UserName" name="UserName" minlength="3" maxlength="12" placeholder="User name...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">KTP :</label>
                                    <input type="number" required class="form-control" id="KTP" name="KTP" maxlength="17" placeholder="KTP...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Gender :</label>
                                    <select id="Gender" name="Gender" required class="form-select form-control" data-control="select2" data-placeholder="Select an option">
                                        <option></option>
                                        <option value="LAKI-LAKI">LAKI-LAKI</option>
                                        <option value="PEREMPUAN">PEREMPUAN</option>
                                    </select>
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Place of Birth :</label>
                                    <input type="text" required class="form-control" id="Tempat_Lahir" name="Tempat_Lahir" placeholder="Place of Birth...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Date of Birth :</label>
                                    <input type="text" required class="form-control date-picker" id="Tanggal_Lahir" name="Tanggal_Lahir" placeholder="Date of Birth...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Telephone Number :</label>
                                    <input type="text" required class="form-control" id="Telpon" name="Telpon" placeholder="Telephone Number...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">E-mail :</label>
                                    <input type="email" class="form-control" id="Email" name="Email" placeholder="Email...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Martial Status :</label>
                                    <select id="Status_Pernikahan" name="Status_Pernikahan" required class="form-select form-control" data-control="select2" data-placeholder="Select an option">
                                        <option></option>
                                        <option value="LAJANG">LAJANG</option>
                                        <option value="MENIKAH">MENIKAH</option>
                                        <option value="CERAI">CERAI</option>
                                    </select>
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Date Join :</label>
                                    <input type="text" required class="form-control date-picker" id="Tanggal_Join" name="Tanggal_Join" placeholder="Date Join...">
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Address :</label>
                                    <textarea required class="form-control" id="Full_address" name="Full_address" placeholder="Address..."></textarea>
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Work Status :</label>
                                    <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Work_Status" name="Fk_Work_Status">
                                        <option selected disabled>-Select an option-</option>
                                        <?php foreach ($works_status as $ws) : ?>
                                            <option value="<?= $ws->SysId ?>"><?= $ws->Work_Status ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Office Position :</label>
                                    <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Jabatan" name="Fk_Jabatan">
                                        <option selected disabled>-Select an option-</option>
                                        <?php foreach ($jabatans as $jab) : ?>
                                            <option value="<?= $jab->SysId ?>"><?= $jab->Jabatan ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Bank :</label>
                                    <select required class="form-select form-control" data-control="select2" data-placeholder="Select an option" id="Fk_Bank" name="Fk_Bank">
                                        <option selected disabled>-Select an option-</option>
                                        <?php foreach ($banks as $bank) : ?>
                                            <option value="<?= $bank->SysId ?>"><?= $bank->Bank ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="fv-row mb-5">
                                    <label class="form-label">Account Bank Number :</label>
                                    <input type="text" required class="form-control" id="No_Rekening" name="No_Rekening" placeholder="Account Number...">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('Master/index_employee') ?>" class="btn btn-danger float-end"><i class="far fa-times-circle"></i> Cancel</a>
                    <button type="button" id="submit--new--data" class="btn btn-primary float-start"><i class="far fa-save"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>