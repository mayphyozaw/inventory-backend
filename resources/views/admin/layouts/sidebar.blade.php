<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('data/logo.png') }}" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('data/logo.png') }}" alt="" height="40">
                    </span>
                </a>
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('data/logo.png') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('data/logo.png') }}" alt="" height="40">
                    </span>
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="#sidebarDashboards" data-bs-toggle="collapse">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                        <span class="menu-arrow"></span>
                    </a>
                </li>


                <li class="menu-title">Pages</li>

                <li>
                    <a href="#sidebarAuth" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Admin Users Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAuth">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('admin-user.index') }}" class="tp-link">All Admin Users</a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#brand" data-bs-toggle="collapse">
                        <i data-feather="list"></i>
                        <span> Brand Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="brand">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('brand.index') }}" class="tp-link">All Brands</a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#warehouse" data-bs-toggle="collapse">
                        <i data-feather="layers"></i>
                        <span> Warehouse Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="warehouse">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('warehouse.index') }}" class="tp-link">All WareHouses</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#supplier" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Supplier Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="supplier">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('supplier.index') }}" class="tp-link">All Suppliers</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#customer" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Customer Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="customer">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('customer.index') }}" class="tp-link">All Customers</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#product" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Product Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="product">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('category.index') }}" class="tp-link">All Categories</a>
                            </li>
                            <li>
                                <a href="{{ route('product.index') }}" class="tp-link">All Products</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#purchase" data-bs-toggle="collapse">
                        <i data-feather="shopping-bag"></i>
                        <span> Purchase Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="purchase">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('purchase.index') }}" class="tp-link">All Purchase</a>
                            </li>
                            <li>
                                <a href="{{ route('return-purchase.index') }}" class="tp-link">Purchase Return</a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#sale" data-bs-toggle="collapse">
                        <i data-feather="dollar-sign"></i>
                        <span> Sale Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sale">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('sale.index') }}" class="tp-link">All Sales</a>
                            </li>
                            <li>
                                <a href="{{ route('sale-return.index') }}" class="tp-link">Sale Return</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#due" data-bs-toggle="collapse">
                        <i data-feather="alert-octagon"></i>
                        <span> Due Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="due">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('due.sale_due') }}" class="tp-link">Sale Due</a>
                            </li>
                            <li>
                                <a href="{{ route('due.sale_return_due') }}" class="tp-link">Sale Return Due</a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#transfers" data-bs-toggle="collapse">
                        <i data-feather="alert-octagon"></i>
                        <span> Transfers Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="transfers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('transfer.index') }}" class="tp-link">All Transfers</a>
                            </li>


                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#report" data-bs-toggle="collapse">
                        <i data-feather="bar-chart"></i>
                        <span> Report Setup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="report">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('all.report') }}" class="tp-link">All Reports</a>
                            </li>


                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#role" data-bs-toggle="collapse">
                        <i data-feather="shield"></i>
                        <span> Roles </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="role">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('role.index') }}" class="tp-link">Roles</a>
                            </li>


                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#permission" data-bs-toggle="collapse">
                        <i data-feather="shield"></i>
                        <span> Permission </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="permission">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('permission.index') }}" class="tp-link">Permission</a>
                            </li>


                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#rolespermission" data-bs-toggle="collapse">
                        <i data-feather="shield"></i>
                        <span> Roles in Permission </span>
                        <span class="menu-arrow"></span>
                    </a>
                <div class="collapse" id="rolespermission">
                    <ul class="nav-second-level">
                        
                        <li>
                            <a href="{{ route('add.roles.permission') }}" class="tp-link">Roles in Permission</a>
                        </li>


                    </ul>
                </div>

                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
