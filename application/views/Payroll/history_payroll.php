<div class="row gx-5 gx-xl-10">
    <div class="col-xl-6">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="table-title">Recap Event Payroll</span>
                </h3>
                <div class="card-toolbar">
                    <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="pb-5 table-responsive">
                    <table id="Table-Event" style="width: 100%;" class="table-sm align-middle display compact dt-nowrap table-rounded table-bordered border gy-5 gs-5">
                        <thead style="background-color: #3B6D8C;">
                            <tr class="text-start text-white fw-bolder text-uppercase">
                                <th class="text-center align-middle text-white">#</th>
                                <th class="text-center align-middle text-white"><i class="fas fa-cogs text-white"></i></th>
                                <th class="text-center align-middle text-white">Tag-Event</th>
                                <th class="text-center align-middle text-white">Jumlah</i></th>
                                <th class="text-center align-middle text-white">Awal <i class="far fa-calendar text-white"></i></th>
                                <th class="text-center align-middle text-white">Akhir <i class="far fa-calendar text-white"></i></th>
                                <th class="text-center align-middle text-white">Pelaksana</th>
                                <th class="text-center align-middle text-white">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark fw-bold">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="table-title">Detail Recap Even Payroll Per-Employee</span>
                </h3>
                <div class="card-toolbar">
                    <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="pb-5 table-responsive">
                    <table id="Table-Hdr" style="width: 100%;" class="table-sm align-middle table-rounded table-bordered border gy-5 gs-5">
                        <thead style="background-color: #3B6D8C;">
                            <tr class="text-start text-white fw-bolder text-uppercase">
                                <th class="text-center align-middle text-white">#</th>
                                <th class="text-center align-middle text-white">Tag-Gaji</th>
                                <th class="text-center align-middle text-white">NIK</th>
                                <th class="text-center align-middle text-white">Nama <i class="fas fa-user"></i></th>
                                <th class="text-center align-middle text-white">Dept</th>
                                <th class="text-center align-middle text-white">Jabatan</th>
                                <th class="text-center align-middle text-white">Activation</th>
                                <th class="text-center align-middle text-white"><i class="fas fa-cogs text-white fs-2"></i></th>
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
<div id="location"></div>