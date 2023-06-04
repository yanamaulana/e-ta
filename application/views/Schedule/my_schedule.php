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
                <div class="card-body">
                    <?php if ($Sql_Schedule->num_rows() > 0) : ?>
                        <form class="form-horizontal" id="#form_add">
                            <input type="hidden" id="SysId" name="SysId" value="<?= $Hdr_Schedule->SysId ?>">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label">Schedule Number :</label>
                                        <input type="text" readonly class="form-control form-control-sm" id="schedule_number" name="schedule_number" value="<?= $Hdr_Schedule->Schedule_Number ?>" placeholder="AUTO...">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label">Teacher Name :</label>
                                        <input type="text" readonly class="form-control form-control-sm" id="Nama" name="Nama" value="<?= $employee->Nama ?>" placeholder="Nama...">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <label class="form-label">Status Schedule :</label>
                                    <div class="fv-row mb-5" id="el-status">
                                        <?php if ($Hdr_Schedule->Approve == 0) : ?>
                                            <button type="button" class="form-control text-dark btn btn-light-warning"><i class="far fa-question-circle"></i> Un-Approve</button>
                                        <?php elseif ($Hdr_Schedule->Approve == 1) : ?>
                                            <button type="button" class="form-control text-dark btn btn-light-success"><i class="fas fa-calendar-check"></i> Approved : Active</button>
                                        <?php elseif ($Hdr_Schedule->Approve == 2) : ?>
                                            <button type="button" class="form-control text-dark btn btn-light-danger"><i class="fas fa-calendar-times"></i> Rejected</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6" id="el-action">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="fv-row mb-5 text-end">
                                        <a href="javascript:void(0)" class="btn btn-outline btn-outline-dashed btn-outline-info btn-active-light-info menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"><i class="fas fa-cogs"></i> Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                                                </svg>
                                            </span></a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="z-index: 105; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-60px, 360px);" data-popper-placement="bottom-end">
                                            <div class="menu-item px-3">
                                                <a href="<?= base_url('My_Schedule/Form_Revision_Schedule/' . $Hdr_Schedule->SysId) ?>" class="menu-link text-dark px-3"><i class="fas fa-edit"></i> &nbsp;Revision</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0)" id="archive" class="menu-link text-dark px-3"><i class="fas fa-archive"></i> &nbsp;Archive</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row">
                                <p <?php if (floatval($Hdr_Schedule->Sch_Rev) > 0) echo 'class="text-danger"' ?>>*Revision : <?= $Hdr_Schedule->Sch_Rev ?> times</p>
                                <div class="col-xl-12 col-md-12">
                                    <div class="pb-5 table-responsive">
                                        <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border w-100 gy-5 gs-5">
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
                                                <?php $i = 1; ?>
                                                <?php foreach ($Dtl_Schedule as $dtl) : ?>
                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td>
                                                            <div class="fv-row">
                                                                <select class="form-select form-select-sm day" disabled required style="width: 100%;" name="day[]">
                                                                    <option selected disabled value="">Select Day...</option>
                                                                    <option <?php if ($dtl->Day == "Monday") echo 'selected' ?> value="Monday">Monday</option>
                                                                    <option <?php if ($dtl->Day == "Tuesday") echo 'selected' ?> value="Tuesday">Tuesday</option>
                                                                    <option <?php if ($dtl->Day == "Wednesday") echo 'selected' ?> value="Wednesday">Wednesday</option>
                                                                    <option <?php if ($dtl->Day == "Thursday") echo 'selected' ?> value="Thursday">Thursday</option>
                                                                    <option <?php if ($dtl->Day == "Friday") echo 'selected' ?> value="Friday">Friday</option>
                                                                    <option <?php if ($dtl->Day == "Saturday") echo 'selected' ?> value="Saturday">Saturday</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row">
                                                                <select class="form-select form-select-sm" disabled required style="width: 100%;" name="class[]">
                                                                    <option selected disabled value="">Select Class...</option>
                                                                    <?php foreach ($Class as $class) : ?>
                                                                        <option <?php if ($dtl->Kelas_ID == $class->SysId) echo 'selected' ?> value="<?= $class->SysId ?>"><?= $class->Kelas ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row">
                                                                <select disabled class="form-select form-select-sm subject" required style="width: 100%;" name="subject[]">
                                                                    <option selected disabled value="">Select Subjects...</option>
                                                                    <?php foreach ($Subjects as $subject) : ?>
                                                                        <option <?php if ($dtl->Subject_ID == $subject->SysId) echo 'selected' ?> value="<?= $subject->SysId ?>"><?= $subject->Mata_Pelajaran ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row"><input placeholder="Time Start..." disabled value="<?= $dtl->Start_Time ?>" type="text" class="form-control text-center form-control-sm time_start" required name="time_start[]"></div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row"><input placeholder="Time Over..." disabled value="<?= $dtl->Time_Over ?>" type="text" class="form-control text-center form-control-sm time_over" required name="time_over[]"></div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row">
                                                                <select class="form-select form-select-sm text-center stand_hour" disabled required name="hour_stand[]">
                                                                    <option selected disabled value="">Hour Stand...</option>
                                                                    <option <?php if ($dtl->Stand_Hour == "1") echo 'selected' ?> value="1">1</option>
                                                                    <option <?php if ($dtl->Stand_Hour == "2") echo 'selected' ?> value="2">2</option>
                                                                    <option <?php if ($dtl->Stand_Hour == "3") echo 'selected' ?> value="3">3</option>
                                                                    <option <?php if ($dtl->Stand_Hour == "4") echo 'selected' ?> value="4">4</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php elseif ($HavingUnApproveSchedule > 0) : ?>
                        <?php $Hdr_Schedule = $this->db->get_where('ttrx_hdr_teaching_schedule', [
                            'Approve' => 0,
                            'Is_Active' => 0,
                            'Access_ID' => $this->session->userdata('sys_ID')
                        ])->row();
                        $Dtl_Schedule = $this->db->get_where('ttrx_dtl_teaching_schedule', ['Schedule_Number' => $Hdr_Schedule->Schedule_Number])->result();
                        ?>
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
                        <form class="form-horizontal" id="#form_add">
                            <input type="hidden" id="SysId" name="SysId" value="<?= $Hdr_Schedule->SysId ?>">
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label">Schedule Number :</label>
                                        <input type="text" readonly class="form-control form-control-sm" id="schedule_number" name="schedule_number" value="<?= $Hdr_Schedule->Schedule_Number ?>" placeholder="AUTO...">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="fv-row mb-5">
                                        <label class="form-label">Teacher Name :</label>
                                        <input type="text" readonly class="form-control form-control-sm" id="Nama" name="Nama" value="<?= $employee->Nama ?>" placeholder="Nama...">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <label class="form-label">Status Schedule :</label>
                                    <div class="fv-row mb-5" id="el-status">
                                        <?php if ($Hdr_Schedule->Approve == 0) : ?>
                                            <button type="button" class="form-control text-dark btn btn-light-warning"><i class="far fa-question-circle"></i> Un-Approve</button>
                                        <?php elseif ($Hdr_Schedule->Approve == 1) : ?>
                                            <button type="button" class="form-control text-dark btn btn-light-success"><i class="fas fa-calendar-check"></i> Approved : Active</button>
                                        <?php elseif ($Hdr_Schedule->Approve == 2) : ?>
                                            <button type="button" class="form-control text-dark btn btn-light-danger"><i class="fas fa-calendar-times"></i> Rejected</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6" id="el-action">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="fv-row mb-5 text-end">
                                        <a href="javascript:void(0)" class="btn btn-outline btn-outline-dashed btn-outline-info btn-active-light-info menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"><i class="fas fa-cogs"></i> Actions
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black"></path>
                                                </svg>
                                            </span></a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true" style="z-index: 105; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-60px, 360px);" data-popper-placement="bottom-end">
                                            <div class="menu-item px-3">
                                                <a href="<?= base_url('My_Schedule/Form_Revision_Schedule/' . $Hdr_Schedule->SysId) ?>" class="menu-link text-dark px-3"><i class="fas fa-edit"></i> &nbsp;Revision</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0)" id="archive" class="menu-link text-dark px-3"><i class="fas fa-archive"></i> &nbsp;Archive</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="pb-5 table-responsive">
                                        <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border w-100 gy-5 gs-5">
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
                                                <?php $i = 1; ?>
                                                <?php foreach ($Dtl_Schedule as $dtl) : ?>
                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td>
                                                            <div class="fv-row">
                                                                <select class="form-select form-select-sm day" disabled required style="width: 100%;" name="day[]">
                                                                    <option selected disabled value="">Select Day...</option>
                                                                    <option <?php if ($dtl->Day == "Monday") echo 'selected' ?> value="Monday">Monday</option>
                                                                    <option <?php if ($dtl->Day == "Tuesday") echo 'selected' ?> value="Tuesday">Tuesday</option>
                                                                    <option <?php if ($dtl->Day == "Wednesday") echo 'selected' ?> value="Wednesday">Wednesday</option>
                                                                    <option <?php if ($dtl->Day == "Thursday") echo 'selected' ?> value="Thursday">Thursday</option>
                                                                    <option <?php if ($dtl->Day == "Friday") echo 'selected' ?> value="Friday">Friday</option>
                                                                    <option <?php if ($dtl->Day == "Saturday") echo 'selected' ?> value="Saturday">Saturday</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row">
                                                                <select class="form-select form-select-sm" disabled required style="width: 100%;" name="class[]">
                                                                    <option selected disabled value="">Select Class...</option>
                                                                    <?php foreach ($Class as $class) : ?>
                                                                        <option <?php if ($dtl->Kelas_ID == $class->SysId) echo 'selected' ?> value="<?= $class->SysId ?>"><?= $class->Kelas ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row">
                                                                <select disabled class="form-select form-select-sm subject" required style="width: 100%;" name="subject[]">
                                                                    <option selected disabled value="">Select Subjects...</option>
                                                                    <?php foreach ($Subjects as $subject) : ?>
                                                                        <option <?php if ($dtl->Subject_ID == $subject->SysId) echo 'selected' ?> value="<?= $subject->SysId ?>"><?= $subject->Mata_Pelajaran ?></option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row"><input placeholder="Time Start..." disabled value="<?= $dtl->Start_Time ?>" type="text" class="form-control text-center form-control-sm time_start" required name="time_start[]"></div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row"><input placeholder="Time Over..." disabled value="<?= $dtl->Time_Over ?>" type="text" class="form-control text-center form-control-sm time_over" required name="time_over[]"></div>
                                                        </td>
                                                        <td>
                                                            <div class="fv-row">
                                                                <select class="form-select form-select-sm text-center stand_hour" disabled required name="hour_stand[]">
                                                                    <option selected disabled value="">Hour Stand...</option>
                                                                    <option <?php if ($dtl->Stand_Hour == "1") echo 'selected' ?> value="1">1</option>
                                                                    <option <?php if ($dtl->Stand_Hour == "2") echo 'selected' ?> value="2">2</option>
                                                                    <option <?php if ($dtl->Stand_Hour == "3") echo 'selected' ?> value="3">3</option>
                                                                    <option <?php if ($dtl->Stand_Hour == "4") echo 'selected' ?> value="4">4</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php else : ?>
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
                                    <h5 class="mb-1">You doesnt have any schedule active !</h5>
                                    <span>To create schedule you have go to Form schedule menu.... <br /> if your schedule still on approval prosess please contact Head master or Administrator !</span>
                                </div>
                                <!--end::Content-->
                                <!--begin::Close-->
                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto">
                                    <i class="bi bi-x fs-1 text-danger"></i>
                                </button>
                                <!--end::Close-->
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('Dashboard') ?>" id="cancel-form" class="btn btn-danger float-end"><i class="far fa-times-circle"></i> Back</a>
                    <!-- <button type="button" id="submit--data" class="btn btn-primary float-start"><i class="far fa-save"></i> Submit</button> -->
                </div>
            </div>
        </div>
    </div>
</div>