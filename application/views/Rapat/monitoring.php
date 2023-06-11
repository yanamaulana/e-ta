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
                                        <th class="text-center text-white">NO. RAPAT</th>
                                        <th class="text-center text-white">TANGGAL</th>
                                        <th class="text-center text-white">MULAI</th>
                                        <th class="text-center text-white">SELESAI</th>
                                        <th class="text-center text-white">TEMA RAPAT</th>
                                        <th class="text-center text-white">RUANGAN</th>
                                        <th class="text-center text-white">PEMIMPIN</th>
                                        <th class="text-center text-white">TUNJANGAN</th>
                                        <th class="text-center text-white"><i class="fas fa-users text-white"></i></th>
                                        <th class="text-center text-white">APPROVE LEADER</th>
                                        <th class="text-center text-white">APPROVE ADMIN</th>
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
<div id="location_modal_employee">
    <div class="modal hide fade" id="Modal-add-member" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="table-title-detail"></h5>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"><i class="fas fa-times"></i></span>
                    </div>
                </div>
                <div class="modal-body">
                    <form class="form" id="form-add-member">
                        <input type="hidden" id="SysId_Add" name="SysId_Add">
                        <input type="hidden" name="Role" id="Role" value="Administrator" readonly>
                        <input type="hidden" id="No_Meeting" name="No_Meeting">
                        <div class="pb-5 table-responsive">
                            <table id="Table-Employee" style="width: 100%;" class="table-sm align-middle display compact dt-nowrap table-rounded table-bordered border gy-5 gs-5">
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
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger float-end" data-bs-dismiss="modal" type="button"><i class="far fa-times-circle"></i> Close</button>
                    <button id="submit-peserta" type="button" class="btn btn-primary float-end"><i class="fas fa-user-plus"></i> Tambahkan Peserta</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>