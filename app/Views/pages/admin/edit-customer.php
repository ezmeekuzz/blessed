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
                            <h4><i class="fas fa-user-edit"></i> Edit Customer</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-0">
                                <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="ti ti-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="/admin/customer-masterlist">Customers</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Customer Form -->
            <form id="editCustomerForm">
                <?= csrf_field() ?>
                <input type="hidden" name="customer_id" id="customerId" value="<?= $customer['user_id'] ?>">
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
                                            <input type="text" name="firstname" id="firstname" class="form-control" value="<?= esc($customer['firstname']) ?>" required>
                                            <small class="form-text text-muted">Customer's first name.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="lastname" id="lastname" class="form-control" value="<?= esc($customer['lastname']) ?>" required>
                                            <small class="form-text text-muted">Customer's last name.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="emailaddress">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" name="emailaddress" id="emailaddress" class="form-control" value="<?= esc($customer['emailaddress']) ?>" required>
                                            <small class="form-text text-muted">This will be used for login and notifications.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-lock mr-2"></i>Change Password (Optional)</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Leave password fields empty to keep current password.
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Minimum 6 characters. Leave empty to keep current password.</small>
                                            <div class="password-strength mt-2" id="passwordStrength" style="display: none;">
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                                </div>
                                                <small class="text-muted" id="strengthText">Enter a password</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_password">Confirm New Password</label>
                                            <div class="input-group">
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirm_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Re-enter the new password to confirm.</small>
                                            <div id="passwordMatch" class="mt-1"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="col-lg-4">
                        <!-- Customer Info Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-id-card"></i> Customer Information</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="avatar-circle" style="width: 100px; height: 100px; background-color: #3D204E; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                    <i class="fas fa-user fa-4x text-white"></i>
                                </div>
                                <h5><?= esc($customer['firstname'] . ' ' . $customer['lastname']) ?></h5>
                                <p class="text-muted">Customer ID: #<?= $customer['user_id'] ?></p>
                                <p class="text-muted">Member since: <?= date('F d, Y', strtotime($customer['created_at'])) ?></p>
                            </div>
                        </div>

                        <!-- Status Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-cog"></i> Account Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="status">Account Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="active" <?= $customer['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= $customer['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                    <small class="form-text text-muted">Inactive accounts cannot log in.</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="emailVerified" name="email_verified" value="1" <?= $customer['email_verified'] == 1 ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="emailVerified">Email verified</label>
                                    </div>
                                    <small class="form-text text-muted">If checked, customer's email is verified.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                                    <i class="fas fa-save"></i> Update Customer
                                </button>
                                <a href="/admin/customer-masterlist" class="btn btn-outline-secondary btn-block mt-2">
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
    .avatar-circle {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
</style>

<script src="<?= base_url(); ?>assets/js/admin/edit-customer.js"></script>