<div class="row gx-5 gx-xl-10">
    <div class="col-xl-3">
    </div>
    <div class="col-xl-6">
        <div class="py-5">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><?= $page_title ?></h3>
                    <div class="card-toolbar">
                        <a href="<?= base_url('SubmissionAttendance') ?>" type="button" class="btn btn-sm btn-light-danger"><i class="far fa-arrow-alt-circle-left"></i> Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" id="form_add">
                        <input type="hidden" name="ID" id="ID" value="<?= $this->session->userdata('sys_ID') ?>">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Name :</label>
                                    <input type="text" required readonly class="form-control" id="Nama" name="Nama" value="<?= $this->session->userdata('sys_nama') ?>" placeholder="Name...">
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Schedule :</label>
                                    <input type="hidden" name="Schedule_ID" id="Schedule_ID" readonly required>
                                    <div class="input-group">
                                        <input type="text" required readonly class="form-control" id="Schedule" name="Schedule" placeholder="Schedule Number...">
                                        <button type="button" class="btn btn-icon btn-danger" id="btn-schedule" data-bs-toggle="modal" data-bs-target="#modal-browse"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Remark :</label>
                                    <select class="form-control" id="Card" name="Card" required class="form-select form-control" data-control="select2" data-placeholder="Select an option">
                                        <option></option>
                                        <option value="FORGOT ATTENDANCE">FORGOT ATTENDANCE</option>
                                        <option value="ACTIVITIES OUTSIDE SCHOOL">ACTIVITIES OUTSIDE SCHOOL</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Date Attendance :</label>
                                    <input type="text" required readonly class="form-control" id="Date_Att" name="Date_Att" placeholder="Date Attendance...">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('SubmissionAttendance') ?>" class="btn btn-danger float-end"><i class="far fa-times-circle"></i> Cancel</a>
                    <button type="button" id="submit--new--data" class="btn btn-primary float-start"><i class="far fa-save"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
    </div>
</div>

<div class="modal hide fade" id="modal-browse" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Schedule</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-2x"><i class="fas fa-times"></i></span>
                </div>
            </div>
            <div class="modal-body">
                <?php if ($Sql_Schedule->num_rows() > 0) : ?>
                    <div class="pb-5 table-responsive">
                        <table id="TableBrowse" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border w-100 gy-5 gs-5">
                            <thead style="background-color: #3B6D8C;">
                                <tr class="text-start text-white fw-bolder text-uppercase">
                                    <th class="text-center text-white">#</th>
                                    <th class="text-center text-white">DAY</th>
                                    <th class="text-center text-white">CLASS</th>
                                    <th class="text-center text-white">SUBJECT</th>
                                    <th class="text-center text-white">TIME START</th>
                                    <th class="text-center text-white">TIME OVER</th>
                                    <th class="text-center text-white">HOUR STANDS</th>
                                    <th class="text-center text-white">SYSID</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold" id="tbody">
                                <?php $i = 1; ?>
                                <?php foreach ($Dtl_Schedule as $dtl) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $dtl->Day ?></td>
                                        <td><?= $dtl->Kelas ?></td>
                                        <td><?= $dtl->Mata_Pelajaran ?></td>
                                        <td><?= $dtl->Start_Time ?></td>
                                        <td><?= $dtl->Time_Over ?></td>
                                        <td><?= floatval($dtl->Stand_Hour) ?></td>
                                        <td><?= $dtl->SysId ?></td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
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
            <div class="modal-footer">
                <button type="button" id="select-data" class="btn btn-primary float-start"><i class="far fa-save"></i> Select</button>
                <button type="button" class="btn btn-danger float-end" data-bs-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>