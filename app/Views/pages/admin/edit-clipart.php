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
                            <h4><i class="fas fa-paint-brush"></i> Edit Clip Art</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-0">
                                <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="ti ti-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="/admin/clipart-masterlist">Clip Arts</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Clip Art</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Clip Art Form -->
            <form id="editClipArtForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="clip_art_id" id="clipArtId" value="<?= $clipArt['clip_art_id'] ?>">
                <div class="row">
                    <!-- Main Content Area -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-info-circle mr-2"></i>Clip Art Details</h5>
                            </div>
                            <div class="card-body">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" value="<?= esc($clipArt['title']) ?>" required>
                                    <small class="form-text text-muted">A descriptive title for this clip art.</small>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="3"><?= esc($clipArt['description']) ?></textarea>
                                    <small class="form-text text-muted">Brief description of the clip art (optional).</small>
                                </div>

                                <!-- Tags -->
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" class="form-control" id="tags" name="tags" value="<?= esc($clipArt['tags']) ?>" placeholder="e.g., flower, nature, abstract, vintage">
                                    <small class="form-text text-muted">Comma-separated tags to help with search and filtering.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="col-lg-4">
                        <!-- Image Source Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-image"></i> Image Source</h5>
                            </div>
                            <div class="card-body">
                                <!-- Source Type Selection - Toggle Buttons -->
                                <div class="form-group">
                                    <label class="d-block">Select Image Source <span class="text-danger">*</span></label>
                                    <div class="btn-group w-100" role="group">
                                        <button type="button" class="btn btn-outline-primary source-type-btn <?= strpos($clipArt['image_url'], 'http') === 0 ? '' : 'active' ?>" data-source="local">
                                            <i class="fas fa-upload"></i> Upload File
                                        </button>
                                        <button type="button" class="btn btn-outline-primary source-type-btn <?= strpos($clipArt['image_url'], 'http') === 0 ? 'active' : '' ?>" data-source="external">
                                            <i class="fas fa-link"></i> External URL
                                        </button>
                                    </div>
                                    <input type="hidden" name="source_type" id="sourceType" value="<?= strpos($clipArt['image_url'], 'http') === 0 ? 'external' : 'local' ?>">
                                </div>

                                <!-- Current Image Display -->
                                <?php 
                                $isExternal = strpos($clipArt['image_url'], 'http') === 0;
                                $displayImageUrl = $isExternal ? $clipArt['image_url'] : base_url($clipArt['image_url']);
                                ?>
                                <div class="form-group text-center mb-3">
                                    <label>Current Image</label>
                                    <div class="current-image-container">
                                        <img src="<?= $displayImageUrl ?>" class="img-fluid rounded border p-2" style="max-height: 150px; width: auto;" alt="Current image" onerror="this.src='<?= base_url('assets/images/no-image.png') ?>'">
                                    </div>
                                </div>

                                <!-- LOCAL UPLOAD SECTION -->
                                <div id="localUploadSection" class="source-section" style="<?= $isExternal ? 'display: none;' : '' ?>">
                                    <div class="form-group">
                                        <label for="clipartImage">Upload New Image (Optional)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="clipartImage" name="clipart_image" accept="image/png, image/gif, image/jpeg, image/webp, image/svg+xml">
                                            <label class="custom-file-label" for="clipartImage">Choose file</label>
                                        </div>
                                        <small class="form-text text-muted">Leave empty to keep current image. Supported formats: JPG, PNG, GIF, WEBP, SVG. Max 5MB.</small>
                                        
                                        <!-- Local Image Preview -->
                                        <div id="localImagePreview" class="mt-3 text-center" style="display: none;">
                                            <div class="border rounded p-2 bg-light">
                                                <img src="" class="img-fluid" style="max-height: 150px;" alt="Preview">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeLocalPreviewBtn">
                                                        <i class="fas fa-trash"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- EXTERNAL URL SECTION -->
                                <div id="externalUrlSection" class="source-section" style="<?= $isExternal ? '' : 'display: none;' ?>">
                                    <div class="form-group">
                                        <label for="imageUrl">Image URL <span class="text-danger">*</span></label>
                                        <input type="url" name="image_url" id="imageUrl" class="form-control" value="<?= $isExternal ? esc($clipArt['image_url']) : '' ?>" placeholder="https://example.com/images/clipart.png">
                                        <small class="form-text text-muted">Enter the full URL of the image (must start with http:// or https://).</small>
                                        
                                        <!-- External Image Preview -->
                                        <div id="externalImagePreview" class="mt-3 text-center" style="<?= $isExternal ? '' : 'display: none;' ?>">
                                            <div class="border rounded p-2 bg-light">
                                                <img src="<?= $isExternal ? esc($clipArt['image_url']) : '' ?>" class="img-fluid" style="max-height: 150px;" alt="Preview">
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger" id="removeExternalPreviewBtn">
                                                        <i class="fas fa-trash"></i> Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fas fa-cog"></i> Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="active" <?= $clipArt['is_active'] == 1 ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= $clipArt['is_active'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                    <small class="form-text text-muted">Inactive clip arts won't be visible to customers.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                                    <i class="fas fa-save"></i> Update Clip Art
                                </button>
                                <a href="/admin/clipart-masterlist" class="btn btn-outline-secondary btn-block mt-2">
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
    .custom-file-label::after {
        content: "Browse";
    }
    .card-header .card-title {
        font-size: 1rem;
        font-weight: 600;
    }
    .source-section {
        transition: all 0.3s ease;
    }
    .btn-group .btn.active {
        background-color: #3D204E;
        border-color: #3D204E;
        color: white;
    }
    .btn-group .btn {
        transition: all 0.2s ease;
    }
    #localImagePreview img, #externalImagePreview img {
        max-height: 150px;
        object-fit: contain;
    }
    .current-image-container {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
    }
</style>

<script src="<?= base_url(); ?>assets/js/admin/edit-clipart.js"></script>