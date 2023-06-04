<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-dark" id="table-title"><?= $page_title ?></span>
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
                                <th class="text-center text-white">SCHEDULE NUMB</th>
                                <th class="text-center text-white">TEACHER</th>
                                <th class="text-center text-white">WORK STATUS</th>
                                <th class="text-center text-white">OFFICE POSITION</th>
                                <th class="text-center text-white">DATE CREATE</th>
                                <th class="text-center text-white"><i class="fas fa-cogs text-white"></i></th>
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