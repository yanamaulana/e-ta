<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="table-title">List Slip Gaji : <?= $this->session->userdata('sys_nama') ?></span>
                </h3>
                <div class="card-toolbar">
                    <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <input type="hidden" value="<?= $this->session->userdata('sys_ID') ?>" id="NIK" name="NIK">
                <div class="pb-5 table-responsive">
                    <table id="Table-Hdr" style="width: 100%;" class="table-sm align-middle table-rounded table-bordered border gy-5 gs-5">
                        <thead style="background-color: #3B6D8C;">
                            <tr class="text-start text-white fw-bolder text-uppercase">
                                <th class="text-center align-middle text-white">#</th>
                                <th class="text-center align-middle text-white">Tag-Gaji</th>
                                <th class="text-center align-middle text-white">NIK</th>
                                <th class="text-center align-middle text-white">Nama <i class="fas fa-user"></i></th>
                                <th class="text-center align-middle text-white">Jabatan</th>
                                <th class="text-center align-middle text-white">Status</th>
                                <th class="text-center align-middle text-white"><i class="calendar"></i> Awal</th>
                                <th class="text-center align-middle text-white"><i class="calendar"></i> Akhir</th>
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