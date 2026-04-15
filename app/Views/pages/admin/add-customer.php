<?= $this->include('templates/admin/header'); ?>

<div class="app-container">
    <?= $this->include('templates/admin/sidebar'); ?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <!-- Page Title & Breadcrumb -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="page-title">
                            <h4><i class="fas fa-user-plus"></i> Add Customer</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-0">
                                <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="ti ti-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="/admin/user-masterlist">Customers</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Customer</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Customer Form -->
            <form id="addCustomerForm">
                <?= csrf_field() ?>
                <div class="row">
                    <!-- Main Content Area -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-user-circle mr-2"></i>Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter first name" required>
                                            <small class="form-text text-muted">Customer's first name.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter last name" required>
                                            <small class="form-text text-muted">Customer's last name.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="emailaddress">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" name="emailaddress" id="emailaddress" class="form-control" placeholder="customer@example.com" required>
                                            <small class="form-text text-muted">This will be used for login and notifications.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-lock mr-2"></i>Security</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Minimum 6 characters. Include a mix of letters and numbers.</small>
                                            <div class="password-strength mt-2" id="passwordStrength">
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                                </div>
                                                <small class="text-muted" id="strengthText">Enter a password</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Re-enter the password to confirm.</small>
                                            <div id="passwordMatch" class="mt-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="col-lg-4">
                        <!-- Status Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-cog"></i> Account Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="status">Account Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <small class="form-text text-muted">Inactive accounts cannot log in.</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="emailVerified" name="email_verified" value="1">
                                        <label class="custom-control-label" for="emailVerified">Mark email as verified</label>
                                    </div>
                                    <small class="form-text text-muted">If checked, customer won't need to verify their email.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                                    <i class="fas fa-save"></i> Add Customer
                                </button>
                                <button type="button" class="btn btn-secondary btn-block mt-2" id="resetFormBtn">
                                    <i class="fas fa-undo-alt"></i> Reset Form
                                </button>
                                <a href="/admin/user-masterlist" class="btn btn-outline-secondary btn-block mt-2">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('templates/admin/footer'); ?>

<!-- Additional CSS -->
<style>
    .password-strength .progress-bar {
        transition: width 0.3s ease;
    }
    .password-strength.weak .progress-bar {
        background-color: #dc3545;
        width: 25%;
    }
    .password-strength.fair .progress-bar {
        background-color: #ffc107;
        width: 50%;
    }
    .password-strength.good .progress-bar {
        background-color: #17a2b8;
        width: 75%;
    }
    .password-strength.strong .progress-bar {
        background-color: #28a745;
        width: 100%;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    .password-match-success {
        color: #28a745;
        font-size: 12px;
    }
    .password-match-error {
        color: #dc3545;
        font-size: 12px;
    }
</style>

<script src="<?= base_url(); ?>assets/js/admin/add-customer.js"></script>