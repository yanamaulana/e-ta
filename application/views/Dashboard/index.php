<div class="row gx-5 gx-xl-12">
  <div class="row">
    <div class="col-xl-12">
      <div class=" py-5">
        <div class="d-flex flex-stack ">
          <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
              E-Teacher Attendance
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
              <li class="breadcrumb-item text-muted">
                <a href="#" class="text-muted text-hover-primary">
                  Dashboards</a>
              </li>
              <!-- <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
              </li>
              <li class="breadcrumb-item text-muted">
                Dashboards </li> -->
            </ul>
          </div>
          <div class="d-flex align-items-center gap-2 gap-lg-3">
            <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary d-flex align-items-center px-4" data-kt-initialized="1">
              <div class="text-gray-600 fw-bold"><?= date('d F Y') ?></div>
              <span class="svg-icon svg-icon-1 ms-2 me-0"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path opacity="0.3" d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z" fill="currentColor"></path>
                  <path d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z" fill="currentColor"></path>
                  <path d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z" fill="currentColor"></path>
                </svg>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div id="kt_content_container" class="container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
          <div class="col-xl-4">
            <!--begin::Statistics Widget 5-->
            <a href="#" class="card bg-body-white hoverable card-xl-stretch mb-xl-8">
              <!--begin::Body-->
              <div class="card-body">
                <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm002.svg-->
                <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"></path>
                    <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"></path>
                  </svg>
                </span>
                <!--end::Svg Icon-->
                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5"><?= $do_jadwal->num_rows() ?> Total Jadwal</div>
                <div class="fw-bold text-gray-400">Total Jadwal yang harus di laksanakan hari ini</div>
              </div>
              <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
          </div>
          <div class="col-xl-4">
            <!--begin::Statistics Widget 5-->
            <a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
              <!--begin::Body-->
              <div class="card-body">
                <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                  <i class="fas fa-clock fs-2hx text-white"></i>
                </span>
                <!--end::Svg Icon-->
                <div class="text-white fw-bolder fs-2 mb-2 mt-5"><?= $jam_lembur->Jumlah_Jam; ?> Jam Lembur</div>
                <div class="fw-bold text-white">Total Jam Lembur Seluruh Karyawan Bulan <?= date('F') ?></div>
              </div>
              <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
          </div>
          <div class="col-xl-4">
            <!--begin::Statistics Widget 5-->
            <a href="#" class="card bg-success hoverable card-xl-stretch mb-5 mb-xl-8">
              <!--begin::Body-->
              <div class="card-body">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                  <i class="fas fa-user fs-2hx text-white"></i>
                </span>
                <!--end::Svg Icon-->
                <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5"><?= $employee->num_rows() ?> Karyawan Aktif</div>
                <div class="fw-bold text-white">Terdapat <?= $employee->num_rows() ?> karyawan Aktif</div>
              </div>
              <!--end::Body-->
            </a>
            <!--end::Statistics Widget 5-->
          </div>
        </div>
        <!--end::Row-->

        <!--begin::Row-->
        <div class="row g-5 g-xl-8">
          <div class="col-xl-6">
            <!--begin::List Widget 7-->
            <div class="card card-xl-stretch mb-xl-8">
              <!--begin::Header-->
              <div class="card-header align-items-center border-0 mt-4">
                <h3 class="card-title align-items-start flex-column">
                  <span class="fw-bolder text-dark">List Jadwal Hari ini </span>
                  <span class="text-muted mt-1 fw-bold fs-7">Semua Kelas dari pagi s/d sore</span>
                </h3>
                <div class="card-toolbar">
                  <!--begin::Menu-->
                  <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                    <span class="svg-icon svg-icon-2">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
                          <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                          <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                          <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                        </g>
                      </svg>
                    </span>
                    <!--end::Svg Icon-->
                  </button>
                </div>
              </div>
              <!--end::Header-->
              <!--begin::Body-->
              <div class="card-body pt-3">
                <!-- ============================================================ List Jadwal disini -->
                <table id="Today-Schedule" style="width: 100%;" class="table-sm align-middle table-rounded table-bordered border gy-5 gs-5">
                  <thead style="background-color: #3B6D8C;">
                    <tr class="text-start text-white fw-bolder text-uppercase">
                      <th class="text-center align-middle text-white">Guru</th>
                      <th class="text-center align-middle text-white">Mapel</th>
                      <th class="text-center align-middle text-white">Kelas</th>
                      <th class="text-center align-middle text-white"><i class="fas fa-clock text-white"></i> Mulai</th>
                      <th class="text-center align-middle text-white"><i class="fas fa-clock text-white"></i> Selesai</th>
                    </tr>
                  </thead>
                  <tbody class="text-dark fw-bold">
                    <?php foreach ($do_jadwal->result() as $sch) : ?>
                      <tr>
                        <td><?= $sch->Nama ?></td>
                        <td><?= $sch->Mata_Pelajaran ?></td>
                        <td><?= $sch->Kelas ?></td>
                        <td><?= $sch->Start_Time ?></td>
                        <td><?= $sch->Time_Over ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!--end::Body-->
            </div>
            <!--end::List Widget 7-->
          </div>





          <div class="col-xl-6">
            <!--begin::List Widget 6-->
            <div class="card card-xl-stretch mb-5 mb-xl-8">
              <!--begin::Header-->
              <div class="card-header border-0">
                <h3 class="card-title fw-bolder text-dark">Notifications</h3>
                <div class="card-toolbar">
                  <!--begin::Menu-->
                  <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                    <span class="svg-icon svg-icon-2">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <rect x="5" y="5" width="5" height="5" rx="1" fill="#000000"></rect>
                          <rect x="14" y="5" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                          <rect x="5" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                          <rect x="14" y="14" width="5" height="5" rx="1" fill="#000000" opacity="0.3"></rect>
                        </g>
                      </svg>
                    </span>
                    <!--end::Svg Icon-->
                  </button>
                  <!--begin::Menu 3-->
                  <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="menu-item px-3">
                      <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Payments</div>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Create Invoice</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link flex-stack px-3">Create Payment
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="" data-bs-original-title="Specify a target name for future usage and reference" aria-label="Specify a target name for future usage and reference"></i></a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                      <a href="#" class="menu-link px-3">Generate Bill</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-end">
                      <a href="#" class="menu-link px-3">
                        <span class="menu-title">Subscription</span>
                        <span class="menu-arrow"></span>
                      </a>
                      <!--begin::Menu sub-->
                      <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Plans</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Billing</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <a href="#" class="menu-link px-3">Statements</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        <div class="separator my-2"></div>
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                          <div class="menu-content px-3">
                            <!--begin::Switch-->
                            <label class="form-check form-switch form-check-custom form-check-solid">
                              <!--begin::Input-->
                              <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications">
                              <!--end::Input-->
                              <!--end::Label-->
                              <span class="form-check-label text-muted fs-6">Recuring</span>
                              <!--end::Label-->
                            </label>
                            <!--end::Switch-->
                          </div>
                        </div>
                        <!--end::Menu item-->
                      </div>
                      <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3 my-1">
                      <a href="#" class="menu-link px-3">Settings</a>
                    </div>
                    <!--end::Menu item-->
                  </div>
                  <!--end::Menu 3-->
                  <!--end::Menu-->
                </div>
              </div>
              <!--end::Header-->
              <!--begin::Body-->
              <div class="card-body pt-0">
                <!--begin::Item-->
                <div class="d-flex align-items-center bg-light-warning rounded p-5 mb-7">
                  <!--begin::Icon-->
                  <span class="svg-icon svg-icon-warning me-5">
                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                    <span class="svg-icon svg-icon-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"></path>
                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"></path>
                      </svg>
                    </span>
                    <!--end::Svg Icon-->
                  </span>
                  <!--end::Icon-->
                  <!--begin::Title-->
                  <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">Group lunch celebration</a>
                    <span class="text-muted fw-bold d-block">Due in 2 Days</span>
                  </div>
                  <!--end::Title-->
                  <!--begin::Lable-->
                  <span class="fw-bolder text-warning py-1">+28%</span>
                  <!--end::Lable-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center bg-light-success rounded p-5 mb-7">
                  <!--begin::Icon-->
                  <span class="svg-icon svg-icon-success me-5">
                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                    <span class="svg-icon svg-icon-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"></path>
                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"></path>
                      </svg>
                    </span>
                    <!--end::Svg Icon-->
                  </span>
                  <!--end::Icon-->
                  <!--begin::Title-->
                  <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">Navigation optimization</a>
                    <span class="text-muted fw-bold d-block">Due in 2 Days</span>
                  </div>
                  <!--end::Title-->
                  <!--begin::Lable-->
                  <span class="fw-bolder text-success py-1">+50%</span>
                  <!--end::Lable-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center bg-light-danger rounded p-5 mb-7">
                  <!--begin::Icon-->
                  <span class="svg-icon svg-icon-danger me-5">
                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                    <span class="svg-icon svg-icon-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"></path>
                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"></path>
                      </svg>
                    </span>
                    <!--end::Svg Icon-->
                  </span>
                  <!--end::Icon-->
                  <!--begin::Title-->
                  <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">Rebrand strategy planning</a>
                    <span class="text-muted fw-bold d-block">Due in 5 Days</span>
                  </div>
                  <!--end::Title-->
                  <!--begin::Lable-->
                  <span class="fw-bolder text-danger py-1">-27%</span>
                  <!--end::Lable-->
                </div>
                <!--end::Item-->
                <!--begin::Item-->
                <div class="d-flex align-items-center bg-light-info rounded p-5">
                  <!--begin::Icon-->
                  <span class="svg-icon svg-icon-info me-5">
                    <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                    <span class="svg-icon svg-icon-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black"></path>
                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black"></path>
                      </svg>
                    </span>
                    <!--end::Svg Icon-->
                  </span>
                  <!--end::Icon-->
                  <!--begin::Title-->
                  <div class="flex-grow-1 me-2">
                    <a href="#" class="fw-bolder text-gray-800 text-hover-primary fs-6">Product goals strategy</a>
                    <span class="text-muted fw-bold d-block">Due in 7 Days</span>
                  </div>
                  <!--end::Title-->
                  <!--begin::Lable-->
                  <span class="fw-bolder text-info py-1">+8%</span>
                  <!--end::Lable-->
                </div>
                <!--end::Item-->
              </div>
              <!--end::Body-->
            </div>
            <!--end::List Widget 6-->
          </div>
        </div>
        <!--end::Row-->
      </div>
    </div>
  </div>

</div>