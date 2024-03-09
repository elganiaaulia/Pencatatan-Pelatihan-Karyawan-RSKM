<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
<div class="sidenav-header">
  <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
  <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ Auth::user()->role_id == 1 ? route('admin.dashboard') : route('karyawan.dashboard') }}">
      <img src="{{asset('img_srsrt/logo-ihc.png')}}" class="navbar-brand-img h-100" alt="..." style="mix-blend-mode: multiply">
      <span class="ms-3 font-weight-bold">RSKM</span>
  </a>
</div>
<hr class="horizontal dark mt-0">
<div class="collapse navbar-collapse h-100 w-auto" id="sidenav-collapse-main">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ Auth::user()->role_id == 1 ? route('admin.dashboard') : route('karyawan.dashboard') }}">
        <div class="icon icon-shape icon-sm shadow border-radius-md {{ (Request::routeIs('admin.dashboard','karyawan.dashboard') ? 'bg-gradient-success' : 'bg-white') }} text-center me-2 d-flex align-items-center justify-content-center">
          <i style="font-size: 1rem;" class="fas fa-lg fa-home ps-2 pe-2 text-center text-dark {{ (Request::routeIs('admin.dashboard','karyawan.dashboard') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
        </div>
        <span class="nav-link-text ms-1">Dashboard</span>
      </a>
    </li>

    @if(auth()->user()->role_id == 1)
    <li class="nav-item mt-2">
      <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Akun</h6>
    </li>
      <li class="nav-item pb-2">
        <a class="nav-link" href="{{ route('users.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md {{ (Request::routeIs('users.*') ? 'bg-gradient-success' : 'bg-white') }} text-center me-2 d-flex align-items-center justify-content-center">
                <i style="font-size: 1rem;" class="fas fa-lg fa-user-cog ps-2 pe-2 text-center text-dark {{ (Request::routeIs('users.*') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Akun Karyawan</span>
        </a>
      </li>
    @endif

    <li class="nav-item mt-2">
      <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pelatihan</h6>
    </li>
    <li class="nav-item" style="overflow-x: hidden">
      <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingOne">
              <a href="#" class="nav-link accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                <div class="icon icon-shape icon-sm shadow border-radius-md {{ (Request::routeIs('periode.*','pelatihan.*','pencatatan.*') ? 'bg-gradient-success' : 'bg-white') }} text-center me-2 d-flex align-items-center justify-content-center">
                  <i style="font-size: 1rem;" class="fas fa-lg fa-newspaper ps-2 pe-2 text-center text-dark {{ (Request::routeIs('periode.*','pelatihan.*','pencatatan.*') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
                </div>
                <span class="nav-link-text ms-1">Periode Pelatihan</span>
              </a>
          </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">
              @if(auth()->user()->role_id == 1)
                @foreach ($periode as $item)
                    <a href="{{route('pelatihan.periode', $item->periode_name)}}" class="nav-link">
                        Periode {{ $item->periode_name }}
                    </a>
                @endforeach
                <a href="{{route('periode.create')}}" class="nav-link">
                  +&nbsp;{{__('Tambah Periode')}}
                </a>
              @else
                @foreach ($periode as $item)
                    <a href="{{route('pencatatan.show', $item->periode_name)}}" class="nav-link">
                        Periode {{ $item->periode_name }}
                    </a>
                @endforeach
              @endif
            </div>
        </div>
      </div>
    </li>
    
    @if(auth()->user()->role_id == 2)
      <li class="nav-item mt-2">
        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Akun</h6>
      </li>
      <li class="nav-item pb-2">
        <a class="nav-link" href="{{ route('karyawan.password') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md {{ (Request::routeIs('karyawan.password') ? 'bg-gradient-success' : 'bg-white') }} text-center me-2 d-flex align-items-center justify-content-center">
                <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center text-dark {{ (Request::routeIs('karyawan.password') ? 'text-white' : 'text-dark') }} " aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Kelola Akun</span>
        </a>
      </li>
    @endif

    <li class="nav-item d-flex align-items-center">
      <a href="{{ url('/logout')}}" class="nav-link">
          <span class="nav-link-text ms-1 text-danger">Sign Out</span>
      </a>
  </li>
  </ul>
</div>
</aside>
