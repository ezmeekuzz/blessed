<aside class="app-navbar">
    <div class="sidebar-nav scrollbar scroll_dark">
        <ul class="metismenu" id="sidebarNav">
            <li class="nav-static-title">MAIN</li>
            <li <?php if($activeMenu == 'dashboard') echo 'class="active"'; ?>>
                <a href="/admin/dashboard">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <span class="nav-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-static-title">CONTENT</li>
            <!-- Blog Management -->
            <li <?php if(in_array($activeMenu, ['addblog', 'blogmasterlist', 'blogcategories'])) echo 'class="active"'; ?>>
                <a class="has-arrow" href="javascript:void(0)">
                    <i class="nav-icon fas fa-newspaper"></i>
                    <span class="nav-title">Blog Posts</span>
                </a>
                <ul>
                    <li <?php if($activeMenu == 'addblog') echo 'class="active"'; ?>>
                        <a href='/admin/add-blog'>Add Blog Post</a>
                    </li>
                    <li <?php if($activeMenu == 'blogmasterlist') echo 'class="active"'; ?>>
                        <a href='/admin/blog-masterlist'>Blog Masterlist</a>
                    </li>
                    <li <?php if($activeMenu == 'blogcategories') echo 'class="active"'; ?>>
                        <a href='/admin/blog-categories'>Categories</a>
                    </li>
                </ul>
            </li>

            <li class="nav-static-title">PRODUCTS</li>
            <!-- Products -->
            <li <?php if(in_array($activeMenu, ['addproduct', 'productmasterlist', 'productcategories'])) echo 'class="active"'; ?>>
                <a class="has-arrow" href="javascript:void(0)">
                    <i class="nav-icon fas fa-box"></i>
                    <span class="nav-title">Products</span>
                </a>
                <ul>
                    <li <?php if($activeMenu == 'addproduct') echo 'class="active"'; ?>>
                        <a href='/admin/add-product'>Add Product</a>
                    </li>
                    <li <?php if($activeMenu == 'productmasterlist') echo 'class="active"'; ?>>
                        <a href='/admin/product-masterlist'>Product Masterlist</a>
                    </li>
                    <li <?php if($activeMenu == 'productcategories') echo 'class="active"'; ?>>
                        <a href='/admin/product-categories'>Categories</a>
                    </li>
                </ul>
            </li>

            <!-- Custom Orders -->
            <li <?php if($activeMenu == 'customorders') echo 'class="active"'; ?>>
                <a href="/admin/custom-orders">
                    <i class="nav-icon fas fa-paint-brush"></i>
                    <span class="nav-title">Custom Orders</span>
                </a>
            </li>

            <li class="nav-static-title">DESIGN ASSETS</li>
            <!-- Fonts Management -->
            <li <?php if(in_array($activeMenu, ['fonts', 'addfont', 'fontcategories'])) echo 'class="active"'; ?>>
                <a class="has-arrow" href="javascript:void(0)">
                    <i class="nav-icon fas fa-font"></i>
                    <span class="nav-title">Fonts</span>
                </a>
                <ul>
                    <li <?php if($activeMenu == 'addfont') echo 'class="active"'; ?>>
                        <a href='/admin/add-font'>Add Font</a>
                    </li>
                    <li <?php if($activeMenu == 'fonts') echo 'class="active"'; ?>>
                        <a href='/admin/font-masterlist'>Fonts Masterlist</a>
                    </li>
                </ul>
            </li>

            <!-- Templates Management (like Canva) -->
            <li <?php if(in_array($activeMenu, ['gridtemplates', 'addgridtemplate', 'layouttemplates', 'addlayouttemplate'])) echo 'class="active"'; ?>>
                <a class="has-arrow" href="javascript:void(0)">
                    <i class="nav-icon fas fa-palette"></i>
                    <span class="nav-title">Templates</span>
                </a>
                <ul>
                    <li <?php if($activeMenu == 'addgridtemplate') echo 'class="active"'; ?>>
                        <a href='/admin/add-grid-template'>Add Grid Template</a>
                    </li>
                    <li <?php if($activeMenu == 'gridtemplates') echo 'class="active"'; ?>>
                        <a href='/admin/grid-templates-masterlist'>Grid Templates Masterlist</a>
                    </li>
                    <li <?php if($activeMenu == 'addlayouttemplate') echo 'class="active"'; ?>>
                        <a href='/admin/add-layout-template'>Add Layout Template</a>
                    </li>
                    <li <?php if($activeMenu == 'layouttemplates') echo 'class="active"'; ?>>
                        <a href='/admin/layout-templates-masterlist'>Layout Templates Masterlist</a>
                    </li>
                </ul>
            </li>

            <!-- Design Elements (Optional) -->
            <li <?php if(in_array($activeMenu, ['addclipart', 'clipartmasterlist', 'addsticker', 'stickermasterlist'])) echo 'class="active"'; ?>>
                <a class="has-arrow" href="javascript:void(0)">
                    <i class="nav-icon fas fa-shapes"></i>
                    <span class="nav-title">Design Elements</span>
                </a>
                <ul>
                    <li <?php if($activeMenu == 'addclipart') echo 'class="active"'; ?>>
                        <a href='/admin/add-clipart'>Add Clip Art</a>
                    </li>
                    <li <?php if($activeMenu == 'clipartmasterlist') echo 'class="active"'; ?>>
                        <a href='/admin/clipart-masterlist'>Clip Art Masterlist</a>
                    </li>
                    <li <?php if($activeMenu == 'addsticker') echo 'class="active"'; ?>>
                        <a href='/admin/add-sticker'>Add Sticker</a>
                    </li>
                    <li <?php if($activeMenu == 'stickermasterlist') echo 'class="active"'; ?>>
                        <a href='/admin/sticker-masterlist'>Sticker Masterlist</a>
                    </li>
                </ul>
            </li>

            <li class="nav-static-title">ORDERS & SALES</li>
            <!-- Sales -->
            <li <?php if(in_array($activeMenu, ['salesorder', 'salesreport', 'refunds', 'shipping'])) echo 'class="active"'; ?>>
                <a class="has-arrow" href="javascript:void(0)">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <span class="nav-title">Orders & Sales</span>
                </a>
                <ul>
                    <li <?php if($activeMenu == 'salesorder') echo 'class="active"'; ?>>
                        <a href='/admin/sales-order'>All Orders</a>
                    </li>
                    <li <?php if($activeMenu == 'salesreport') echo 'class="active"'; ?>>
                        <a href='/admin/sales-report'>Sales Report</a>
                    </li>
                    <li <?php if($activeMenu == 'refunds') echo 'class="active"'; ?>>
                        <a href='/admin/refunds'>Refunds & Returns</a>
                    </li>
                    <li <?php if($activeMenu == 'shipping') echo 'class="active"'; ?>>
                        <a href='/admin/shipping-settings'>Shipping Settings</a>
                    </li>
                </ul>
            </li>

            <li class="nav-static-title">CUSTOMERS</li>
            <!-- Users -->
            <li <?php if(in_array($activeMenu, ['addcustomer', 'customermasterlist'])) echo 'class="active"'; ?>>
                <a class="has-arrow" href="javascript:void(0)">
                    <i class="nav-icon fas fa-users"></i>
                    <span class="nav-title">Customers</span>
                </a>
                <ul>
                    <li <?php if($activeMenu == 'addcustomer') echo 'class="active"'; ?>>
                        <a href='/admin/add-customer'>Add Customer</a>
                    </li>
                    <li <?php if($activeMenu == 'customermasterlist') echo 'class="active"'; ?>>
                        <a href='/admin/customer-masterlist'>Customer List</a>
                    </li>
                </ul>
            </li>

            <!-- Subscribers -->
            <li <?php if($activeMenu == 'subscribersmasterlist') echo 'class="active"'; ?>>
                <a href="/admin/subscribers-masterlist">
                    <i class="nav-icon fas fa-envelope-open-text"></i>
                    <span class="nav-title">Newsletter Subscribers</span>
                </a>
            </li>

            <!-- Reviews -->
            <li <?php if($activeMenu == 'reviews') echo 'class="active"'; ?>>
                <a href="/admin/reviews">
                    <i class="nav-icon fas fa-star"></i>
                    <span class="nav-title">Customer Reviews</span>
                </a>
            </li>

            <li class="nav-static-title">COMMUNICATIONS</li>
            <!-- Messages -->
            <li <?php if($activeMenu == 'messages') echo 'class="active"'; ?>>
                <a href="/admin/messages">
                    <i class="nav-icon fas fa-envelope"></i>
                    <span class="nav-title">Messages</span>
                </a>
            </li>

            <!-- Newsletter -->
            <li <?php if($activeMenu == 'sendnewsletter') echo 'class="active"'; ?>>
                <a href="/admin/send-newsletter">
                    <i class="nav-icon fas fa-bullhorn"></i>
                    <span class="nav-title">Send Newsletter</span>
                </a>
            </li>

            <!-- Email Templates -->
            <li <?php if($activeMenu == 'emailtemplates') echo 'class="active"'; ?>>
                <a href="/admin/email-templates">
                    <i class="nav-icon fas fa-envelope-open"></i>
                    <span class="nav-title">Email Templates</span>
                </a>
            </li>

            <li class="nav-static-title">SETTINGS</li>
            <li <?php if($activeMenu == 'settings') echo 'class="active"'; ?>>
                <a href="/admin/settings">
                    <i class="nav-icon ti ti-settings"></i>
                    <span class="nav-title">SETTINGS</span>
                </a>
            </li>

            <li class="nav-static-title">ANALYTICS</li>
            <li <?php if($activeMenu == 'analytics') echo 'class="active"'; ?>>
                <a href="/admin/analytics">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <span class="nav-title">Analytics</span>
                </a>
            </li>

            <li class="nav-static-title">SYSTEM</li>
            <li>
                <a href="/admin/logout">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <span class="nav-title">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>