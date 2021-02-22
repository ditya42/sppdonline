<nav class="navbar navbar-fixed-top">
  <div class="container-fluid">
      <div class="navbar-brand">
          <a href="#">
              <img src="{{ asset('images/logo-tabalong.png') }}" alt="Mplify Logo" class="img-responsive logo">
              <span class="name">E-SPPD</span>
          </a>
      </div>

      <div class="navbar-right">
          <ul class="list-unstyled clearfix mb-0">
              <li>
                  <div class="navbar-btn btn-toggle-show">
                      <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                  </div>
                  <a href="javascript:void(0);" class="btn-toggle-fullwidth btn-toggle-hide"><i class="fa fa-bars"></i></a>
              </li>
              <li>
                  <div id="navbar-menu">
                      <ul class="nav navbar-nav">
                          <li class="dropdown">
                              <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                  <img class="rounded-circle" src="{{ asset('assets_admin/images/no-user.png') }}" width="30" alt="">
                              </a>
                              <div class="dropdown-menu animated flipInY user-profile">
                                  <div class="d-flex p-3 align-items-center">
                                      <div class="drop-left m-r-10">
                                          <img src="{{ asset('assets_admin/images/no-user.png') }}" class="rounded" width="50" alt="">
                                      </div>
                                      <div class="drop-right">
                                          @if(auth()->check())
                                          <p>{{ Auth::user()->nama_gelar }}<p>
                                          <p class="user-name">{{ Auth::user()->pegawai_nip }}</p>
                                          @endif
                                      </div>
                                  </div>
                                  <div class="m-t-10 p-3 drop-list">
                                      <ul class="list-unstyled">
                                          <li><a href="{{ route('profile') }}"><i class="icon-user"></i>My Profile</a></li>
                                          <li class="divider"></li>
                                          <li>
                                              <a href="{{ url('/logout') }}" class="logout-trigger">
                                              <i class="icon-power"></i> Logout </a>
                                          </li>
                                      </ul>
                                  </div>
                              </div>
                          </li>
                      </ul>
                  </div>
              </li>
          </ul>
      </div>
  </div>
</nav>

