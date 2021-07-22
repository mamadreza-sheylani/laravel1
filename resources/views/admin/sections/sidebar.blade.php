<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion pr-0" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Dario - club</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span> داشبورد </span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        فروشگاه
    </div>

    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.banners.index')}}">
            <i class="fas fa-fw fa-image"></i>
            <span> بنر ها </span></a>
    </li>

    <!-- Nav Item - brands -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.brands.index')}}">
            <i class="fas fa-store"></i>
            <span> برند ها </span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProduct"
            aria-expanded="true" aria-controls="collapseProduct">
            <i class="fas fa-fw fa-cart-plus"></i>
            <span>محصولات</span>
        </a>
        <div id="collapseProduct" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('admin.products.index')}}">محصولات</a>
                <a class="collapse-item" href="{{route('admin.categories.index')}}">دسته بندی ها</a>
                <a class="collapse-item" href="{{route('admin.tags.index')}}">تگ ها</a>
                <a class="collapse-item" href="{{route('admin.attributes.index')}}">ویژگی ها</a>
                <a class="collapse-item" href="{{route('admin.comments.index')}}">کامنت ها</a>
            </div>
            {{-- <div class="bg-white py-2 collapse-inner rounded">
            </div>
            <div class="bg-white py-2 collapse-inner rounded">
            </div> --}}
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
