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
                            <h4><i class="fa fa-edit"></i> Edit Blog Post</h4>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-transparent p-0 mb-0">
                                <li class="breadcrumb-item"><a href="/admin/dashboard"><i class="ti ti-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="/admin/blogmasterlist">Blog Masterlist</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Blog</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Blog Form -->
            <form id="editBlogForm" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="blog_id" id="blog_id" value="<?= $blog['blog_post_id'] ?>">
                
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
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter blog title" value="<?= old('title', $blog['title']) ?>" required>
                                    <small class="form-text text-muted">The title of your blog post.</small>
                                </div>

                                <!-- Slug (Auto-generated) -->
                                <div class="form-group">
                                    <label for="slug">Slug <span class="text-danger">*</span></label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="URL-friendly title" value="<?= old('slug', $blog['slug']) ?>" required>
                                    <small class="form-text text-muted">URL-friendly version of the title.</small>
                                    <div id="slugError" class="text-danger small mt-1" style="display: none;">Slug already exists. Please use a different slug.</div>
                                </div>

                                <!-- Description (Meta Description for SEO) -->
                                <div class="form-group">
                                    <label for="description">Meta Description <span class="text-muted">(SEO)</span></label>
                                    <textarea class="form-control" name="description" id="description" placeholder="Enter meta description for SEO (150-160 characters recommended)" rows="2"><?= old('description', $blog['description']) ?></textarea>
                                    <small class="form-text text-muted">Brief description for search engines. This serves as your meta description.</small>
                                    <div class="character-count small text-muted mt-1"><span id="descCount"><?= strlen($blog['description'] ?? '') ?></span>/160 characters</div>
                                </div>

                                <!-- Excerpt -->
                                <div class="form-group">
                                    <label for="excerpt">Excerpt <span class="text-muted">(Short Summary)</span></label>
                                    <textarea class="form-control" name="excerpt" id="excerpt" placeholder="Short summary displayed on blog listing pages" rows="2"><?= old('excerpt', $blog['excerpt']) ?></textarea>
                                    <small class="form-text text-muted">Short summary displayed on blog listing pages. If empty, will use meta description.</small>
                                </div>

                                <!-- Meta Keywords -->
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords <span class="text-muted">(SEO)</span></label>
                                    <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" placeholder="keyword1, keyword2, keyword3" value="<?= old('meta_keywords', $blog['meta_keywords']) ?>">
                                    <small class="form-text text-muted">Comma-separated keywords for SEO.</small>
                                </div>

                                <!-- Content (WYSIWYG) -->
                                <div class="form-group">
                                    <label for="content">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="content" id="content" placeholder="Write your blog content here..." rows="8" required><?= old('content', $blog['content']) ?></textarea>
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
                                        <option value="draft" <?= ($blog['status'] == 'draft') ? 'selected' : '' ?>>Draft</option>
                                        <option value="published" <?= ($blog['status'] == 'published') ? 'selected' : '' ?>>Published</option>
                                    </select>
                                </div>

                                <!-- Published Date -->
                                <div class="form-group">
                                    <label for="published_at">Publish Date</label>
                                    <input type="datetime-local" class="form-control" name="published_at" id="published_at" value="<?= $blog['published_at'] ? date('Y-m-d\TH:i', strtotime($blog['published_at'])) : '' ?>">
                                    <small class="form-text text-muted">Schedule when to publish this post.</small>
                                </div>

                                <!-- Featured Post -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" <?= ($blog['is_featured'] ?? 0) ? 'checked' : '' ?>>
                                        <label class="custom-control-label" for="is_featured">Feature this post</label>
                                    </div>
                                    <small class="form-text text-muted">Featured posts appear prominently on the blog page.</small>
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
                                    <input type="hidden" name="blog_category_id" id="blog_category_id" value="<?= old('blog_category_id', $blog['blog_category_id']) ?>" required>
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
                                <div class="form-group">
                                    <label for="featured_image">Change Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="featured_image" name="featured_image" accept="image/png, image/gif, image/jpeg, image/webp">
                                        <label class="custom-file-label" for="featured_image">Choose file</label>
                                    </div>
                                    <small class="form-text text-muted">Leave empty to keep current image. Max 2MB. Supported: JPG, PNG, GIF, WEBP.</small>
                                    <div id="imagePreview" class="mt-2">
                                        <?php if($blog['featured_image']): ?>
                                            <img src="<?= base_url($blog['featured_image']) ?>" class="img-fluid rounded" alt="Current Image" style="max-height: 150px;">
                                        <?php endif; ?>
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
                                        data-role="tagsinput" 
                                        data-placeholder=""
                                        value="<?= old('tags', $blog['tags']) ?>">
                                    <small class="form-text text-muted">Type a tag and press Enter to add. Separate multiple tags with commas.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                                    <i class="fa fa-save"></i> Update Blog
                                </button>
                                <a href="/admin/blogmasterlist" class="btn btn-secondary btn-block mt-2">
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
<script src="<?=base_url();?>assets/js/admin/edit-blog.js"></script>