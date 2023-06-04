<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="py-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><?= $page_title ?></h3>
                    <div class="card-toolbar">
                        <a href="<?= base_url('Dashboard') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                    </div>
                </div>
                <div style="display: none;">
                    <select class="form-select form-select-sm" style="width: 100%;" name="subject[]" id="raw_select">
                        <option selected disabled value="">Select Lessons...</option>
                        <?php foreach ($Subjects as $subject) : ?>
                            <option value="<?= $subject->SysId ?>"><?= $subject->Mata_Pelajaran ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="card-body">
                    <?php if ($HavingActiveAndApproveSchedule > 0) : ?>
                        <div class="row">
                            <div class="alert alert-dismissible bg-light-danger border border-danger border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                                <span class="svg-icon svg-icon-2hx svg-icon-danger me-4 mb-5 mb-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="black"></path>
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Content-->
                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                    <h5 class="mb-1">You still have active schedule !</h5>
                                    <span>Before create new schedule you must archive your last scedule...</span>
                                </div>
                                <!--end::Content-->
                                <!--begin::Close-->
                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto">
                                    <i class="bi bi-x fs-1 text-danger"></i>
                                </button>
                                <!--end::Close-->
                            </div>
                        </div>
                    <?php elseif ($HavingActiveAndUnApproveSchedule > 0) : ?>
                        <div class="row">
                            <div class="alert alert-dismissible bg-light-warning border border-warning border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                                <span class="svg-icon svg-icon-2hx svg-icon-warning me-4 mb-5 mb-sm-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="black"></path>
                                        <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="black"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Content-->
                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                    <h5 class="mb-1">Your schedule on approval progress !</h5>
                                    <span>Please contact headmaster or administrator to continue your schedule approval progress...</span>
                                </div>
                                <!--end::Content-->
                                <!--begin::Close-->
                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto">
                                    <i class="bi bi-x fs-1 text-danger"></i>
                                </button>
                                <!--end::Close-->
                            </div>
                        </div>
                    <?php else : ?>
                        <form class="form-horizontal" id="form_add">
                            <div class="row">
                                <div class="col-xl-6 col-md-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label">Schedule Number :</label>
                                        <input type="text" readonly class="form-control form-control-sm" id="schedule_number" name="schedule_number" placeholder="AUTO...">
                                    </div>
                                </div>
                                <!-- <div class="col-xl-6 col-md-6">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Name :</label>
                                    <input type="text" required class="form-control" id="Nama" name="Nama" placeholder="Name...">
                                </div>
                            </div> -->
                            </div>
                            <div class="fv-row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="pb-5 table-responsive">
                                        <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border gy-5 gs-5">
                                            <thead style="background-color: #3B6D8C;">
                                                <tr class="text-start text-white fw-bolder text-uppercase">
                                                    <th class="text-center text-white">#</th>
                                                    <th class="text-center text-white">DAY</th>
                                                    <th class="text-center text-white">CLASS</th>
                                                    <th class="text-center text-white">SUBJECT</th>
                                                    <th class="text-center text-white">TIME START</th>
                                                    <th class="text-center text-white">TIME OVER</th>
                                                    <th class="text-center text-white">HOUR STANDS</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600 fw-bold" id="tbody">
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <div class="fv-row">
                                                            <select class="form-select form-select-sm day" required style="width: 100%;" name="day[]">
                                                                <option selected disabled value="">Select Day...</option>
                                                                <option value="Monday">Monday</option>
                                                                <option value="Tuesday">Tuesday</option>
                                                                <option value="Wednesday">Wednesday</option>
                                                                <option value="Thursday">Thursday</option>
                                                                <option value="Friday">Friday</option>
                                                                <option value="Saturday">Saturday</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row">
                                                            <select class="form-select form-select-sm class" required style="width: 100%;" name="class[]">
                                                                <option selected disabled value="">Select Class...</option>
                                                                <?php foreach ($Class as $class) : ?>
                                                                    <option value="<?= $class->SysId ?>"><?= $class->Kelas ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row">
                                                            <select class="form-select form-select-sm subject" required data-control="select2" style="width: 100%;" name="subject[]">
                                                                <option selected disabled value="">Select Subjects...</option>
                                                                <?php foreach ($Subjects as $subject) : ?>
                                                                    <option value="<?= $subject->SysId ?>"><?= $subject->Mata_Pelajaran ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row"><input placeholder="Time Start..." value="00:00" type="text" class="form-control text-center form-control-sm time_start" required name="time_start[]"></div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row"><input placeholder="Time Over..." value="00:00" type="text" class="form-control text-center form-control-sm time_over" required name="time_over[]"></div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row">
                                                            <select class="form-select form-select-sm text-center stand_hour" required name="hour_stand[]">
                                                                <option selected disabled value="">Hour Stand...</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row text-center mt-5">
                                <div class="btn-group mt-5" role="group" aria-label="Basic example">
                                    <button type="button" id="add-row" class="btn btn-success" title="add row"><i class="fas fa-plus"></i></button>&nbsp;
                                    <button type="button" id="remove-row" class="btn btn-danger" title="remove last row"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('Dashboard') ?>" id="cancel-form" class="btn btn-danger float-end"><i class="far fa-times-circle"></i> Cancel</a>
                    <button type="button" id="submit--data" class="btn btn-primary float-start"><i class="far fa-save"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>