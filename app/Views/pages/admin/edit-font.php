<?=$this->include('templates/admin/header');?>

<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fas fa-edit"></i> Edit Font</h4>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Fonts
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Edit Font
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Font Form -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fas fa-info-circle"></i> Font Information</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="fontForm">
                                <input type="hidden" name="font_id" id="fontId" value="<?= $font['font_id'] ?>">
                                
                                <div class="row">
                                    <!-- Main Content Area -->
                                    <div class="col-lg-8">
                                        <div class="card mb-4">
                                            <div class="card-header bg-white">
                                                <h5 class="card-title mb-0"><i class="fas fa-info-circle mr-2"></i>Font Details</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Font Name -->
                                                <div class="form-group">
                                                    <label for="fontName">Font Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="font_name" id="fontName" class="form-control" value="<?= esc($font['font_name']) ?>" placeholder="e.g., Montserrat, Open Sans, Playfair Display" required>
                                                    <small class="form-text text-muted">The display name of the font.</small>
                                                </div>

                                                <!-- Source Type -->
                                                <div class="form-group">
                                                    <label for="sourceType">Source Type <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="source_type" id="sourceType" required>
                                                        <option value="">-- Select Source Type --</option>
                                                        <option value="local" <?= $font['source_type'] == 'local' ? 'selected' : '' ?>>Local Upload (File Upload)</option>
                                                        <option value="external" <?= $font['source_type'] == 'external' ? 'selected' : '' ?>>External Link (Google Fonts, CDN, etc.)</option>
                                                    </select>
                                                    <small class="form-text text-muted">Choose whether to upload a font file or use an external link.</small>
                                                </div>

                                                <!-- File Upload Section (shows when source_type = local) -->
                                                <div class="form-group" id="fileUploadSection" style="display: <?= $font['source_type'] == 'local' ? 'block' : 'none' ?>;">
                                                    <label for="fontFile">Font File</label>
                                                    
                                                    <!-- Existing File Display -->
                                                    <?php if ($font['source_type'] == 'local' && $font['file_path']): ?>
                                                    <div class="existing-file mb-2">
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-file-font"></i> Current file: 
                                                            <strong><?= basename($font['file_path']) ?></strong>
                                                            <button type="button" class="btn btn-sm btn-link text-danger remove-existing-file float-right" data-path="<?= $font['file_path'] ?>">
                                                                <i class="fas fa-trash"></i> Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="fontFile" name="font_file" accept=".ttf,.otf,.woff,.woff2,.eot">
                                                        <label class="custom-file-label" for="fontFile">Choose new file (leave empty to keep current)</label>
                                                    </div>
                                                    <small class="form-text text-muted">Upload new font file (TTF, OTF, WOFF, WOFF2, EOT). Max 10MB. Leave empty to keep current file.</small>
                                                    <div id="fontFilePreview" class="mt-2" style="display: none;">
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-file-font"></i> <span id="fileName"></span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="remove_file" id="removeFile" value="0">
                                                </div>

                                                <!-- External Link Section (shows when source_type = external) -->
                                                <div class="form-group" id="externalLinkSection" style="display: <?= $font['source_type'] == 'external' ? 'block' : 'none' ?>;">
                                                    <label for="fontLink">Font Link / URL <span class="text-danger">*</span></label>
                                                    <input type="url" name="font_link" id="fontLink" class="form-control" value="<?= esc($font['font_link']) ?>" placeholder="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
                                                    <small class="form-text text-muted">Google Fonts embed URL or direct font CSS link.</small>
                                                    
                                                    <!-- Preview for Google Fonts -->
                                                    <div id="googleFontPreview" class="mt-2" style="display: none;">
                                                        <div class="alert alert-success">
                                                            <i class="fab fa-google"></i> Google Font loaded successfully!
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Live Preview Box -->
                                                <div class="form-group mt-4">
                                                    <label>Live Preview</label>
                                                    <div class="preview-box p-3 border rounded bg-light">
                                                        <div class="form-group">
                                                            <label class="small">Preview Text</label>
                                                            <input type="text" id="previewText" class="form-control form-control-sm" value="The quick brown fox jumps over the lazy dog">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small">Font Size</label>
                                                            <input type="range" id="previewSize" class="form-control-range" min="12" max="48" value="24">
                                                        </div>
                                                        <div id="fontPreview" style="font-size: 24px; text-align: center; min-height: 80px; font-family: '<?= esc($font['font_name']) ?>', sans-serif;">
                                                            The quick brown fox jumps over the lazy dog
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
                                                <h5 class="card-title mb-0"><i class="fas fa-cog"></i> Settings</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Status -->
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="active" <?= $font['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                                        <option value="inactive" <?= $font['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                                    </select>
                                                    <small class="form-text text-muted">Inactive fonts won't be visible to customers.</small>
                                                </div>

                                                <!-- Is Featured -->
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="isFeatured" name="is_featured" value="1" <?= $font['is_featured'] == 1 ? 'checked' : '' ?>>
                                                        <label class="custom-control-label" for="isFeatured">Feature this font</label>
                                                    </div>
                                                    <small class="form-text text-muted">Featured fonts appear on the homepage.</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <button type="button" class="btn btn-primary btn-block" id="submitFontBtn">
                                                    <i class="fas fa-save"></i> Update Font
                                                </button>
                                                <a href="/admin/font-masterlist" class="btn btn-secondary btn-block mt-2">
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
            </div>
        </div>
    </div>
</div>

<?=$this->include('templates/admin/footer');?>

<!-- Additional CSS -->
<style>
    .preview-box {
        transition: all 0.3s ease;
    }
    .custom-file-label::after {
        content: "Browse";
    }
    .form-control-range {
        width: 100%;
    }
    select.form-control {
        border-radius: 8px;
    }
    .card-header .card-title {
        font-size: 1rem;
        font-weight: 600;
    }
    .existing-file {
        position: relative;
    }
    .remove-existing-file {
        font-size: 12px;
    }
</style>

<script src="<?= base_url(); ?>assets/js/admin/edit-font.js"></script>