<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="ti ti-settings"></i> Settings</h4>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Dashboard
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Settings
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Display Success/Error Messages -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check-circle"></i> <?=session()->getFlashdata('success');?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-circle"></i> <?=session()->getFlashdata('error');?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-circle"></i> Please fix the following errors:
                    <ul class="mb-0 mt-2">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?=$error;?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-lg-12">
                    <!-- Settings Card -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="settingsTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                                        <i class="ti ti-settings"></i> General
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="branding-tab" data-toggle="tab" href="#branding" role="tab" aria-controls="branding" aria-selected="false">
                                        <i class="ti ti-palette"></i> Branding
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="localization-tab" data-toggle="tab" href="#localization" role="tab" aria-controls="localization" aria-selected="false">
                                        <i class="ti ti-world"></i> Localization
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false">
                                        <i class="ti ti-mail"></i> Email
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form id="settingsForm" method="post" action="<?=base_url('admin/settings/update');?>" enctype="multipart/form-data">
                                <?=csrf_field();?>
                                <div class="tab-content" id="settingsTabContent">
                                    <!-- General Tab -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="site_name">Site Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="site_name" name="site_name" 
                                                           placeholder="Enter site name" 
                                                           value="<?=old('site_name', $settings['site_name'] ?? 'The Blessed Manifest');?>">
                                                    <small class="form-text text-muted">This will be displayed as the site title.</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="site_tagline">Tagline</label>
                                                    <input type="text" class="form-control" id="site_tagline" name="site_tagline" 
                                                           placeholder="Enter tagline" 
                                                           value="<?=old('site_tagline', $settings['site_tagline'] ?? '');?>">
                                                    <small class="form-text text-muted">A short phrase that describes your site.</small>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="site_description">Site Description</label>
                                                    <textarea class="form-control" id="site_description" name="site_description" 
                                                              rows="3" placeholder="Describe your site"><?=old('site_description', $settings['site_description'] ?? '');?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="timezone">Timezone</label>
                                                    <select class="form-control" id="timezone" name="timezone">
                                                        <?php
                                                        $timezones = [
                                                            'UTC' => 'UTC',
                                                            'America/New_York' => 'America/New_York',
                                                            'America/Chicago' => 'America/Chicago',
                                                            'America/Denver' => 'America/Denver',
                                                            'America/Los_Angeles' => 'America/Los_Angeles',
                                                            'Europe/London' => 'Europe/London',
                                                            'Europe/Paris' => 'Europe/Paris',
                                                            'Asia/Kolkata' => 'Asia/Kolkata',
                                                            'Asia/Tokyo' => 'Asia/Tokyo',
                                                            'Australia/Sydney' => 'Australia/Sydney',
                                                        ];
                                                        $selectedTz = old('timezone', $settings['timezone'] ?? 'UTC');
                                                        foreach($timezones as $value => $label): ?>
                                                            <option value="<?=$value;?>" <?=($selectedTz == $value) ? 'selected' : '';?>><?=$label;?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date_format">Date Format</label>
                                                    <select class="form-control" id="date_format" name="date_format">
                                                        <?php
                                                        $dateFormats = [
                                                            'Y-m-d' => 'YYYY-MM-DD (2025-01-15)',
                                                            'm/d/Y' => 'MM/DD/YYYY (01/15/2025)',
                                                            'd/m/Y' => 'DD/MM/YYYY (15/01/2025)',
                                                            'F j, Y' => 'Month Day, Year (January 15, 2025)',
                                                        ];
                                                        $selectedDateFormat = old('date_format', $settings['date_format'] ?? 'Y-m-d');
                                                        foreach($dateFormats as $value => $label): ?>
                                                            <option value="<?=$value;?>" <?=($selectedDateFormat == $value) ? 'selected' : '';?>><?=$label;?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="allow_registration">Allow User Registration</label>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="allow_registration" name="allow_registration" value="1" 
                                                               <?=(old('allow_registration', $settings['allow_registration'] ?? true) == '1') ? 'checked' : '';?>>
                                                        <label class="custom-control-label" for="allow_registration">Enable user registration</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email_verification">Email Verification</label>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="email_verification" name="email_verification" value="1" 
                                                               <?=(old('email_verification', $settings['email_verification'] ?? false) == '1') ? 'checked' : '';?>>
                                                        <label class="custom-control-label" for="email_verification">Require email verification for new users</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Branding Tab -->
                                    <div class="tab-pane fade" id="branding" role="tabpanel" aria-labelledby="branding-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Site Logo</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="site_logo" name="site_logo" accept="image/*">
                                                        <label class="custom-file-label" for="site_logo">Choose file</label>
                                                    </div>
                                                    <small class="form-text text-muted">Recommended size: 200x60px. Max 2MB. Allowed: JPG, PNG, SVG, WEBP</small>
                                                    <?php if(!empty($settings['site_logo'])): ?>
                                                        <div class="mt-3">
                                                            <div class="border p-2 d-inline-block rounded">
                                                                <img src="<?=base_url($settings['site_logo']);?>" alt="Current Logo" height="50" class="d-block">
                                                            </div>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input" type="checkbox" name="remove_logo" id="remove_logo" value="1">
                                                                <label class="form-check-label text-danger" for="remove_logo">
                                                                    <i class="ti ti-trash"></i> Remove current logo
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Favicon</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="site_favicon" name="site_favicon" accept="image/x-icon,image/png">
                                                        <label class="custom-file-label" for="site_favicon">Choose file</label>
                                                    </div>
                                                    <small class="form-text text-muted">ICO or PNG format. Recommended size: 32x32px. Max 1MB.</small>
                                                    <?php if(!empty($settings['site_favicon'])): ?>
                                                        <div class="mt-3">
                                                            <div class="border p-2 d-inline-block rounded">
                                                                <img src="<?=base_url($settings['site_favicon']);?>" alt="Current Favicon" height="32" width="32">
                                                            </div>
                                                            <div class="form-check mt-2">
                                                                <input class="form-check-input" type="checkbox" name="remove_favicon" id="remove_favicon" value="1">
                                                                <label class="form-check-label text-danger" for="remove_favicon">
                                                                    <i class="ti ti-trash"></i> Remove current favicon
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="primary_color">Primary Color</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="background-color: <?=old('primary_color', $settings['primary_color'] ?? '#4e73df');?>; width: 40px;" id="primary_color_preview"></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="primary_color" name="primary_color" 
                                                               value="<?=old('primary_color', $settings['primary_color'] ?? '#4e73df');?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="secondary_color">Secondary Color</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" style="background-color: <?=old('secondary_color', $settings['secondary_color'] ?? '#1cc88a');?>; width: 40px;" id="secondary_color_preview"></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="secondary_color" name="secondary_color" 
                                                               value="<?=old('secondary_color', $settings['secondary_color'] ?? '#1cc88a');?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Localization Tab -->
                                    <div class="tab-pane fade" id="localization" role="tabpanel" aria-labelledby="localization-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="default_language">Default Language</label>
                                                    <select class="form-control" id="default_language" name="default_language">
                                                        <option value="en" <?=(old('default_language', $settings['default_language'] ?? 'en') == 'en') ? 'selected' : '';?>>English</option>
                                                        <option value="es" <?=(old('default_language', $settings['default_language'] ?? 'en') == 'es') ? 'selected' : '';?>>Spanish</option>
                                                        <option value="fr" <?=(old('default_language', $settings['default_language'] ?? 'en') == 'fr') ? 'selected' : '';?>>French</option>
                                                        <option value="de" <?=(old('default_language', $settings['default_language'] ?? 'en') == 'de') ? 'selected' : '';?>>German</option>
                                                        <option value="pt" <?=(old('default_language', $settings['default_language'] ?? 'en') == 'pt') ? 'selected' : '';?>>Portuguese</option>
                                                        <option value="ar" <?=(old('default_language', $settings['default_language'] ?? 'en') == 'ar') ? 'selected' : '';?>>Arabic</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="currency">Default Currency</label>
                                                    <select class="form-control" id="currency" name="currency">
                                                        <option value="USD" <?=(old('currency', $settings['currency'] ?? 'USD') == 'USD') ? 'selected' : '';?>>USD - US Dollar ($)</option>
                                                        <option value="EUR" <?=(old('currency', $settings['currency'] ?? 'USD') == 'EUR') ? 'selected' : '';?>>EUR - Euro (€)</option>
                                                        <option value="GBP" <?=(old('currency', $settings['currency'] ?? 'USD') == 'GBP') ? 'selected' : '';?>>GBP - British Pound (£)</option>
                                                        <option value="JPY" <?=(old('currency', $settings['currency'] ?? 'USD') == 'JPY') ? 'selected' : '';?>>JPY - Japanese Yen (¥)</option>
                                                        <option value="CAD" <?=(old('currency', $settings['currency'] ?? 'USD') == 'CAD') ? 'selected' : '';?>>CAD - Canadian Dollar ($)</option>
                                                        <option value="AUD" <?=(old('currency', $settings['currency'] ?? 'USD') == 'AUD') ? 'selected' : '';?>>AUD - Australian Dollar ($)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="currency_symbol_position">Currency Symbol Position</label>
                                                    <select class="form-control" id="currency_symbol_position" name="currency_symbol_position">
                                                        <option value="left" <?=(old('currency_symbol_position', $settings['currency_symbol_position'] ?? 'left') == 'left') ? 'selected' : '';?>>Left ($100)</option>
                                                        <option value="right" <?=(old('currency_symbol_position', $settings['currency_symbol_position'] ?? 'left') == 'right') ? 'selected' : '';?>>Right (100$)</option>
                                                        <option value="left_space" <?=(old('currency_symbol_position', $settings['currency_symbol_position'] ?? 'left') == 'left_space') ? 'selected' : '';?>>Left with Space ($ 100)</option>
                                                        <option value="right_space" <?=(old('currency_symbol_position', $settings['currency_symbol_position'] ?? 'left') == 'right_space') ? 'selected' : '';?>>Right with Space (100 $)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="decimal_separator">Decimal Separator</label>
                                                    <select class="form-control" id="decimal_separator" name="decimal_separator">
                                                        <option value="." <?=(old('decimal_separator', $settings['decimal_separator'] ?? '.') == '.') ? 'selected' : '';?>>Period (.)</option>
                                                        <option value="," <?=(old('decimal_separator', $settings['decimal_separator'] ?? '.') == ',') ? 'selected' : '';?>>Comma (,)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email Tab -->
                                    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="admin_email">Admin Email Address</label>
                                                    <input type="email" class="form-control" id="admin_email" name="admin_email" 
                                                           placeholder="admin@example.com" 
                                                           value="<?=old('admin_email', $settings['admin_email'] ?? '');?>">
                                                    <small class="form-text text-muted">All system notifications will be sent to this email.</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email_from">Email From Address</label>
                                                    <input type="email" class="form-control" id="email_from" name="email_from" 
                                                           placeholder="noreply@example.com" 
                                                           value="<?=old('email_from', $settings['email_from'] ?? '');?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="email_from_name">Email From Name</label>
                                                    <input type="text" class="form-control" id="email_from_name" name="email_from_name" 
                                                           placeholder="The Blessed Manifest" 
                                                           value="<?=old('email_from_name', $settings['email_from_name'] ?? 'The Blessed Manifest');?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                                <h6>SMTP Configuration</h6>
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="use_smtp" name="use_smtp" value="1" 
                                                               <?=(old('use_smtp', $settings['use_smtp'] ?? false) == '1') ? 'checked' : '';?>>
                                                        <label class="custom-control-label" for="use_smtp">Use SMTP Server</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 smtp_field" style="<?=(old('use_smtp', $settings['use_smtp'] ?? false) == '1') ? '' : 'display: none;';?>">
                                                <div class="form-group">
                                                    <label for="smtp_host">SMTP Host</label>
                                                    <input type="text" class="form-control" id="smtp_host" name="smtp_host" 
                                                           placeholder="smtp.gmail.com" 
                                                           value="<?=old('smtp_host', $settings['smtp_host'] ?? '');?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 smtp_field" style="<?=(old('use_smtp', $settings['use_smtp'] ?? false) == '1') ? '' : 'display: none;';?>">
                                                <div class="form-group">
                                                    <label for="smtp_port">SMTP Port</label>
                                                    <input type="number" class="form-control" id="smtp_port" name="smtp_port" 
                                                           placeholder="587" 
                                                           value="<?=old('smtp_port', $settings['smtp_port'] ?? '587');?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 smtp_field" style="<?=(old('use_smtp', $settings['use_smtp'] ?? false) == '1') ? '' : 'display: none;';?>">
                                                <div class="form-group">
                                                    <label for="smtp_user">SMTP Username</label>
                                                    <input type="text" class="form-control" id="smtp_user" name="smtp_user" 
                                                           placeholder="user@example.com" 
                                                           value="<?=old('smtp_user', $settings['smtp_user'] ?? '');?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 smtp_field" style="<?=(old('use_smtp', $settings['use_smtp'] ?? false) == '1') ? '' : 'display: none;';?>">
                                                <div class="form-group">
                                                    <label for="smtp_pass">SMTP Password</label>
                                                    <input type="password" class="form-control" id="smtp_pass" name="smtp_pass" 
                                                           placeholder="••••••••">
                                                    <small class="form-text text-muted">Leave blank to keep current password.</small>
                                                </div>
                                            </div>
                                            <div class="col-md-6 smtp_field" style="<?=(old('use_smtp', $settings['use_smtp'] ?? false) == '1') ? '' : 'display: none;';?>">
                                                <div class="form-group">
                                                    <label for="smtp_encryption">SMTP Encryption</label>
                                                    <select class="form-control" id="smtp_encryption" name="smtp_encryption">
                                                        <option value="tls" <?=(old('smtp_encryption', $settings['smtp_encryption'] ?? 'tls') == 'tls') ? 'selected' : '';?>>TLS</option>
                                                        <option value="ssl" <?=(old('smtp_encryption', $settings['smtp_encryption'] ?? 'tls') == 'ssl') ? 'selected' : '';?>>SSL</option>
                                                        <option value="" <?=(old('smtp_encryption', $settings['smtp_encryption'] ?? 'tls') == '') ? 'selected' : '';?>>None</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary" id="saveSettingsBtn">
                                        <i class="ti ti-save"></i> Save All Settings
                                    </button>
                                    <button type="button" class="btn btn-secondary" id="resetSettingsBtn">
                                        <i class="ti ti-refresh"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$this->include('templates/admin/footer');?>
<script src="<?=base_url();?>assets/js/admin/settings.js"></script>