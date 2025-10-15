<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box">
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('data/logo.png')}}" alt="" height="30">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('data/logo.png')}}" alt="" height="40">
                    </span>
                </a>
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('data/logo.png')}}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('data/logo.png')}}" alt="" height="40">
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
                                <a href="{{route('admin-user.index')}}" class="tp-link">All Admin Users</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>             


                <li>
                    <a href="#brand" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Brand Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="brand">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('brand.index')}}" class="tp-link">All Brands</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#warehouse" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Warehouse Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="warehouse">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('warehouse.index')}}" class="tp-link">All WareHouses</a>
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
                                <a href="{{route('supplier.index')}}" class="tp-link">All Suppliers</a>
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
                                <a href="{{route('customer.index')}}" class="tp-link">All Customers</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#product" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Product Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="product">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('category.index')}}" class="tp-link">All Categories</a>
                            </li>
                            <li>
                                <a href="{{route('product.index')}}" class="tp-link">All Products</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

               <li>
                    <a href="#purchase" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Purchase Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="purchase">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('purchase.index')}}" class="tp-link">All Purchase</a>
                            </li>
                            <li>
                                <a href="{{route('return-purchase.index')}}" class="tp-link">Purchase Return</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#sale" data-bs-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Sale Manage </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sale">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('sale.index')}}" class="tp-link">All Sales</a>
                            </li>
                            <li>
                                <a href="{{route('sale.index')}}" class="tp-link">Sale Return</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#sidebarExpages" data-bs-toggle="collapse">
                        <i data-feather="file-text"></i>
                        <span> Utility </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarExpages">
                        <ul class="nav-second-level">
                            <li>
                                <a href="pages-starter.html" class="tp-link">Starter</a>
                            </li>
                            <li>
                                <a href="pages-profile.html" class="tp-link">Profile</a>
                            </li>
                            <li>
                                <a href="pages-pricing.html" class="tp-link">Pricing</a>
                            </li>
                            <li>
                                <a href="pages-timeline.html" class="tp-link">Timeline</a>
                            </li>
                            <li>
                                <a href="pages-invoice.html" class="tp-link">Invoice</a>
                            </li>
                            <li>
                                <a href="pages-faqs.html" class="tp-link">FAQs</a>
                            </li>
                            <li>
                                <a href="pages-gallery.html" class="tp-link">Gallery</a>
                            </li>
                            <li>
                                <a href="pages-maintenance.html" class="tp-link">Maintenance</a>
                            </li>
                            <li>
                                <a href="pages-coming-soon.html" class="tp-link">Coming Soon</a>
                            </li>
                        </ul>
                    </div>
                </li>

                

                <li class="menu-title mt-2">General</li>

                <li>
                    <a href="#sidebarBaseui" data-bs-toggle="collapse">
                        <i data-feather="package"></i>
                        <span> Components </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarBaseui">
                        <ul class="nav-second-level">
                            <li>
                                <a href="ui-accordions.html" class="tp-link">Accordions</a>
                            </li>
                            <li>
                                <a href="ui-alerts.html" class="tp-link">Alerts</a>
                            </li>
                            <li>
                                <a href="ui-badges.html" class="tp-link">Badges</a>
                            </li>
                            <li>
                                <a href="ui-breadcrumb.html" class="tp-link">Breadcrumb</a>
                            </li>
                            <li>
                                <a href="ui-buttons.html" class="tp-link">Buttons</a>
                            </li>
                            <li>
                                <a href="ui-cards.html" class="tp-link">Cards</a>
                            </li>
                            <li>
                                <a href="ui-collapse.html" class="tp-link">Collapse</a>
                            </li>
                            <li>
                                <a href="ui-dropdowns.html" class="tp-link">Dropdowns</a>
                            </li>
                            <li>
                                <a href="ui-video.html" class="tp-link">Embed Video</a>
                            </li>
                            <li>
                                <a href="ui-grid.html" class="tp-link">Grid</a>
                            </li>
                            <li>
                                <a href="ui-images.html" class="tp-link">Images</a>
                            </li>
                            <li>
                                <a href="ui-list.html" class="tp-link">List Group</a>
                            </li>
                            <li>
                                <a href="ui-modals.html" class="tp-link">Modals</a>
                            </li>
                            <li>
                                <a href="ui-placeholders.html" class="tp-link">Placeholders</a>
                            </li>
                            <li>
                                <a href="ui-pagination.html" class="tp-link">Pagination</a>
                            </li>
                            <li>
                                <a href="ui-popovers.html" class="tp-link">Popovers</a>
                            </li>
                            <li>
                                <a href="ui-progress.html" class="tp-link">Progress</a>
                            </li>
                            <li>
                                <a href="ui-scrollspy.html" class="tp-link">Scrollspy</a>
                            </li>
                            <li>
                                <a href="ui-spinners.html" class="tp-link">Spinners</a>
                            </li>
                            <li>
                                <a href="ui-tabs.html" class="tp-link">Tabs</a>
                            </li>
                            <li>
                                <a href="ui-tooltips.html" class="tp-link">Tooltips</a>
                            </li>
                            <li>
                                <a href="ui-typography.html" class="tp-link">Typography</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="widgets.html" class="tp-link">
                        <i data-feather="aperture"></i>
                        <span> Widgets </span>
                    </a>
                </li>

                <li>
                    <a href="#sidebarAdvancedUI" data-bs-toggle="collapse">
                        <i data-feather="cpu"></i>
                        <span> Extended UI </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAdvancedUI">
                        <ul class="nav-second-level">
                            <li>
                                <a href="extended-carousel.html" class="tp-link">Carousel</a>
                            </li>
                            <li>
                                <a href="extended-notifications.html" class="tp-link">Notifications</a>
                            </li>
                            <li>
                                <a href="extended-offcanvas.html" class="tp-link">Offcanvas</a>
                            </li>
                            <li>
                                <a href="extended-range-slider.html" class="tp-link">Range Slider</a>
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
