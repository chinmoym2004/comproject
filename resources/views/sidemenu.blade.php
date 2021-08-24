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
            <a href="{{ url('inbox') }}" class="nav-link {{ request()->is('inbox') || request()->is('/')?'active':'' }}">
                <i class="nav-icon fas fa-inbox"></i>
                <p>
                Inbox
                {{-- <span class="right badge badge-danger">New</span> --}}
                </p>
            </a>
            </li>
          <li class="nav-item">
            <a href="{{ url('chat-admins') }}" class="nav-link {{ request()->is('chat-admins') || request()->is('chat-admins/*')?'active':'' }}">
              <i class="nav-icon fas fa-comment"></i>
              <p>
                Admin Chat
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('forum-admins') }}" class="nav-link {{ request()->is('forum-admins') || request()->is('forum-admins/*')?'active':'' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Forums
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('circular-admin') }}" class="nav-link {{ request()->is('circular-admin') || request()->is('circular-admin/*')?'active':'' }}">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>
                Circular
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('chat-room') }}" class="nav-link {{ request()->is('chat-room') || request()->is('chat-room/*')?'active':'' }}">
              <i class="nav-icon fas fa-comment"></i>
              <p>
                Chat Room
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('categories') }}" class="nav-link {{ request()->is('categories') || request()->is('categories/*')?'active':'' }}">
              <i class="nav-icon fas fa-stream"></i>
              <p>
                Category
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('groups') }}" class="nav-link {{ request()->is('groups') || request()->is('groups/*')?'active':'' }}">
              <i class="nav-icon fas fa-object-ungroup"></i>
              <p>
                Groups 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ url('users') }}" class="nav-link {{ request()->is('users') || request()->is('users/*')?'active':'' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users 
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>