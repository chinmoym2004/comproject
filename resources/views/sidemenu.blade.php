<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{ asset('img/logo-mini.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Communication</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
            <li class="nav-item">
            <a href="{{ url('inbox') }}" class="nav-link">
                <i class="nav-icon fas fa-inbox"></i>
                <p>
                Inbox
                {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>
            </li>
          <li class="nav-item">
            <a href="{{ url('chat-admins') }}" class="nav-link">
              <i class="nav-icon fas fa-comment"></i>
              <p>
                Chat
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('forum-admins') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Forums
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('circular-admin') }}" class="nav-link">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>
                Circular
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>