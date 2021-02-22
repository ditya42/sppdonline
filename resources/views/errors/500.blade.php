<!doctype html>
<html lang="en">

<head>
<title>E-SPPD Tabalong | 500</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Aplikasi SPPD Online Kabupaten Tabalong">
<meta name="author" content="E-SPPD Tabalong">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{ ('assets_admin/vendor/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ ('assets_admin/vendor/animate-css/animate.min.css') }}">
<link rel="stylesheet" href="{{ ('assets_admin/vendor/font-awesome/css/font-awesome.min.css') }}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ ('assets_admin/css/main.css') }}">
<link rel="stylesheet" href="{{ ('assets_admin/css/color_skins.css') }}">
</head>

<body class="theme-blue">
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="mobile-logo" style="margin-top: -30px;"><a href="{{ url('/') }}"><img src="{{ ('images/logo-tabalong.png') }}" alt="E-SPPD"></a></div>
                    <div class="auth-left">
                        <div class="left-top">
                            <a href="index.html">
                                <img src="{{ ('images/logo-tabalong.png') }}" alt="E-SPPD">
                                <span>E-SPPD</span>
                            </a>
                        </div>
                        <div class="left-slider">
                            <img src="{{ ('assets_admin/images/login/3.jpg') }}" class="img-fluid" style="margin-top: -98px;" alt="">
                        </div>
                    </div>
                    <div class="auth-right">
                        <div class="card">
                            <div class="header">
                                <p class="lead">500 <span class="text">Oops!</span></p>
                            </div>
                            <div class="body">
                                <p>Mohon Maaf Terjadi Kesalahan Pada Server</p>
                                <div class="margin-top-30">
                                    <a href="javascript:history.go(-1)" class="btn btn-default"><i class="fa fa-arrow-left"></i> <span>Kembali</span></a>
                                    <a href="{{ url('/') }}" class="btn btn-primary"><i class="fa fa-home"></i> <span>Dashboard</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- END WRAPPER -->
</body>
</html>

