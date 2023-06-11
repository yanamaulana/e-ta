<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <ul class="nav nav-pills nav-fill mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link mr-5" data-bs-toggle="tab" href="#container-tab-1">
                            <h4 class="card-title" id="table-title-main">Form Kasbon</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#container-tab-3">
                            <h4 class="card-title" id="table-title-detail">Saldo Kasbon dan History Angsuran</h4>
                        </a>
                    </li>
                </ul>
                <div class="card-toolbar">
                    <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="container-tab-1" role="tabpanel">
                        <form class="form" id="main-form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-xl-6">
                                        <div class="form-group py-3">
                                            <label for="jumlah_jam" class="col-form-label">Karyawan :</label>
                                            <div class="col-sm-11">
                                                <select required class="form-select" data-control="select2" data-placeholder="-Pilih-" id="employee" name="employee"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-6">
                                        <div class="form-group py-3">
                                            <label for="nominal" class="col-form-label">Nominal Kasbon :</label>
                                            <div class="col-sm-11">
                                                <input type="number" min="1" required class="form-control" id="nominal_kasbon" name="nominal_kasbon" placeholder="Nominal Kasbon...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xl-6">
                                        <div class="form-group py-3">
                                            <label for="nominal" class="col-form-label">Note :</label>
                                            <div class="col-sm-11">
                                                <textarea class="form-control" id="note" name="note" placeholder="Catatan..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-6">
                                        <div class="form-group py-3">
                                            <label for="nominal" class="col-form-label">Jumlah Angsuran :</label>
                                            <div class="col-sm-6">
                                                <input type="number" min="1" maxlength="2" required value="1" class="form-control" id="jumlah_angsuran" name="jumlah_angsuran" placeholder="Berapa kali angsuran...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xl-6">
                                        <div class="form-group py-3" id="el-saldo-lama" style="display: none;">
                                            <label for="nominal" class="col-form-label">Sisa Tunggakan Kasbon :</label>
                                            <div class="col-sm-6">
                                                <input type="number" min="1" readonly style="border:none;" required value="0" class="form-control" id="saldo_kasbon" name="saldo_kasbon" placeholder="Sisa Tunggakan kasbon...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xl-6">
                                        <div class="form-group py-3">
                                            <label for="nominal" class="col-form-label">Nominal Angsuran :</label>
                                            <div class="col-sm-11">
                                                <input type="number" min="1" readonly style="border: none;" required class="form-control" id="nominal_angsuran" name="nominal_angsuran" placeholder="Nominal angsuran payroll...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="d-grid gap-2 col-md-10 col-xl-3">
                                        <button class="btn btn-primary btn-lg mt-3" id="submit-main-form">Submit Data Kasbon &nbsp;&nbsp;&nbsp; <i class="fas fa-save fs-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade active show" id="container-tab-3" role="tabpanel">
                        <div class="pb-5 table-responsive">
                            <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded w-100 table-striped table-bordered border gy-5 gs-5">
                                <thead style="background-color: #3B6D8C;">
                                    <tr class="text-start text-white fw-bolder text-uppercase">
                                        <th class="text-center text-white">#</th>
                                        <th class="text-center text-white">ID ACCESS</th>
                                        <th class="text-center text-white">NAMA</th>
                                        <th class="text-center text-white">SALDO KASBON</th>
                                        <th class="text-center text-white">NOMINAL ANGSURAN</th>
                                        <th class="text-center text-white">SISA ANGSURAN</th>
                                        <th class="text-center text-white"><i class="fas fa-cogs text-white"></i></th>
                                    </tr>
                                </thead>
                                <tbody class="text-dark fw-bold">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="location"></div>