<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title;?> - The Blessed Manifest</title>
        <link rel="icon" href="<?=base_url();?>images/favicon.png" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
        <link rel="stylesheet" href="<?=base_url();?>css/styles.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg py-2">
            <div class="container">
                <a class="navbar-brand" href="<?=base_url();?>">
                    <img src="<?=base_url();?>images/logo.png" alt="The Blessed Manifest Logo">
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?php if($activeMenu == 'home') { echo 'active'; } ?>" aria-current="page" href="<?=base_url();?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?php if($activeMenu == 'products') { echo 'active'; } ?>" href="<?=base_url();?>products">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?php if($activeMenu == 'blogs') { echo 'active'; } ?>" href="<?=base_url();?>blogs">Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?php if($activeMenu == 'about') { echo 'active'; } ?>" href="<?=base_url();?>about-us">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?php if($activeMenu == 'faq') { echo 'active'; } ?>" href="<?=base_url();?>faq">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?php if($activeMenu == 'contact') { echo 'active'; } ?>" href="<?=base_url();?>contact-us">Contact Us</a>
                        </li>
                    </ul>
                    
                    <div class="icon-group d-flex">
                        <!--<a href="#" class="icon-circle" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </a>-->
                        
                        <!-- ENHANCED USER DROPDOWN - POLISHED LAYOUT -->
                        <div class="user-dropdown-wrapper" id="userDropdownWrapper">
                            <a href="#" class="icon-circle" aria-label="User account" id="userIconTrigger">
                                <i class="bi bi-person"></i>
                            </a>
                            <div class="user-dropdown-menu" aria-labelledby="userIconTrigger">
                                <!-- Header Section - Changes based on login state -->
                                <?php if(!session()->has('UserLoggedIn')) : ?>
                                    <!-- Guest Header -->
                                    <div class="dropdown-user-header d-flex align-items-center gap-3">
                                        <div class="user-avatar-large">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div class="user-welcome-text">
                                            <div class="greeting">Welcome to</div>
                                            <div class="username">Blessed Manifest</div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <!-- Logged In Header -->
                                    <div class="dropdown-user-header d-flex align-items-center gap-3">
                                        <div class="user-avatar-large" style="background: linear-gradient(135deg, #3D204E 0%, #8B6B9D 100%);">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <div class="user-welcome-text">
                                            <div class="greeting">Welcome back,</div>
                                            <div class="username"><?= session()->get('user_firstname') . ' ' . session()->get('user_lastname') ?></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            
                                <!-- Main Links Section -->
                                <div class="dropdown-links-container">
                                    <?php if(!session()->has('UserLoggedIn')) : ?>
                                        <!-- NOT LOGGED IN STATE -->
                                        <!-- Register Link -->
                                        <a href="<?=base_url();?>register" class="dropdown-link-enhanced">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Create Account</span>
                                            <span class="badge-new">Join Free</span>
                                        </a>
                                        
                                        <!-- Login Link -->
                                        <a href="<?=base_url();?>login" class="dropdown-link-enhanced">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                            <span>Sign In</span>
                                            <i class="bi bi-chevron-right ms-auto" style="width: auto; font-size: 0.8rem; opacity: 0.6;"></i>
                                        </a>
                                        
                                        <!-- Divider -->
                                        <div class="dropdown-divider-custom"></div>
                                        
                                        <!-- Forgot Password -->
                                        <a href="<?=base_url();?>forgot-password" class="dropdown-link-enhanced">
                                            <i class="bi bi-question-circle"></i>
                                            <span>Forgot Password?</span>
                                        </a>
                                        
                                        <!-- Browse Products -->
                                        <a href="<?=base_url();?>products" class="dropdown-link-enhanced">
                                            <i class="bi bi-grid-3x3-gap-fill"></i>
                                            <span>Browse Products</span>
                                        </a>
                                        
                                    <?php else : ?>
                                        <!-- LOGGED IN STATE -->
                                        <!-- Dashboard -->
                                        <a href="<?=base_url();?>dashboard" class="dropdown-link-enhanced">
                                            <i class="bi bi-speedometer2"></i>
                                            <span>Dashboard</span>
                                        </a>
                                        
                                        <!-- My Orders -->
                                        <a href="<?=base_url();?>orders" class="dropdown-link-enhanced">
                                            <i class="bi bi-receipt"></i>
                                            <span>My Orders</span>
                                        </a>
                                        
                                        <!-- My Profile -->
                                        <a href="<?=base_url();?>profile" class="dropdown-link-enhanced">
                                            <i class="bi bi-person-gear"></i>
                                            <span>My Profile</span>
                                        </a>
                                        
                                        <!-- Wishlist -->
                                        <a href="<?=base_url();?>wishlist" class="dropdown-link-enhanced">
                                            <i class="bi bi-heart"></i>
                                            <span>Wishlist</span>
                                        </a>
                                        
                                        <!-- Divider -->
                                        <div class="dropdown-divider-custom"></div>
                                        
                                        <!-- Account Settings -->
                                        <!--<a href="<?=base_url();?>account-settings" class="dropdown-link-enhanced">
                                            <i class="bi bi-gear"></i>
                                            <span>Account Settings</span>
                                        </a>-->
                                        
                                        <!-- Help & Support -->
                                        <!--<a href="<?=base_url();?>help-center" class="dropdown-link-enhanced">
                                            <i class="bi bi-question-circle"></i>
                                            <span>Help & Support</span>
                                        </a>-->
                                        
                                        <!-- Divider -->
                                        <div class="dropdown-divider-custom"></div>
                                        
                                        <!-- Logout -->
                                        <a href="<?=base_url();?>logout" class="dropdown-link-enhanced" id="logoutLink">
                                            <i class="bi bi-box-arrow-right"></i>
                                            <span>Sign Out</span>
                                            <i class="bi bi-chevron-right ms-auto" style="width: auto; font-size: 0.8rem; opacity: 0.6;"></i>
                                        </a>
                                        
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Footer Section - Support Link -->
                                <div class="dropdown-footer d-flex justify-content-between align-items-center">
                                    <a href="<?=base_url();?>faq" class="help-link">
                                        <i class="bi bi-headset"></i>
                                        <span>Need Help?</span>
                                    </a>
                                    <span class="small text-muted" style="font-size: 0.7rem;">v2.0</span>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#" class="icon-circle" aria-label="Shopping cart">
                            <i class="bi bi-cart3"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>