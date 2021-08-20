<header class="c-header c-header-light px-3">
    <ul class="c-header-nav ml-auto">
        <li class="c-header-nav-item active">
            <a class="c-header-nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="c-header-nav-item">
            <a class="c-header-nav-link" href="#">Link</a>
        </li>
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
               data-toggle="dropdown" aria-expanded="false">
                <i class="cil-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
</header>
