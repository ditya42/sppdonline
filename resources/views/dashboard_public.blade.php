@extends('layouts/login/body')
@section('content')
<body class="theme-blue">
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
                    <div class="mobile-logo">
                        <h2 style="color: #fff;">E-SPPD</h2>
                    </div>
                    <div class="auth-left">
                        <div class="left-top">
                            <a href="#">
                                <img src="{{ asset('assets_admin/images/logo.png') }}" alt="Mplify">
                                <span>E-SPPD</span>
                            </a>
                        </div>
                        <div class="left-slider">
                            <img src="{{ asset('assets_admin/images/login/3.jpg') }}" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="auth-right">
                        <div class="card">
                            <div class="header">
                                <p class="lead">Log in</p>
                            </div>
                            <div class="body">
                                <form class="form-auth-small" action="{{ url('/login') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="nip" class="control-label sr-only">NIP</label>
                                        <input type="text" class="form-control" name="nip" id="nip" placeholder="NIP">
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="control-label sr-only">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-lg btn-block">LOGIN</button>
                                    <div class="bottom">
                                        {{-- <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="#">Forgot password?</a></span> --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
</body>
@endsection

