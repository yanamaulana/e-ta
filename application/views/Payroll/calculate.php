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
                <form class="form" id="form-data">
                    <div class="row">
                        <div class="row">
                            <label for="exampleFormControlInput1" class="required form-label">Payroll Date Range</label>
                            <div class="col-xl-6 py-2 col-md-12">
                                <div class="input-group">
                                    <input type="text" name="from" id="from" class="form-control date-picker text-center readonly" value="<?= date('Y-m-01') ?>">
                                    <span class="input-group-text btn btn-primary" title="Date Range" data-toggle="tooltip"><i class="fas fa-calendar"></i> UNTIL</span>
                                    <input type="text" name="until" id="until" class="form-control date-picker text-center readonly" value="<?= date('Y-m-t') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-8">
                            <div class="col-xl-2 py-2 col-md-3">
                                <div class="input-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked="true" value="1" role="switch" id="include_gaji" name="include_gaji">
                                        <label class="form-check-label" for="flexSwitchCheckDefault"><span class="text-danger">?</span> Include Gaji</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 py-2 col-md-3">
                                <div class="input-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" checked="true" value="1" role="switch" id="include_jabatan" name="include_jabatan">
                                        <label class="form-check-label" for="flexSwitchCheckDefault"><span class="text-danger">?</span> Include Tunjangan Jabatan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="pb-5 table-responsive">
                        <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded table-bordered border gy-5 gs-5">
                            <thead style="background-color: #3B6D8C;">
                                <tr class="text-start text-white fw-bolder text-uppercase">
                                    <th class="text-center text-white">
                                        <div class="form-check form-check-custom form-check-solid form-check-sm" data-toggle="tooltip" title="Semua Karyawan Akan Include Calculate" data-bs-placement="left" data-bs-custom-class="tooltip-dark" data-bs-dismiss="click">
                                            <input class="form-check-input form-check-sm" type="checkbox" id="CheckAll" value="checkall" onclick="check_uncheck_checkbox(this.checked,'IDs[]');">
                                        </div>
                                    </th>
                                    <th class="text-center text-white">ID Access</th>
                                    <th class="text-center text-white">NAMA</th>
                                    <th class="text-center text-white">JABATAN POKOK</th>
                                    <th class="text-center text-white">NOMINAL GAPOK</th>
                                    <th class="text-center text-white">JAM BERDIRI/JAM</th>
                                    <th class="text-center text-white">TUN.JABATAN 1</th>
                                    <th class="text-center text-white">NOMINAL TUN.JABATAN 1</th>
                                    <th class="text-center text-white">TUN.JABATAN 2</th>
                                    <th class="text-center text-white">NOMINAL TUN.JABATAN 2</th>
                                    <th class="text-center text-white">TUN.JABATAN 3</th>
                                    <th class="text-center text-white">NOMINAL TUN.JABATAN 3</th>
                                    <th class="text-center text-white bg-danger">
                                        <div class="form-check form-check-custom form-check-solid form-check-sm" data-toggle="tooltip" title="Semua karyawan yang memiliki angsuran kasbon, Total THP dipotong angsuran kasbon" data-bs-placement="left" data-bs-custom-class="tooltip-dark" data-bs-dismiss="click">
                                            <input class="form-check-input form-check-sm" type="checkbox" id="CheckAll" value="checkall" onclick="check_uncheck_checkbox(this.checked,'Kasbons[]');">
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 py-2 col-md-6">
                            <div class="d-grid">
                                <button type="button" id="submit-form" class="btn btn-success btn-lg text-white">&nbsp;<i class="far fa-credit-card fs-4 me-2"></i> Calculate</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="location"></div>