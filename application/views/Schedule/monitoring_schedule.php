<div class="row gx-5 gx-xl-10">
    <div class="col-xl-12">
        <div class="card card-flush overflow-hidden h-xl-100">
            <div class="card-header py-5">
                <ul class="nav nav-pills nav-fill mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link mr-5 active" data-bs-toggle="tab" href="#kt_tab_pane_1">
                            <h4 class="card-title" id="table-title-main">Semua Jadwal</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_2">
                            <h4 class="card-title" id="table-title-history">Rekap Berdasarkan Guru</h4>
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
                        <div class="tab-pane fade active show" id="kt_tab_pane_1" role="tabpanel">
                            <div class="pb-5 table-responsive">
                                <table id="TableData" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border gy-5 gs-5 dataTable no-footer dtr-inline">
                                    <thead style="background-color: #3B6D8C;">
                                        <tr class="text-start text-white fw-bolder text-uppercase">
                                            <!-- // SysId,'Schedule_Number', 'ID_Access', 'Nama', 'Hari', 'Kelas', 'Subject_Code', 'Mata_Pelajaran', 'Start_Time', 'Time_Over', 'Stand_Hour'  -->
                                            <th class="text-center text-white">#</th>
                                            <th class="text-center text-white">NO. JADWAL</th>
                                            <th class="text-center text-white">ID ACCESS</th>
                                            <th class="text-center text-white">NAMA</th>
                                            <th class="text-center text-white">HARI</th>
                                            <th class="text-center text-white">KELAS</th>
                                            <th class="text-center text-white">KODE MAPEL</th>
                                            <th class="text-center text-white">MATA PELAJARAN</th>
                                            <th class="text-center text-white"><i class="fas fa-clock"></i> MULAI</th>
                                            <th class="text-center text-white"><i class="fas fa-clock"></i> SELESAI</th>
                                            <th class="text-center text-white">JAM BERDIRI</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-bold">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--=================================== PEMISAH TAB ===================================-->
                        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                            <div class="pb-5 table-responsive">
                                <table id="TableDataRekap" class="table-sm align-middle display compact dt-nowrap table-rounded table-striped table-bordered border gy-5 gs-5 dataTable no-footer dtr-inline">
                                    <thead style="background-color: #3B6D8C;">
                                        <tr class="text-start text-white fw-bolder text-uppercase">
                                            <th class="text-center text-white">#</th>
                                            <th class="text-center text-white">NO. JADWAL</th>
                                            <th class="text-center text-white">NAMA GURU</th>
                                            <th class="text-center text-white">STATUS KERJA</th>
                                            <th class="text-center text-white">JABATAN POKOK</th>
                                            <th class="text-center text-white">TGL DI BUAT</th>
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
        </div>
    </div>
</div>
<div id="location"></div>