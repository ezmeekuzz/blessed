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
                            <h4><i class="fa fa-edit"></i> Add New Blog</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-0">
                                <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="ti ti-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Blog</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Display Errors -->
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- Blog Form -->
            <form id="addblog" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row">
                    <!-- Main Content Area -->
                    <div class="col-lg-9">
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="ti ti-pin2 mr-2"></i>Blog Details</h5>
                            </div>
                            <div class="card-body">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter blog title" value="<?= old('title') ?>" required>
                                    <small class="form-text text-muted">The title of your blog post.</small>
                                </div>

                                <!-- Slug (Auto-generated) -->
                                <div class="form-group">
                                    <label for="slug">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="auto-generated-from-title" value="<?= old('slug') ?>" readonly>
                                    <small class="form-text text-muted">URL-friendly version of the title. Auto-generated.</small>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" placeholder="Enter a short description" rows="3"><?= old('description') ?></textarea>
                                    <small class="form-text text-muted">A brief summary of the blog post (meta description).</small>
                                </div>

                                <!-- Content (WYSIWYG) -->
                                <div class="form-group">
                                    <label for="content">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="content" id="content" placeholder="Write your blog content here..." rows="8" required><?= old('content') ?></textarea>
                                    <small class="form-text text-muted">The main content of your blog post.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="col-lg-3">
                        <!-- Publish Settings Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fa fa-cloud-upload"></i> Publish</h5>
                            </div>
                            <div class="card-body">
                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Draft</option>
                                        <option value="published" <?= old('status') == 'published' ? 'selected' : '' ?>>Published</option>
                                    </select>
                                </div>

                                <!-- Published Date -->
                                <div class="form-group">
                                    <label for="published_at">Publish Date</label>
                                    <input type="datetime-local" class="form-control" name="published_at" id="published_at" value="<?= old('published_at', date('Y-m-d\TH:i')) ?>">
                                    <small class="form-text text-muted">Schedule when to publish this post.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Category Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="ti ti-tag mr-2"></i>Category</h5>
                            </div>
                            <div class="card-body">
                                <!-- Search Category -->
                                <div class="form-group">
                                    <label for="searchcategory">Search Category</label>
                                    <input type="text" class="form-control" id="searchcategory" placeholder="Type to filter categories...">
                                </div>

                                <!-- Category List (Single Select) -->
                                <div class="form-group">
                                    <label for="blog_category_id">Select Category <span class="text-danger">*</span></label>
                                    <div class="category-list-wrapper border rounded p-2" style="max-height: 250px; overflow-y: auto;">
                                        <ul class="list-group list-group-flush" id="categorylist">
                                            <li class="list-group-item text-muted">Loading categories...</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="blog_category_id" id="blog_category_id" value="<?= old('blog_category_id') ?>" required>
                                    <small class="form-text text-muted">Select one category for this blog post.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Media Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fa fa-image"></i> Featured Image</h5>
                            </div>
                            <div class="card-body">
                                <!-- Blog Image Upload -->
                                <div class="form-group">
                                    <label for="featured_image">Featured Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="featured_image" name="featured_image" accept="image/png, image/gif, image/jpeg, image/webp">
                                        <label class="custom-file-label" for="featured_image">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">Recommended size: 1200x630px. Max 2MB.</small>
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img src="" class="img-fluid rounded" alt="Preview">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tags Card -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0"><i class="fa fa-tags"></i> Tags</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" class="form-control" id="tags" name="tags" 
                                        data-role="tagsinputCustom" 
                                        data-placeholder="" >
                                    <small class="form-text text-muted">Type a tag and press Enter to add.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-save"></i> Publish Blog
                                </button>
                                <a href="/admin/add-blog" class="btn btn-secondary btn-block mt-2">
                                    <i class="fa fa-arrow-left"></i> Cancel
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
<script src="<?=base_url();?>assets/js/admin/add-blog.js"></script>