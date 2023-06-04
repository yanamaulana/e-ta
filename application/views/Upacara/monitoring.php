<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="py-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><?= $page_title ?></h3>
                    <div class="card-toolbar">
                        <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left fs-2"></i> Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <form action="#" method="post" id="filter-data">
                            <div class="row">
                                <div class="col-xl-3 py-2 col-md-6">
                                    <div class="form-group">
                                        <select class="form-select" name="employee" id="employee" data-control="select2">
                                            <option value="" selected>ALL Employee</option>
                                            <?php foreach ($Teachers as $teacher) : ?>
                                                <option value="<?= $teacher->ID ?>"><?= $teacher->Nama ?> (<?= $teacher->UserName ?>)</option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-4 py-2 col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="from" id="from" class="form-control date-picker text-center readonly" value="<?= date('Y-m-01') ?>">
                                        <span class="input-group-text btn btn-primary" title="Date Range" data-toggle="tooltip"><i class="fas fa-calendar"></i> UNTIL</span>
                                        <input type="text" name="until" id="until" class="form-control date-picker text-center readonly" value="<?= date('Y-m-t') ?>">
                                    </div>
                                </div>
                                <div class="col-xl-3 py-2 col-md-6">
                                    <div class="input-group">
                                        <button type="button" id="do--filter" class="btn btn-danger text-white">&nbsp;<i class="fas fa-search fs-4 me-2"></i> Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr style="padding-top: 5px; color: black; background-color: black;" />
                    <div class="row py-2">
                        <div class="pb-5 table-responsive">
                            <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded w-100 table-striped table-bordered border gy-5 gs-5">
                                <thead style="background-color: #3B6D8C;">
                                    <tr class="text-start text-white fw-bolder text-uppercase">
                                        <th class="text-center text-white">#</th>
                                        <th class="text-center text-white">ID Access</th>
                                        <th class="text-center text-white">NAME</th>
                                        <th class="text-center text-white">DATE</th>
                                        <th class="text-center text-white">JABATAN UPACARA</th>
                                        <th class="text-center text-white">NOMINAL</th>
                                        <th class="text-center text-white">STATUS</th>
                                        <th class="text-center text-white"><i class="fas fa-cogs text-white"></i></th>

                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold">
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