<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $this->config->item('init_app_name') ?> | <?= $page_title ?></title>
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
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="<?= base_url() ?>assets/Metronic/dist/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/Metronic/dist/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="bg-body">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(<?= base_url() ?>assets/Metronic/dist/assets/media/illustrations/sketchy-1/14.png">
            <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                <a href="<?= base_url() ?>Auth" class="mb-12">
                    <img alt="Logo" src="<?= base_url() ?>assets/E-TA_assets/logo-app/ETA_logo_flat.png" class="h-90px" />
                </a>
                <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                    <form id="form-login" method="post" action="<?= base_url('Auth/post_login') ?>" class="form w-100" novalidate="novalidate">
                        <div class="text-center mb-10">
                            <h1 class="text-dark mb-3">Sign In to E-Teacher Attendance</h1>
                            <div class="text-gray-400 fw-bold fs-4">New Here?
                                <a href="<?= base_url('Auth/Register') ?>" class="link-primary fw-bolder">Register</a>
                            </div>
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label fs-6 fw-bolder text-dark">Username</label>
                            <input class="form-control form-control-lg form-control-solid" required type="text" name="username" id="username" autocomplete="off" placeholder="Username..." />
                        </div>
                        <div class="fv-row mb-10">
                            <div class="d-flex flex-stack mb-2">
                                <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                <span href="#" class="link-primary fs-6 fw-bolder">Forgot Password ?</span>
                            </div>
                            <input class="form-control form-control-lg form-control-solid" required type="password" name="password" id="password" autocomplete="off" placeholder="Password..." />
                        </div>
                        <div class="text-center">
                            <button type="submit" id="btn--login" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Sign-in</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex flex-center flex-column-auto p-10">
                <div class="d-flex align-items-center fw-bold fs-6">
                    <a href="#" class="text-muted text-hover-primary px-2">About</a>
                    <a href="#" class="text-muted text-hover-primary px-2">Contact</a>
                    <a href="#" class="text-muted text-hover-primary px-2">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="<?= base_url() ?>assets/Metronic/dist/assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?= base_url() ?>assets/Metronic/dist/assets/js/scripts.bundle.js"></script>
    <script src="<?= base_url() ?>assets/Metronic/dist/assets/js/custom/authentication/sign-in/general.js"></script>
    <script src="<?= base_url() ?>assets/global-assets/jquery-validation/jquery.validate.js"></script>
    <script src="<?= base_url() ?>assets/login-script/index.js"></script>
    <?php if ($this->session->flashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You must login first !',
                footer: '<a href="javascript:void(0)">Notification System</a>'
            });
        </script>
        <?php session_destroy() ?>
    <?php endif; ?>
</body>

</html>