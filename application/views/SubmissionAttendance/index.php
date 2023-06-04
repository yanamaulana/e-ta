<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <ul class="nav nav-pills nav-fill mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link mr-5 active" data-bs-toggle="tab" href="#kt_tab_pane_4">
                            <h4 class="card-title" id="table-title-main">Add Submission & Submission Progress</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_5">
                            <h4 class="card-title" id="table-title-history">History Submission</h4>
                        </a>
                    </li>
                </ul>
                <div class="card-toolbar">
                    <a href="<?= base_url('Master') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="py-5">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="kt_tab_pane_4" role="tabpanel">
                            <div class="pb-5 table-responsive">
                                <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border gy-5 gs-5 dataTable no-footer dtr-inline">
                                    <thead style="background-color: #3B6D8C;">
                                        <tr class="text-start text-white fw-bolder text-uppercase">
                                            <th class="text-center text-white">#</th>
                                            <th class="text-center text-white">NAME</th>
                                            <th class="text-center text-white">ID ACCESS</th>
                                            <th class="text-center text-white">SOURCE</th>
                                            <th class="text-center text-white">DATE</th>
                                            <th class="text-center text-white">TIME</th>
                                            <th class="text-center text-white">SCHEDULE NUMBER</th>
                                            <th class="text-center text-white">DAY</th>
                                            <th class="text-center text-white">CLASS</th>
                                            <th class="text-center text-white">SUBJECT</th>
                                            <th class="text-center text-white">START TIME</th>
                                            <th class="text-center text-white">TIME OVER</th>
                                            <th class="text-center text-white">STAND HOUR</th>
                                            <th class="text-center text-white">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-bold">
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                            <div class="pb-5 table-responsive">
                                <table id="TableDataHistory" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border gy-5 gs-5 dataTable no-footer dtr-inline">
                                    <thead style="background-color: #3B6D8C;">
                                        <tr class="text-start text-white fw-bolder text-uppercase">
                                            <th class="text-center text-white">#</th>
                                            <th class="text-center text-white">NAME</th>
                                            <th class="text-center text-white">ID ACCESS</th>
                                            <th class="text-center text-white">SOURCE</th>
                                            <th class="text-center text-white">DATE</th>
                                            <th class="text-center text-white">TIME</th>
                                            <th class="text-center text-white">SCHEDULE NUMBER</th>
                                            <th class="text-center text-white">DAY</th>
                                            <th class="text-center text-white">CLASS</th>
                                            <th class="text-center text-white">SUBJECT</th>
                                            <th class="text-center text-white">START TIME</th>
                                            <th class="text-center text-white">TIME OVER</th>
                                            <th class="text-center text-white">STAND HOUR</th>
                                            <th class="text-center text-white">STATUS</th>
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
        </div>
    </div>
</div>
<div id="location"></div>