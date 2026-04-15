<?=$this->include('templates/admin/header');?>
<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h4><i class="fas fa-edit"></i> Edit Product</h4>
                        </div>
                        <div class="ml-auto d-flex align-items-center">
                            <nav>
                                <ol class="breadcrumb p-0 m-b-0">
                                    <li class="breadcrumb-item">
                                        <a href="/"><i class="ti ti-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        Products
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Edit Product
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Form -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fas fa-info-circle"></i> Product Information</h4>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-secondary mr-2" id="resetFormBtn">
                                    <i class="fas fa-undo-alt"></i> Reset
                                </button>
                                <button type="button" class="btn btn-primary" id="submitProductBtn">
                                    <i class="fas fa-save"></i> Update Product
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="productForm">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                
                                <!-- Basic Information Row -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="productName">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="productName" name="product_name" value="<?= esc($product['product_name']) ?>" placeholder="Enter product name">
                                            <small class="form-text text-muted">This will be used to generate the product slug.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="productSlug">Slug (URL)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">/product/</span>
                                                </div>
                                                <input type="text" class="form-control" id="productSlug" name="slug" value="<?= esc($product['slug']) ?>" placeholder="auto-generated">
                                            </div>
                                            <small class="form-text text-muted">Leave empty to auto-generate from product name.</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Category <span class="text-danger">*</span></label>
                                            <select class="form-control" id="productCategory" name="product_category_id">
                                                <option value="">-- Select Category --</option>
                                                <?php if (!empty($categories)): ?>
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?= $category['product_category_id'] ?>" <?= ($product['product_category_id'] == $category['product_category_id']) ? 'selected' : '' ?>>
                                                            <?= esc($category['categoryname']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="productTags">Tags (comma separated)</label>
                                            <input type="text" class="form-control" id="productTags" name="tags" value="<?= esc($product['tags']) ?>" placeholder="e.g., new, sale, bestseller">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="productDescription">Description</label>
                                            <textarea class="form-control" id="productDescription" name="description" rows="4" placeholder="Enter product description"><?= esc($product['description']) ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Images Section -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0"><i class="fas fa-images"></i> Product Images</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Existing Images -->
                                                <?php if (!empty($images)): ?>
                                                <div class="mb-3">
                                                    <label class="font-weight-bold">Existing Images</label>
                                                    <div class="existing-images-container" id="existingImagesContainer">
                                                        <div class="row">
                                                            <?php foreach ($images as $image): ?>
                                                            <div class="col-md-2 mb-2 existing-image-item" data-image-id="<?= $image['product_image_id'] ?>">
                                                                <div class="position-relative">
                                                                    <img src="<?= base_url($image['file_path']) ?>" class="img-thumbnail" style="width: 100%; height: 120px; object-fit: cover;">
                                                                    <button type="button" class="btn btn-sm btn-danger remove-existing-image" data-image-id="<?= $image['product_image_id'] ?>" style="position: absolute; top: 5px; right: 5px;">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endif; ?>
                                                
                                                <!-- Upload New Images -->
                                                <div class="upload-area" id="productImageUploadArea">
                                                    <h2><i class="fas fa-cloud-upload-alt"></i> Drag & Drop Images</h2>
                                                    <p>or</p>
                                                    <button type="button" id="productImageSelectBtn" class="btn btn-outline-primary">Select Files</button>
                                                    <div id="productImageList" class="product-image-list"></div>
                                                </div>
                                                <input type="hidden" name="product_images" id="productImages">
                                                <input type="hidden" name="deleted_images" id="deletedImages">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sizes & Colors Section -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0"><i class="fas fa-tags"></i> Sizes & Pricing</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm" id="sizesTable">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>Size</th>
                                                                <th>Unit</th>
                                                                <th>Price ($)</th>
                                                                <th>Discount</th>
                                                                <th>Discount Type</th>
                                                                <th>Default</th>
                                                                <th style="width: 40px"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="sizesTableBody">
                                                            <?php if (!empty($sizes)): ?>
                                                                <?php foreach ($sizes as $index => $size): ?>
                                                                <tr class="size-row" data-size-idx="<?= $index ?>">
                                                                    <input type="hidden" name="sizes[<?= $index ?>][size_id]" value="<?= $size['size_id'] ?>">
                                                                    <td><input type="text" class="form-control form-control-sm size-name" name="sizes[<?= $index ?>][size]" value="<?= esc($size['size']) ?>" placeholder="e.g., Small"></td>
                                                                    <td><input type="text" class="form-control form-control-sm size-unit" name="sizes[<?= $index ?>][unit]" value="<?= esc($size['unit_of_measure']) ?>" placeholder="unit"></td>
                                                                    <td><input type="number" step="0.01" class="form-control form-control-sm size-price" name="sizes[<?= $index ?>][price]" value="<?= $size['price'] ?>" placeholder="0.00"></td>
                                                                    <td><input type="number" step="0.01" class="form-control form-control-sm size-discount" name="sizes[<?= $index ?>][discount]" value="<?= $size['discount_percentage'] ?: $size['discount_amount'] ?>" placeholder="0"></td>
                                                                    <td>
                                                                        <select class="form-control form-control-sm size-discount-type" name="sizes[<?= $index ?>][discount_type]">
                                                                            <option value="percentage" <?= ($size['discount_type'] == 'percentage') ? 'selected' : '' ?>>Percentage (%)</option>
                                                                            <option value="fixed" <?= ($size['discount_type'] == 'fixed') ? 'selected' : '' ?>>Fixed ($)</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-center"><input type="radio" name="default_size" value="<?= $index ?>" class="default-size-radio" <?= $size['is_default'] ? 'checked' : '' ?>></td>
                                                                    <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-size-btn"><i class="fas fa-trash"></i></button></td>
                                                                </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr class="size-row" data-size-idx="0">
                                                                    <td><input type="text" class="form-control form-control-sm size-name" name="sizes[0][size]" placeholder="e.g., Small"></td>
                                                                    <td><input type="text" class="form-control form-control-sm size-unit" name="sizes[0][unit]" placeholder="unit"></td>
                                                                    <td><input type="number" step="0.01" class="form-control form-control-sm size-price" name="sizes[0][price]" placeholder="0.00"></td>
                                                                    <td><input type="number" step="0.01" class="form-control form-control-sm size-discount" name="sizes[0][discount]" placeholder="0"></td>
                                                                    <td>
                                                                        <select class="form-control form-control-sm size-discount-type" name="sizes[0][discount_type]">
                                                                            <option value="percentage">Percentage (%)</option>
                                                                            <option value="fixed">Fixed ($)</option>
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-center"><input type="radio" name="default_size" value="0" class="default-size-radio" checked></td>
                                                                    <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-size-btn" disabled><i class="fas fa-trash"></i></button></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="7">
                                                                    <button type="button" class="btn btn-sm btn-outline-primary" id="addSizeBtn">
                                                                        <i class="fas fa-plus"></i> Add Size
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0"><i class="fas fa-palette"></i> Colors & Variants</h5>
                                            </div>
                                            <div class="card-body" style="max-height: 450px; overflow-y: auto;">
                                                <div id="colorsContainer">
                                                    <?php if (!empty($colors)): ?>
                                                        <?php foreach ($colors as $index => $color): ?>
                                                        <div class="color-card card mb-3" data-color-idx="<?= $index ?>" data-color-id="<?= $color['color_id'] ?>">
                                                            <div class="card-body p-3">
                                                                <input type="hidden" name="colors[<?= $index ?>][color_id]" value="<?= $color['color_id'] ?>">
                                                                <input type="hidden" name="colors[<?= $index ?>][existing_front_image]" value="<?= $color['front_image'] ?>">
                                                                <input type="hidden" name="colors[<?= $index ?>][existing_back_image]" value="<?= $color['back_image'] ?>">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group mb-2">
                                                                            <label class="small">Color</label>
                                                                            <div class="d-flex align-items-center">
                                                                                <input type="color" class="form-control color-hex-picker" name="colors[<?= $index ?>][hex]" value="<?= $color['color_hex'] ?>" style="width: 50px; height: 35px;">
                                                                                <input type="text" class="form-control form-control-sm ml-2 color-hex-text" name="colors[<?= $index ?>][hex_text]" placeholder="#000000" value="<?= $color['color_hex'] ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <div class="form-group mb-2">
                                                                            <label class="small">Default Color?</label>
                                                                            <div class="d-flex align-items-center" style="margin-top: 8px;">
                                                                                <input type="radio" name="default_color" value="<?= $index ?>" class="default-color-radio mr-2" <?= $color['is_default'] ? 'checked' : '' ?>>
                                                                                <span>Set as default color</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="small">Front Image</label>
                                                                            <?php if ($color['front_image']): ?>
                                                                            <div class="existing-image-preview mb-2">
                                                                                <img src="<?= base_url($color['front_image']) ?>" class="img-thumbnail" style="max-height: 60px;">
                                                                                <button type="button" class="btn btn-sm btn-link text-danger remove-existing-color-image" data-type="front">Remove</button>
                                                                            </div>
                                                                            <?php endif; ?>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input color-image-input" accept="image/*" data-target="front" data-color-idx="<?= $index ?>">
                                                                                <label class="custom-file-label">Choose new file</label>
                                                                            </div>
                                                                            <div class="image-preview-thumb front-preview mt-1" style="display: none;">
                                                                                <img src="" class="img-thumbnail" style="max-height: 40px;">
                                                                                <button type="button" class="btn btn-sm btn-link p-0 remove-image-preview" data-type="front">Remove</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="small">Back Image</label>
                                                                            <?php if ($color['back_image']): ?>
                                                                            <div class="existing-image-preview mb-2">
                                                                                <img src="<?= base_url($color['back_image']) ?>" class="img-thumbnail" style="max-height: 60px;">
                                                                                <button type="button" class="btn btn-sm btn-link text-danger remove-existing-color-image" data-type="back">Remove</button>
                                                                            </div>
                                                                            <?php endif; ?>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input color-image-input" accept="image/*" data-target="back" data-color-idx="<?= $index ?>">
                                                                                <label class="custom-file-label">Choose new file</label>
                                                                            </div>
                                                                            <div class="image-preview-thumb back-preview mt-1" style="display: none;">
                                                                                <img src="" class="img-thumbnail" style="max-height: 40px;">
                                                                                <button type="button" class="btn btn-sm btn-link p-0 remove-image-preview" data-type="back">Remove</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-md-12 text-right">
                                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-color-btn">
                                                                            <i class="fas fa-trash"></i> Remove Color
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <div class="color-card card mb-3" data-color-idx="0">
                                                            <div class="card-body p-3">
                                                                <div class="row">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group mb-2">
                                                                            <label class="small">Color</label>
                                                                            <div class="d-flex align-items-center">
                                                                                <input type="color" class="form-control color-hex-picker" name="colors[0][hex]" value="#3498db" style="width: 50px; height: 35px;">
                                                                                <input type="text" class="form-control form-control-sm ml-2 color-hex-text" name="colors[0][hex_text]" placeholder="#000000" value="#3498db">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-7">
                                                                        <div class="form-group mb-2">
                                                                            <label class="small">Default Color?</label>
                                                                            <div class="d-flex align-items-center" style="margin-top: 8px;">
                                                                                <input type="radio" name="default_color" value="0" class="default-color-radio mr-2" checked>
                                                                                <span>Set as default color</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="small">Front Image</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input color-image-input" accept="image/*" data-target="front" data-color-idx="0">
                                                                                <label class="custom-file-label">Choose file</label>
                                                                            </div>
                                                                            <div class="image-preview-thumb front-preview mt-1" style="display: none;">
                                                                                <img src="" class="img-thumbnail" style="max-height: 40px;">
                                                                                <button type="button" class="btn btn-sm btn-link p-0 remove-image-preview" data-type="front">Remove</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group mb-2">
                                                                            <label class="small">Back Image</label>
                                                                            <div class="custom-file">
                                                                                <input type="file" class="custom-file-input color-image-input" accept="image/*" data-target="back" data-color-idx="0">
                                                                                <label class="custom-file-label">Choose file</label>
                                                                            </div>
                                                                            <div class="image-preview-thumb back-preview mt-1" style="display: none;">
                                                                                <img src="" class="img-thumbnail" style="max-height: 40px;">
                                                                                <button type="button" class="btn btn-sm btn-link p-0 remove-image-preview" data-type="back">Remove</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row mt-2">
                                                                    <div class="col-md-12 text-right">
                                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-color-btn" disabled>
                                                                            <i class="fas fa-trash"></i> Remove Color
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary w-100 mt-2" id="addColorBtn">
                                                    <i class="fas fa-plus"></i> Add Color
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Options -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0"><i class="fas fa-cogs"></i> Additional Options</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="isFeatured" name="is_featured" <?= $product['is_featured'] ? 'checked' : '' ?>>
                                                            <label class="custom-control-label" for="isFeatured">Feature this product (show on homepage)</label>
                                                        </div>
                                                    </div>
                                                </div>
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

<!-- Hidden template for new size row -->
<template id="sizeRowTemplate">
    <tr class="size-row" data-size-idx="__index__">
        <td><input type="text" class="form-control form-control-sm size-name" name="sizes[__index__][size]" placeholder="e.g., Large"></td>
        <td><input type="text" class="form-control form-control-sm size-unit" name="sizes[__index__][unit]" placeholder="unit"></td>
        <td><input type="number" step="0.01" class="form-control form-control-sm size-price" name="sizes[__index__][price]" placeholder="0.00"></td>
        <td><input type="number" step="0.01" class="form-control form-control-sm size-discount" name="sizes[__index__][discount]" placeholder="0"></td>
        <td>
            <select class="form-control form-control-sm size-discount-type" name="sizes[__index__][discount_type]">
                <option value="percentage">Percentage (%)</option>
                <option value="fixed">Fixed ($)</option>
            </select>
        </td>
        <td class="text-center"><input type="radio" name="default_size" value="__index__" class="default-size-radio"></td>
        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-size-btn"><i class="fas fa-trash"></i></button></td>
    </tr>
</template>

<!-- Hidden template for new color card -->
<template id="colorCardTemplate">
    <div class="color-card card mb-3" data-color-idx="__index__">
        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group mb-2">
                        <label class="small">Color</label>
                        <div class="d-flex align-items-center">
                            <input type="color" class="form-control color-hex-picker" name="colors[__index__][hex]" value="#e74c3c" style="width: 50px; height: 35px;">
                            <input type="text" class="form-control form-control-sm ml-2 color-hex-text" name="colors[__index__][hex_text]" placeholder="#000000" value="#e74c3c">
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group mb-2">
                        <label class="small">Default Color?</label>
                        <div class="d-flex align-items-center" style="margin-top: 8px;">
                            <input type="radio" name="default_color" value="__index__" class="default-color-radio mr-2">
                            <span>Set as default color</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="small">Front Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input color-image-input" accept="image/*" data-target="front" data-color-idx="__index__">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="image-preview-thumb front-preview mt-1" style="display: none;">
                            <img src="" class="img-thumbnail" style="max-height: 40px;">
                            <button type="button" class="btn btn-sm btn-link p-0 remove-image-preview" data-type="front">Remove</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-2">
                        <label class="small">Back Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input color-image-input" accept="image/*" data-target="back" data-color-idx="__index__">
                            <label class="custom-file-label">Choose file</label>
                        </div>
                        <div class="image-preview-thumb back-preview mt-1" style="display: none;">
                            <img src="" class="img-thumbnail" style="max-height: 40px;">
                            <button type="button" class="btn btn-sm btn-link p-0 remove-image-preview" data-type="back">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-color-btn">
                        <i class="fas fa-trash"></i> Remove Color
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<?=$this->include('templates/admin/footer');?>

<!-- Additional CSS -->
<style>
    .upload-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        background: #fafafa;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-area:hover {
        background-color: #f0f0f0;
        border-color: #007bff;
    }
    .upload-area.drag-over {
        background-color: #e3f2fd;
        border-color: #007bff;
    }
    .upload-area h2 {
        font-size: 1.5rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    .upload-area h2 i {
        font-size: 3rem;
        display: block;
        margin-bottom: 15px;
    }
    .product-image-list {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 20px;
        padding: 10px;
    }
    .image-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #ddd;
        background: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.2s ease;
    }
    .image-wrapper:hover {
        border-color: #007bff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .delete-btn-preview {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #dc3545;
        color: white;
        text-align: center;
        line-height: 26px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .color-card {
        transition: all 0.2s;
        border-left: 3px solid #ddd;
    }
    .color-card.selected-default {
        border-left-color: #28a745;
        background-color: #f8fff8;
    }
    .existing-image-item {
        position: relative;
    }
    .remove-existing-image {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .existing-image-preview {
        position: relative;
        display: inline-block;
    }
    .remove-existing-color-image {
        position: absolute;
        top: 0;
        right: 0;
        background: rgba(255,255,255,0.9);
        padding: 2px 5px;
        font-size: 12px;
    }
</style>

<script src="<?= base_url('assets/js/admin/edit-product.js') ?>"></script>