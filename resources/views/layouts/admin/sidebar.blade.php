<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
  <div class="sidebar-header border-bottom">
    <div class="sidebar-brand">
      <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
        <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
      </svg>
      <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
        <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
      </svg>
    </div>
    <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
  </div>
  <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard.index') }}">
      <i class="fa-solid fa-gauge me-3"></i> Dashboard</a></li>

    @if (check_authorized("002A"))
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">
          <i class="fa-solid fa-users me-3"></i> Users</a></li>
    @endif

    @if (check_authorized("003A"))
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.roles.index') }}">
          <i class="fa-solid fa-id-card me-3"></i> Jabatan</a></li>
    @endif

  </ul>
  <div class="sidebar-footer border-top d-none d-md-flex">
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
  </div>
</div>