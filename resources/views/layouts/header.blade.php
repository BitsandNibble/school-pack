<div class="topbar d-flex align-items-center bg-dark shadow-none border-light-2 border-bottom">
  <nav class="navbar navbar-expand">
    <div class="mobile-toggle-menu text-white me-3"><i class='bx bx-menu'></i>
    </div>
    <div class="top-menu-left d-none d-lg-block">
      <ul class="nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('components') }}"><i class='bx bx-wind'></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="app-chat-box.html"><i class='bx bx-message'></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="app-fullcalender.html"><i class='bx bx-calendar'></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="app-to-do.html"><i class='bx bx-check-square'></i></a>
        </li>
      </ul>
    </div>
    <div class="search-bar flex-grow-1">
      <div class="position-relative search-bar-box">
        <form>
          <input type="text" class="form-control search-control" autofocus placeholder="Type to search..."> <span
            class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
          <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
        </form>
      </div>
    </div>

    <div class="top-menu ms-auto">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item dropdown dropdown-large">
          <div class="dropdown-menu dropdown-menu-end">
            <div class="header-notifications-list"></div>
          </div>
        </li>
        <li class="nav-item dropdown dropdown-large">
          <div class="dropdown-menu dropdown-menu-end">
            <div class="header-message-list"></div>
          </div>
        </li>
        <li class="nav-item dropdown dropdown-large">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret text-white" href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false"> <i class='bx bx-category'></i>
          </a>
          <div class="dropdown-menu dropdown-menu-end">
            <div class="row row-cols-3 g-3 p-3">
              <div class="col text-center">
                <div class="app-box mx-auto bg-gradient-cosmic text-white"><i class='bx bx-group'></i>
                </div>
                <div class="app-title">Teams</div>
              </div>
              <div class="col text-center">
                <div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i>
                </div>
                <div class="app-title">Projects</div>
              </div>
              <div class="col text-center">
                <div class="app-box mx-auto bg-gradient-lush text-white"><i class='bx bx-shield'></i>
                </div>
                <div class="app-title">Tasks</div>
              </div>
              <div class="col text-center">
                <div class="app-box mx-auto bg-gradient-kyoto text-dark"><i class='bx bx-notification'></i>
                </div>
                <div class="app-title">Feeds</div>
              </div>
              <div class="col text-center">
                <div class="app-box mx-auto bg-gradient-blues text-dark"><i class='bx bx-file'></i>
                </div>
                <div class="app-title">Files</div>
              </div>
              <div class="col text-center">
                <div class="app-box mx-auto bg-gradient-moonlit text-white"><i class='bx bx-filter-alt'></i>
                </div>
                <div class="app-title">Alerts</div>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>

    <div class="user-box dropdown border-light-2">
      <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" role="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        <img src="{{ asset('assets/_images/avatars/avatar-10.png') }}" class="user-img" alt="user avatar">
        <div class="user-info ps-3">
          <p class="user-name mb-0 text-white">
            {{ auth()->user()->fullname ?? '' }}
          </p>
          <p class="designattion mb-0">Principal</p>
        </div>
      </a>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('principal.profile') }}"><i
              class="bx bx-user"></i><span>Profile</span></a>
        </li>
        <li><a class="dropdown-item" href="{{ route('principal.settings') }}"><i
              class="bx bx-cog"></i><span>Settings</span></a>
        </li>
        <li>
          <div class="dropdown-divider mb-0"></div>
        </li>
        <livewire:components.logout />
      </ul>
    </div>
  </nav>
</div>
