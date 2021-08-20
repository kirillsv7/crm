<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        {{ config('app.name', 'Laravel') }}
    </div>
    <ul class="c-sidebar-nav ps">
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="{{ route('dashboard') }}">
                <i class="c-sidebar-nav-icon cil-spreadsheet"></i>
                Dashboard
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/users">
                <i class="c-sidebar-nav-icon cil-user"></i>
                Users
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/clients">
                <i class="c-sidebar-nav-icon cil-address-book"></i>
                Clients
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/projects">
                <i class="c-sidebar-nav-icon cil-briefcase"></i>
                Projects
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a class="c-sidebar-nav-link" href="/tasks">
                <i class="c-sidebar-nav-icon cil-list-rich"></i>
                Tasks
            </a>
        </li>

        <i class="cis-playlist-add-check"></i>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized">
    </button>
</div>
