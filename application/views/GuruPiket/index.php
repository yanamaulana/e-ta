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
                <form class="form" id="form-guru-piket">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-xl-6">
                                <div class="form-group py-3">
                                    <label for="tanggal" class="col-form-label">Tanggal :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" readonly required id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>" placeholder="Tanggal Piket ...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-6">
                                <div class="form-group py-3">
                                    <label for="nominal" class="col-form-label">Waktu :</label>
                                    <div class="col-sm-10">
                                        <select required class="form-control select2" id="waktu_piket" name="waktu_piket">
                                            <option selected disabled>-Pilih Waktu Piket-</option>
                                            <option value="PAGI">PAGI</option>
                                            <option value="SIANG">SIANG</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 col-md-3 col-xl-3">
                            <button class="btn btn-primary btn-lg mt-3" id="submit-piket">Submit Data Guru Piket &nbsp;&nbsp;&nbsp; <i class="fas fa-save fs-2"></i></button>
                        </div>
                        <hr />
                    </div>
                    <div class="container-fluid">
                        <div class="pb-5 table-responsive">
                            <table id="TableData" class="table table-sm align-middle display compact dt-nowrap table-rounded table-bordered border gy-5 gs-5">
                                <thead style="background-color: #3B6D8C;">
                                    <tr class="text-start text-white fw-bolder text-uppercase">
                                        <th class="text-center text-white">#
                                        </th>
                                        <th class="text-center text-white">ID Access</th>
                                        <th class="text-center text-white">NAME</th>
                                        <th class="text-center text-white">WORK STATUS</th>
                                        <th class="text-center text-white">OFFICE POSITION</th>
                                        <th class="text-center text-white">CODE SALARY</th>
                                        <th class="text-center text-white">NOMINAL SALARY</th>
                                        <th class="text-center text-white">BASIC ALLOWANCE</th>
                                        <th class="text-center text-white">NOMINAL BASIC ALLOWANCE</th>
                                        <th class="text-center text-white">OTHER ALLOWANCE</th>
                                        <th class="text-center text-white">NOMINAL OTHER ALLOWANCE</th>
                                        <th class="text-center text-white">BANK</th>
                                        <th class="text-center text-white">ACCOUNT BANK NUMBER</th>
                                        <th class="text-center text-white">NO KTP</th>
                                        <th class="text-center text-white">TELEPHONE NUMBER</th>
                                        <th class="text-center text-white">EMAIL</th>
                                        <th class="text-center text-white">GENDER</th>
                                        <th class="text-center text-white">MARTIAL STATUS</th>
                                        <th class="text-center text-white">DATE JOIN</th>
                                        <th class="text-center text-white">ADDRESS</th>
                                        <th class="text-center text-white"><i class="fas fa-cogs text-white"></i></th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="location"></div>