<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
{{--            <a class="nav-link" target="_blank" href="{{ route('home.index') }}">--}}
{{--                <i class="bi bi-arrow-up-right-circle"></i>--}}
{{--                <span>برو به سایت</span>--}}
{{--            </a>--}}
        </li>
        <li class="nav-item">
            <a class="nav-link "
               href="{{ route('home') }}">
                <i class="bi bi-house"></i>
                <span>برو به سایت
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/slider*') ? 'active' : '' }}"
               href="{{ route('admin.sliders.index') }}">
                <i class="bi bi-images"></i>
                <span>اسلایدر</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/project*') ? 'active' : '' }}"
               href="{{ route('admin.projects.index') }}">
                <i class="bi bi-kanban"></i>
                <span>پروژه</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/menu*') ? 'active' : '' }}"
               href="{{ route('admin.menus.index') }}">
                <i class="bi bi-justify"></i>
                <span>منو</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/page*') ? 'active' : '' }}"
               href="{{ route('admin.pages.index') }}">
                <i class="bi bi-collection"></i>
                <span>صفحه</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/blog*') ? 'active' : '' }}"
               href="{{ route('admin.blogs.index') }}">
                <i class="bi bi-layout-text-window"></i>
                <span>مقاله</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/setting*') ? 'active' : '' }}"
               href="{{ route('admin.settings.index') }}">
                <i class="bi bi-gear"></i>
                <span>تنظیمات سایت</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/customer*') ? 'active' : '' }}"
               href="{{ route('admin.customers.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>مشتریان</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/service*') ? 'active' : '' }}"
               href="{{ route('admin.services.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>خدمات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/team*') ? 'active' : '' }}"
               href="{{ route('admin.teams.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>اعضای تیم</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin-panel/management/tender*') ? 'active' : '' }}"
               href="{{ route('admin.tenders.index') }}">
                <i class="bi bi-people-fill"></i>
                <span>مناقصه مزایده</span>
            </a>
        </li>

    </ul>
</aside><!-- End Sidebar-->
