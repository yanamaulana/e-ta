<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="table-title">List Master Data Allowance Employee</span>
                </h3>
                <div class="card-toolbar">
                    <a href="<?= base_url('Master') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="pb-5 table-responsive">
                    <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded w-100 table-striped table-bordered border gy-5 gs-5">
                        <thead style="background-color: #3B6D8C;">
                            <tr class="text-start text-white fw-bolder text-uppercase">
                                <th class="text-center text-white">#</th>
                                <th class="text-center text-white">ALLOWANCE CODE</th>
                                <th class="text-center text-white">ALLOWANCE LABEL</th>
                                <th class="text-center text-white">NOMINAL</th>
                                <th class="text-center text-white">PAY TYPE</th>
                                <th class="text-center text-white">DESCRIPTION</th>
                                <th class="text-center text-white">ACTIVATION</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="location"></div>
<div class="modal hide fade" id="modal-add" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- style="max-width: 70%;" -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">FORM ADD DATA</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times"></i></span>
                </div>
            </div>
            <div class="modal-body">
                <form id="form_add" method="post">
                    <div class="row">
                        <div class="col-xl-12 col-md-12">
                            <div class="fv-row mb-5">
                                <label class="form-label">Allowance Code :</label>
                                <input type="text" required class="form-control" id="Nama" name="Nama" placeholder="Allowance Code...">
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="fv-row mb-5">
                                <label class="form-label">Allowance Label :</label>
                                <input type="text" required class="form-control" id="Label" name="Label" placeholder="Allowance Label...">
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="fv-row mb-5">
                                <label class="form-label">Nominal Allowance :</label>
                                <input type="number" min="500" required class="form-control" id="Nominal" name="Nominal" placeholder="Nominal...">
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="fv-row mb-5">
                                <label class="form-label">Pay Type (term of payment) :</label>
                                <select required class="form-select form-control" id="Pay_Type" name="Pay_Type">
                                    <option selected disabled>Choose Option</option>
                                    <option value="PER-JAM">PER-JAM</option>
                                    <option value="PER-HARI">PER-HARI</option>
                                    <option value="PER-BULAN">PER-BULAN</option>
                                    <option value="PER-SEMESTER">PER-SEMESTER</option>
                                    <option value="PER-TAHUN">PER-TAHUN</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12">
                            <div class="fv-row mb-5">
                                <label class="form-label">Description Allowance :</label>
                                <textarea required class="form-control" rows="3" id="Deskripsi" name="Deskripsi" placeholder="Description Allowance..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="submit--new--data" class="btn btn-primary float-start"><i class="far fa-save"></i> Submit</button>
                <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>