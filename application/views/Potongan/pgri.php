<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="py-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title" id="table-title-detail"><?= $page_title ?></h3>
                    <div class="card-toolbar">
                        <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left fs-2"></i> Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row py-2">
                        <div class="pb-5 table-responsive">
                            <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded w-100 table-striped table-bordered border gy-5 gs-5">
                                <thead style="background-color: #3B6D8C;">
                                    <tr class="text-start text-white fw-bolder text-uppercase">
                                        <th class="text-center align-middle text-uppercase text-white">#</th>
                                        <th class="text-center align-middle text-uppercase text-white">ID Access</th>
                                        <th class="text-center align-middle text-uppercase text-white">UserName</th>
                                        <th class="text-center align-middle text-uppercase text-white">Nama</th>
                                        <th class="text-center align-middle text-uppercase text-white">Nominal Potongan</th>
                                        <th class="text-center align-middle text-uppercase text-white">Terbilang</th>

                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('Dashboard') ?>" id="cancel-form" class="btn btn-danger float-end"><i class="far fa-arrow-alt-circle-left fs-2"></i> Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="location"></div>