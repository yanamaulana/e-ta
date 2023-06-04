<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="py-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><?= $page_title ?> : <?= $user->Nama ?></h3>
                    <div class="card-toolbar">
                        <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="form_change">
                        <input type="hidden" name="UserName" id="UserName" value="<?= $user->UserName ?>">
                        <div class="row">
                            <div class="col-xl-8 col-md-12">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Password :</label>
                                    <input type="password" required class="form-control" id="old_password" name="old_password" placeholder="Password...">
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-12">
                                <div class="fv-row mb-5">
                                    <label class="form-label">New Password :</label>
                                    <input type="password" required class="form-control" id="new_password1" minlength="5" name="new_password1" placeholder="New Password...">
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-12">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Repeat New Password :</label>
                                    <input type="password" required class="form-control" id="new_password2" minlength="5" name="new_password2" placeholder="Repeat New Password...">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('Dashboard') ?>" class="btn btn-danger float-end"><i class="far fa-times-circle"></i> Cancel</a>
                    <button type="button" id="submit--new--data" class="btn btn-primary float-start"><i class="far fa-save"></i> Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>