<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Archivo de conexión a la base de datos (db.php)
$base = "/index.php";
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href=<?php echo $base; ?> />
    <title>Katzkin</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="katzkin login" />
    <meta property="og:url" content="#" />
    <meta property="og:site_name" content="login" />
    <link rel="canonical" href="#" />
    <link rel="shortcut icon" href="../assets/media/ktz/ki.png" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <link href="../assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <script src="../assets/plugins/global/plugins.bundle.js"></script>
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="../assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->
<style>
.light-danger {
    background-color: var(--bs-danger-light) !important;
}
</style>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
        body {
            background-image: url('assets/media/background/bg-1.jpg');
        }
        </style>
        <!--end::Page bg image-->

        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <!--begin::Aside-->
            <div class="d-none d-lg-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <!--begin::Aside-->
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <a href="#">
                        <img alt="Logo" class="h-150px" src="/assets/media/ktz/logo_white.png">
                    </a>
                </div>
                <!--begin::Aside-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div
                class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <!--begin::Card-->
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        <div class="d-flex flex-center flex-lg-start flex-column">
                            <a href="#" class="mb-7">
                                <img alt="Logo" class="px-20px h-150px" src="/assets/media/ktz/cow_logo.png">
                            </a>
                        </div>
                        <!--begin::Form-->
                        <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" id="login">
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">
                                    Iniciar Sesión
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Separator-->
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">Inicio</span>
                            </div>
                            <!--end::Separator-->
                            <!--begin::Input group--->
                            <div class="fv-row mb-8 fv-plugins-icon-container">
                                <!--begin::Email-->
                                <input type="text" placeholder="username" name="username" id="username" required
                                    autocomplete="off" class="form-control bg-transparent">
                                <!--end::Email-->
                                <div
                                    class="fv-plugins-message-container 
                                    fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <!--end::Input group--->
                            <div class="fv-row mb-3 fv-plugins-icon-container">
                                <!--begin::Password-->
                                <input type="password" placeholder="Password" name="password" autocomplete="off"
                                    class="form-control bg-transparent">
                                <!--end::Password-->
                                <div
                                    class="fv-plugins-message-container 
                                    fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <!--end::Input group--->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <div id="loading" style="display: none;">
                                    Loading...
                                </div>
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">
                                        Iniciar Sesión</span>
                                    <!--end::Indicator label-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--begin::Footer-->
                    <div class="d-flex flex-stack px-lg-10">
                        <!--begin::Links-->
                        <div class="d-flex fw-semibold text-primary fs-base gap-5">
                            <a href="http://cloudhunter.solutions" target="_blank">Terms</a>
                            <a href="http://cloudhunter.solutions" target="_blank">Contactanos</a>
                        </div>
                        <!--end::Links-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
    $('#login').submit(function(e) {
        e.preventDefault();
        $('#loading').show(); // Uncomment this line to display the loading message
        var formData = $(this).serializeArray();
        var dataObject = {};

        $.each(formData, function(i, v) {
            dataObject[v.name] = v.value;
        });
        $.ajax({
            url: 'app/login.php',
            type: 'POST',
            data: dataObject,
            success: function(response) {
                // console.log(response);
                if (response.status == 'success') {
                    Swal.fire({
                        text: response.message,
                        icon: 'success',
                        title: 'Bienvenido',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = "/index.php";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Response text: ', jqXHR.responseText); // Add this line
                console.log(textStatus, errorThrown);
            }
        });
    });
    </script>
    <!--end::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <svg id="SvgjsSvg1001" width="2" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.dev"
        style="overflow: hidden; top: -100%; left: -100%; position: absolute; opacity: 0;">
        <defs id="SvgjsDefs1002"></defs>
        <polyline id="SvgjsPolyline1003" points="0,0"></polyline>
        <path id="SvgjsPath1004" d="M0 0 "></path>
    </svg>
    <!--end::Global Javascript Bundle-->
</body>
<!--end::Body-->

</html>