<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="py-5">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">
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
                    <form class="form-horizontal" id="form_update">
                        <input type="hidden" id="SysId" name="SysId" value="<?= $Hdr_Schedule->SysId ?>">
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Nomor Jadwal :</label>
                                    <input type="text" readonly class="form-control form-control-sm" id="schedule_number" name="schedule_number" value="<?= $Hdr_Schedule->Schedule_Number ?>" placeholder="AUTO...">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="fv-row mb-5">
                                    <label class="form-label">Nama Guru :</label>
                                    <input type="text" readonly class="form-control form-control-sm" id="Nama" name="Nama" value="<?= $employee->Nama ?>" placeholder="Nama...">
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <label class="form-label">Status Jadwal :</label>
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
                        </div>
                        <div class="fv-row">
                            <div class="col-xl-12 col-md-12">
                                <div class="pb-5 table-responsive">
                                    <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border w-100 gy-5 gs-5">
                                        <thead style="background-color: #3B6D8C;">
                                            <tr class="text-start text-white fw-bolder text-uppercase">
                                                <th class="text-center text-white">#</th>
                                                <th class="text-center text-white">HARI</th>
                                                <th class="text-center text-white">KELAS</th>
                                                <th class="text-center text-white">MAPEL</th>
                                                <th class="text-center text-white">MULAI PADA</th>
                                                <th class="text-center text-white">SELESAI PADA</th>
                                                <th class="text-center text-white">JAM BERDIRI</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold" id="tbody">
                                            <?php $i = 1; ?>
                                            <?php foreach ($Dtl_Schedule as $dtl) : ?>
                                                <tr>
                                                    <td><?= $i; ?></td>
                                                    <td>
                                                        <div class="fv-row">
                                                            <select class="form-select form-select-sm day" required style="width: 100%;" name="day[]">
                                                                <option selected disabled value="">Pilih Hari...</option>
                                                                <option <?php if ($dtl->Day == "Monday") echo 'selected' ?> value="Monday">Senin</option>
                                                                <option <?php if ($dtl->Day == "Tuesday") echo 'selected' ?> value="Tuesday">Selasa</option>
                                                                <option <?php if ($dtl->Day == "Wednesday") echo 'selected' ?> value="Wednesday">Rabu</option>
                                                                <option <?php if ($dtl->Day == "Thursday") echo 'selected' ?> value="Thursday">Kamis</option>
                                                                <option <?php if ($dtl->Day == "Friday") echo 'selected' ?> value="Friday">Jumat</option>
                                                                <option <?php if ($dtl->Day == "Saturday") echo 'selected' ?> value="Saturday">Sabtu</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row">
                                                            <select class="form-select form-select-sm" required style="width: 100%;" name="class[]">
                                                                <option selected disabled value="">Pilih Kelas...</option>
                                                                <?php foreach ($Class as $class) : ?>
                                                                    <option <?php if ($dtl->Kelas_ID == $class->SysId) echo 'selected' ?> value="<?= $class->SysId ?>"><?= $class->Kelas ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row">
                                                            <select class="form-select form-select-sm subject" required style="width: 100%;" name="subject[]">
                                                                <option selected disabled value="">Pilih Mapel...</option>
                                                                <?php foreach ($Subjects as $subject) : ?>
                                                                    <option <?php if ($dtl->Subject_ID == $subject->SysId) echo 'selected' ?> value="<?= $subject->SysId ?>"><?= $subject->Mata_Pelajaran ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row"><input placeholder="Mulai pada..." value="<?= $dtl->Start_Time ?>" type="text" class="form-control text-center form-control-sm time_start" required name="time_start[]"></div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row"><input placeholder="Selesai pada..." value="<?= $dtl->Time_Over ?>" type="text" class="form-control text-center form-control-sm time_over" required name="time_over[]"></div>
                                                    </td>
                                                    <td>
                                                        <div class="fv-row">
                                                            <select class="form-select form-select-sm text-center stand_hour" required name="hour_stand[]">
                                                                <option selected disabled value="">Jam Berdiri...</option>
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
                        <div class="fv-row text-center mt-5">
                            <div class="btn-group mt-5" role="group" aria-label="Basic example">
                                <button type="button" id="add-row" class="btn btn-success" title="add row"><i class="fas fa-plus"></i></button>&nbsp;
                                <button type="button" id="remove-row" class="btn btn-danger" title="remove last row"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-warning">
                    <a href="<?= base_url('Dashboard') ?>" id="cancel-form" class="btn btn-danger float-end"><i class="far fa-times-circle"></i> Kembali</a>
                    <button type="button" id="submit--data" class="btn btn-primary float-start"><i class="far fa-save"></i> Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</div>