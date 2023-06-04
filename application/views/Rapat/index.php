<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="table-title"><?= $page_title ?></span>
                </h3>
                <div class="card-toolbar">
                    <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <form class="form" id="form-rapat">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group py-3">
                                    <label for="tanggal" class="col-form-label">Tanggal Rapat :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" readonly required id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" placeholder="Date Over Time ...">
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Waktu Rapat Mulai :</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="start" name="start" placeholder="Waktu Mulai Rapat...">
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Tema Rapat :</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="tema" name="tema" placeholder="Tema Rapat...">
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="note" class="col-form-label">Note/Catatan :</label>
                                    <div class="col-sm-10">
                                        <textarea type="text" class="form-control" id="note" name="note" placeholder="Note..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-6">
                                <div class="form-group py-3">
                                    <label for="jumlah_jam" class="col-form-label">Ketua Rapat :</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control select2" id="ketua_rapat" name="ketua_rapat">
                                            <option selected disabled>-Pilih Ketua-</option>
                                            <?php foreach ($Employees as $li) :  ?>
                                                <option value="<?= $li->UserName ?>"><?= $li->Nama ?></option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Waktu Rapat Selesai :</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="end" name="end" placeholder="Waktu Rapat Selesai...">
                                    </div>
                                </div>
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Ruangan Rapat :</label>
                                    <div class="col-sm-10">
                                        <input type="text" required class="form-control" id="ruangan" name="ruangan" placeholder="Ruangan Rapat...">
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-md-10 col-xl-3">
                                <button class="btn btn-primary btn-lg mt-3" id="submit-main-form">Submit Data Kegiatan Rapat &nbsp;&nbsp;&nbsp; <i class="fas fa-save fs-2"></i></button>
                            </div>
                        </div>
                        <hr />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="location"></div>