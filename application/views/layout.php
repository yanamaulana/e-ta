<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $this->config->item('init_app_name') ?> | <?= $page_title ?></title>
    <meta name="base_url" content="<?= base_url() ?>">
    <meta name="description" content="E Teacher Attendance" />
    <meta name="keywords" content="E Teacher Attendance" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="E-Teacher Attendance" />
    <meta property="og:url" content="<?= base_url() ?>" />
    <meta property="og:site_name" content="E-Teacher Attendance" />
    <link rel="canonical" href="<?= base_url() ?>" />
    <link rel="shortcut icon" href="<?= base_url() ?>assets/E-TA_assets/web-logo/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="<?= base_url() ?>assets/Metronic/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/Metronic/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/Metronic/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/Metronic/dist/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/Metronic/dist/assets/css/custom.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url() ?>assets/global-assets/jquery/jquery.min.js"></script>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed">
    <!-- data-kt-aside-minimize="on" -->
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
                <div class="aside-logo flex-column-auto" id="kt_aside_logo">
                    <a href="<?= base_url() ?>">
                        <img alt="Logo" src="<?= base_url() ?>assets/E-TA_assets/logo-app/ETA_logo_flat_transparent.png" class="h-50px logo" />
                    </a>
                    <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
                        <span class="svg-icon svg-icon-1 rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black" />
                                <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black" />
                            </svg>
                        </span>
                    </div>
                </div>
                <?php
                $Menu = $this->uri->segment(1);
                $Sess_Jabatan = $this->session->userdata('sys_jabatan');
                ?>
                <div class="aside-menu flex-column-fluid">
                    <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
                        <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
                            <div class="menu-item">
                                <div class="menu-content pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1">Main Menu</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link <?= ($Menu == 'Dashboard') ? 'active' : null ?>" href="<?= base_url('Dashboard') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <div class="menu-content pt-8 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">Utility</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link <?= ($Menu == 'MyAttendance') ? 'active' : null ?>" href="<?= base_url('MyAttendance') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fas fa-chart-line fs-2"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">My Attendance</span>
                                </a>
                                <a class="menu-link <?= ($Menu == 'MyPaycheck') ? 'active' : null ?>" href="<?= base_url('MyPaycheck') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fas fas fa-file fs-2"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">My Paycheck</span>
                                </a>
                            </div>
                            <!-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="black"></path>
                                                <rect x="6" y="12" width="7" height="2" rx="1" fill="black"></rect>
                                                <rect x="6" y="7" width="12" height="2" rx="1" fill="black"></rect>
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="menu-title">Chat</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <div class="menu-sub menu-sub-accordion" style="display: none; overflow: hidden;" kt-hidden-height="117">
                                    <div class="menu-item">
                                        <a class="menu-link" href="../../demo1/dist/apps/chat/private.html">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Private Chat</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="../../demo1/dist/apps/chat/group.html">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Group Chat</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link" href="../../demo1/dist/apps/chat/drawer.html">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">Drawer Chat</span>
                                        </a>
                                    </div>
                                </div>
                            </div> -->
                            <div class="menu-item">
                                <div class="menu-content pt-4 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">TEACHER SCHEDULE</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link <?= ($Menu == 'My_Schedule') ? 'active' : null ?>" href="<?= base_url('My_Schedule') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fas fa-th-list fs-2"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">My Schedule</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link <?= ($Menu == 'FormSchedule') ? 'active' : null ?>" href="<?= base_url('FormSchedule') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fab fa-wpforms fs-2"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">Form Schedule</span>
                                </a>
                            </div>
                            <?php if ($Sess_Jabatan != 'GURU') : ?>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'ApprovalSchedule') ? 'active' : null ?>" href="<?= base_url('ApprovalSchedule') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="far fa-paper-plane fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Approval Schedule</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="menu-item">
                                <a class="menu-link <?= ($Menu == 'MyArchiveSchedule') ? 'active' : null ?>" href="<?= base_url('MyArchiveSchedule') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fas fa-archive fs-2"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">My Archive Schedule</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <div class="menu-content pt-4 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">LUPA ABSEN & KEGIATAN LUAR</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link <?= ($Menu == 'SubmissionAttendance') ? 'active' : null ?>" href="<?= base_url('SubmissionAttendance') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fas fa-hourglass-half fs-2" style="rotate: 45deg;"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">Pengajuan Absensi</span>
                                </a>
                            </div>
                            <?php if ($Sess_Jabatan != 'GURU') : ?>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'ApprovalAttendance') ? 'active' : null ?>" href="<?= base_url('ApprovalAttendance') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="far fa-paper-plane fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Approval Attendance</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="menu-item">
                                <div class="menu-content pt-4 pb-2">
                                    <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">KEGIATAN RAPAT</span>
                                </div>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link <?= ($Menu == 'Rapat' && $this->uri->segment(2) == 'Approval_Leader') ? 'active' : null ?>" href="<?= base_url('Rapat/Approval_Leader') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fas fa-quote-left fs-2"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">Approval Pimpinan</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a class="menu-link <?= ($Menu == 'Rapat' && $this->uri->segment(2) == 'Rapat_Open') ? 'active' : null ?>" href="<?= base_url('Rapat/Rapat_Open') ?>">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fas fa-users fs-2"></i>
                                        </span>
                                    </span>
                                    <span class="menu-title">Join Rapat</span>
                                </a>
                            </div>
                            <?php if ($Sess_Jabatan != 'GURU') : ?>
                                <div class="menu-item">
                                    <div class="menu-content pt-4 pb-2">
                                        <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">Payroll</span>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'ManageSalary') ? 'active' : null ?>" href="<?= base_url('ManageSalary') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M22 7H2V11H22V7Z" fill="black"></path>
                                                    <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z" fill="black"></path>
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="menu-title">Manage Salary</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'CalculatePayroll' && $this->uri->segment(2) == '') ? 'active' : null ?>" href="<?= base_url('CalculatePayroll') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-calculator fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Calculate Payroll</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'HistoryPayroll' && $this->uri->segment(2) == '') ? 'active' : null ?>" href="<?= base_url('HistoryPayroll') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-book fs-2" style="rotate: 45deg;"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">History Payroll</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <div class="menu-content pt-4 pb-2">
                                        <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">OVER TIME</span>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'OverTime' && $this->uri->segment(2) == '') ? 'active' : null ?>" href="<?= base_url('OverTime') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-hourglass-end fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Input Over Time</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'OverTime' && $this->uri->segment(2) == 'Monitoring') ? 'active' : null ?>" href="<?= base_url('OverTime/Monitoring') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-tag fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Monitoring Over Time</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <div class="menu-content pt-4 pb-2">
                                        <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">GURU PIKET</span>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'GuruPiket' && $this->uri->segment(2) == '') ? 'active' : null ?>" href="<?= base_url('GuruPiket') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-people-carry fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Input Guru Piket</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'GuruPiket' && $this->uri->segment(2) == 'Monitoring') ? 'active' : null ?>" href="<?= base_url('GuruPiket/Monitoring') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-folder-open fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Monitoring Guru Piket</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <div class="menu-content pt-4 pb-2">
                                        <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">RAPAT</span>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'Rapat' && $this->uri->segment(2) == '') ? 'active' : null ?>" href="<?= base_url('Rapat') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-handshake fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Buat Rapat</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'Rapat' && $this->uri->segment(2) == 'Monitoring') ? 'active' : null ?>" href="<?= base_url('Rapat/Monitoring') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-folder-open fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Monitoring Rapat</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <div class="menu-content pt-4 pb-2">
                                        <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">PETUGAS UPACARA</span>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'Upacara' && $this->uri->segment(2) == '') ? 'active' : null ?>" href="<?= base_url('Upacara') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-flag fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Input Petugas Upacara</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'Upacara' && $this->uri->segment(2) == 'Monitoring') ? 'active' : null ?>" href="<?= base_url('Upacara/Monitoring') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-folder-open fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Monitoring Petugas Upacara</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <div class="menu-content pt-4 pb-2">
                                        <span class="menu-section text-muted text-uppercase fs-8 ls-1 fw-bold">MONITORING ATTENDANCE</span>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'MonitoringAttendance') ? 'active' : null ?>" href="<?= base_url('MonitoringAttendance') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <i class="fas fa-sign-in-alt fs-2"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Monitoring Attendance</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <div class="menu-content">
                                        <div class="separator mx-1 my-4"></div>
                                    </div>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link <?= ($Menu == 'Master') ? 'active' : null ?>" href="<?= base_url('Master') ?>">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M16.95 18.9688C16.75 18.9688 16.55 18.8688 16.35 18.7688C15.85 18.4688 15.75 17.8688 16.05 17.3688L19.65 11.9688L16.05 6.56876C15.75 6.06876 15.85 5.46873 16.35 5.16873C16.85 4.86873 17.45 4.96878 17.75 5.46878L21.75 11.4688C21.95 11.7688 21.95 12.2688 21.75 12.5688L17.75 18.5688C17.55 18.7688 17.25 18.9688 16.95 18.9688ZM7.55001 18.7688C8.05001 18.4688 8.15 17.8688 7.85 17.3688L4.25001 11.9688L7.85 6.56876C8.15 6.06876 8.05001 5.46873 7.55001 5.16873C7.05001 4.86873 6.45 4.96878 6.15 5.46878L2.15 11.4688C1.95 11.7688 1.95 12.2688 2.15 12.5688L6.15 18.5688C6.35 18.8688 6.65 18.9688 6.95 18.9688C7.15 18.9688 7.35001 18.8688 7.55001 18.7688Z" fill="black" />
                                                    <path opacity="0.3" d="M10.45 18.9687C10.35 18.9687 10.25 18.9687 10.25 18.9687C9.75 18.8687 9.35 18.2688 9.55 17.7688L12.55 5.76878C12.65 5.26878 13.25 4.8687 13.75 5.0687C14.25 5.1687 14.65 5.76878 14.45 6.26878L11.45 18.2688C11.35 18.6688 10.85 18.9687 10.45 18.9687Z" fill="black" />
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="menu-title">Master Data</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
                    <a href="<= base_url() ?>assets/Metronic/dist/documentation/getting-started.html" class="btn btn-custom btn-primary w-100" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" title="200+ in-house components and 3rd-party plugins">
                        <span class="btn-label">Docs &amp; Components</span>
                        <span class="svg-icon btn-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM15 17C15 16.4 14.6 16 14 16H8C7.4 16 7 16.4 7 17C7 17.6 7.4 18 8 18H14C14.6 18 15 17.6 15 17ZM17 12C17 11.4 16.6 11 16 11H8C7.4 11 7 11.4 7 12C7 12.6 7.4 13 8 13H16C16.6 13 17 12.6 17 12ZM17 7C17 6.4 16.6 6 16 6H8C7.4 6 7 6.4 7 7C7 7.6 7.4 8 8 8H16C16.6 8 17 7.6 17 7Z" fill="black" />
                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                            </svg>
                        </span>
                    </a>
                </div> -->
            </div>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <div id="kt_header" class="header align-items-stretch">
                    <div class="container-fluid d-flex align-items-stretch justify-content-between">
                        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
                            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                                <span class="svg-icon svg-icon-2x mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
                                        <path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
                            <a href="<?= base_url('Dashboard') ?>" class="d-lg-none">
                                <img alt="Logo" src="<?= base_url() ?>assets/Metronic/dist/assets/media/logos/logo-2.svg" class="h-30px" />
                            </a>
                        </div>
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <div class="d-flex align-items-center" id="kt_header_nav">
                                <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_header_nav'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"><?= $this->config->item('init_app_name') ?></h1>
                                    <span class="h-20px border-gray-200 border-start mx-4"></span>
                                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                                        <li class="breadcrumb-item text-muted">
                                            <a href="<?= base_url('Dashboard') ?>" class="text-muted text-hover-primary">Menu</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-200 w-5px h-2px"></span>
                                        </li>
                                        <li class="breadcrumb-item text-dark"><?= $page_title ?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex align-items-stretch flex-shrink-0">
                                <div class="d-flex align-items-stretch flex-shrink-0">
                                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                                        <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z" fill="black" />
                                                    <path d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z" fill="black" />
                                                    <path opacity="0.3" d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z" fill="black" />
                                                    <path opacity="0.3" d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z" fill="black" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                                            <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('<?= base_url() ?>assets/Metronic/dist/assets/media/misc/pattern-1.jpg')">
                                                <h3 class="text-white fw-bold px-9 mt-10 mb-6">Notifications</h3>
                                                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-bold px-9">
                                                    <li class="nav-item">
                                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="kt_topbar_notifications_3" role="tabpanel">
                                                    <div class="scroll-y mh-325px my-5 px-8">
                                                        <div class="d-flex flex-stack py-4">
                                                            <div class="d-flex align-items-center me-2">
                                                                <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                                                <a href="#" class="text-gray-800 text-hover-primary fw-bold">New order</a>
                                                            </div>
                                                            <span class="badge badge-light fs-8">Just now</span>
                                                        </div>
                                                    </div>
                                                    <div class="py-3 text-center border-top">
                                                        <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">View All
                                                            <span class="svg-icon svg-icon-5">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                                                    <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                            <img src="<?= base_url() ?>assets/Metronic/dist/assets/media/avatars/blank.png" alt="user" />
                                        </div>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <div class="symbol symbol-50px me-5">
                                                        <img alt="Logo" src="<?= base_url() ?>assets/Metronic/dist/assets/media/avatars/blank.png" />
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bolder d-flex align-items-center fs-5"><?= $this->session->userdata('sys_nama') ?></div>
                                                        <a href="#" class="fw-bold text-muted text-hover-primary fs-7"><?= $this->session->userdata('sys_role') ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="separator my-2"></div>
                                            <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
                                                <a href="#" class="menu-link px-5">
                                                    <span class="menu-title">Account Setting</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                    <div class="menu-item px-3">
                                                        <a href="<?= base_url('Master/Change_Password') ?>" class="menu-link px-5">Password</a>
                                                    </div>
                                                    <div class="menu-item px-3">
                                                        <a href="<?= base_url() ?>assets/Metronic/dist/account/billing.html" class="menu-link px-5">My Profile</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="separator my-2"></div>
                                            <div class="menu-item px-5">
                                                <a href="<?= base_url('Auth/logout') ?>" class="menu-link px-5">Sign Out</a>
                                            </div>
                                            <div class="separator my-2"></div>
                                            <div class="menu-item px-5">
                                                <div class="menu-content px-5">
                                                    <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="kt_user_menu_dark_mode_toggle">
                                                        <span class="form-check-label text-gray-600 fs-7"><?= $this->session->userdata('sys_email') ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-main flex-column flex-row-fluid py-4" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_content" class="app-content  flex-column-fluid ">
                            <div id="kt_app_content_container" class="app-container  container-fluid ">
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row w-100 p-5 mb-5">
                                        <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="black"></path>
                                                <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="black"></path>
                                            </svg>
                                        </span>
                                        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                            <h4 class="mb-2 text-light">Success!</h4>
                                            <span><?php echo $this->session->flashdata('success'); ?></span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="fas fa-times fs-2x"></i>
                                        </button>
                                    </div>
                                <?php } else if ($this->session->flashdata('error')) { ?>
                                    <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 p-5 mb-5">
                                        <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="black"></path>
                                                <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="black"></path>
                                            </svg>
                                        </span>
                                        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                            <h4 class="mb-2 text-light">Error!</h4>
                                            <span><?php echo $this->session->flashdata('error'); ?></span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="fas fa-times fs-2x"></i>
                                        </button>
                                    </div>
                                <?php } else if ($this->session->flashdata('warning')) { ?>
                                    <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row w-100 p-5 mb-5">
                                        <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="black"></path>
                                                <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="black"></path>
                                            </svg>
                                        </span>
                                        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                            <h4 class="mb-2 text-light">Warning!</h4>
                                            <span><?php echo $this->session->flashdata('warning'); ?></span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="fas fa-times fs-2x"></i>
                                        </button>
                                    </div>
                                <?php } else if ($this->session->flashdata('info')) { ?>
                                    <div class="alert alert-dismissible bg-info d-flex flex-column flex-sm-row w-100 p-5 mb-5">
                                        <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z" fill="black"></path>
                                                <path d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z" fill="black"></path>
                                            </svg>
                                        </span>
                                        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                            <h4 class="mb-2 text-light">Info!</h4>
                                            <span><?php echo $this->session->flashdata('info'); ?></span>
                                        </div>
                                        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                            <i class="fas fa-times fs-2x"></i>
                                        </button>
                                    </div>
                                <?php } ?>
                                <?php $this->load->view($page_content) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                        <div class="text-dark order-2 order-md-1">
                            <span class="text-muted fw-bold me-1">2023©</span>
                            <a href="https://yanamaulana.github.io" target="_blank" class="text-gray-800 text-hover-primary">Developer</a>
                        </div>
                        <ul class="menu menu-gray-600 menu-hover-primary fw-bold order-1">
                            <li class="menu-item">
                                <a href="#" class="menu-link px-2">About</a>
                            </li>
                            <li class="menu-item">
                                <a href="#" class="menu-link px-2">Support</a>
                            </li>
                            <li class="menu-item">
                                <a href="<?= $this->config->item('website') ?>" target="_blank" class="menu-link px-2">Company Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black" />
                <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="black" />
            </svg>
        </span>
    </div>

    <script>
        var hostUrl = "<?= base_url() ?>assets/Metronic/dist/assets/";
    </script>
    <script src="<?= base_url() ?>assets/Metronic/dist/assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url() ?>assets/Metronic/dist/assets/js/scripts.bundle.js"></script>
    <script src="<?= base_url() ?>assets/Metronic/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="<?= base_url() ?>assets/Metronic/dist/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="<?= base_url() ?>assets/global-assets/jquery-validation/jquery.validate.js"></script>
    <?= $script_page ?>
</body>

</html>