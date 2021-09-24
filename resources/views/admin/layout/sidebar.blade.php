<div class="sidebar">
    <nav>
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">Menu Navigation</li>
        <li class="nav-item">
          <a href="{{ route('admin.account.dashboard.index') }}" class="nav-link @if(isset($activeSideBarMenu) && $activeSideBarMenu == 'Dashboard') active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p class="px-2">
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link {{ (request()->is('oem*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-tie"></i>
            <p class="px-2">
              Admin Management
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link {{ (request()->is('oem*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p class="px-2">
              User Management
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.account.question.index') }}" class="nav-link @if(isset($activeSideBarMenu) && $activeSideBarMenu == 'QuestionManagement') active @endif">
            <i class="nav-icon fas fa-question-circle"></i>
            <p class="px-2">
              Question Management
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link {{ (request()->is('oem*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-box-open"></i>
            <p class="px-2">
              Subject Management
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link {{ (request()->is('oem*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-brain"></i>
            <p class="px-2">
              Exam Management
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link {{ (request()->is('oem*')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-gift"></i>
            <p class="px-2">
              Gift Management
            </p>
          </a>
        </li>
        
      </ul>
    </nav>
  </div>