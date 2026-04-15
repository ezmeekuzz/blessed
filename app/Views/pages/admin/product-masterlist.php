<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for table layout to prevent overlapping */
    #productmasterlist {
        width: 100%;
        table-layout: auto !important;
    }
    
    /* Ensure table cells don't overflow */
    #productmasterlist td,
    #productmasterlist th {
        word-break: break-word;
        vertical-align: middle;
        white-space: normal !important;
    }
    
    /* Column widths - adjust percentages as needed */
    #productmasterlist th:nth-child(1) { width: 5%; }  /* ID */
    #productmasterlist th:nth-child(2) { width: 8%; }  /* Image */
    #productmasterlist th:nth-child(3) { width: 25%; } /* Product Name - increased */
    #productmasterlist th:nth-child(4) { width: 12%; } /* Category */
    #productmasterlist th:nth-child(5) { width: 10%; } /* Price Range */
    #productmasterlist th:nth-child(6) { width: 15%; } /* Tags */
    #productmasterlist th:nth-child(7) { width: 8%; }  /* Featured */
    #productmasterlist th:nth-child(8) { width: 12%; } /* Date Added */
    #productmasterlist th:nth-child(9) { width: 5%; }  /* Actions */
    
    /* Product name styling with truncation */
    .product-name-cell {
        max-width: 250px;
    }
    .product-name-cell strong {
        display: block;
        white-space: normal;
        word-wrap: break-word;
    }
    .product-name-cell small {
        display: block;
        white-space: normal;
        word-wrap: break-word;
    }
    
    /* Category cell styling */
    .category-cell {
        white-space: normal;
        word-wrap: break-word;
    }
    
    /* Tags container styling */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin: 0;
        padding: 0;
    }
    
    .tag-item {
        display: inline-block;
        background-color: #f0f0f0;
        color: #333;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        white-space: nowrap;
    }
    
    /* Product thumbnail styling */
    .product-thumbnail {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    
    /* DataTables responsive fixes */
    .datatable-wrapper {
        overflow-x: auto;
    }
    
    /* Fix for DataTables search and pagination */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 15px;
    }
    
    /* Ensure table doesn't overflow on mobile */
    @media (max-width: 768px) {
        #productmasterlist th:nth-child(3) { width: 30%; }
        #productmasterlist th:nth-child(4) { width: 15%; }
        .product-name-cell small {
            display: none; /* Hide excerpt on mobile */
        }
    }
    
    /* Price styling */
    .price-range {
        font-weight: bold;
        color: #28a745;
        white-space: nowrap;
    }
    
    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }
    .action-buttons a {
        text-decoration: none;
    }
    /* Horizontal scrolling thumbnails */
    .thumbnail-scroll-container {
        position: relative;
        width: 100%;
    }

    .thumbnail-scroll-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .thumbnail-scroll {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 5px 0;
        flex: 1;
    }

    .thumbnail-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .thumbnail-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .thumbnail-scroll::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .thumbnail-scroll::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .thumbnail-item {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        cursor: pointer;
        border: 2px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .thumbnail-item:hover {
        transform: scale(1.05);
        border-color: #007bff;
    }

    .thumbnail-item.active {
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }

    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .scroll-btn {
        flex-shrink: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #007bff;
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        z-index: 10;
    }

    .scroll-btn:hover {
        background: #0056b3;
        transform: scale(1.05);
    }

    .scroll-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .scroll-btn i {
        font-size: 14px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .thumbnail-item {
            width: 60px;
            height: 60px;
        }
        
        .scroll-btn {
            width: 28px;
            height: 28px;
        }
        
        .scroll-btn i {
            font-size: 12px;
        }
    }
</style>

<div class="app-container">
    <?=$this->include('templates/admin/sidebar');?>
    <div class="app-main" id="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 m-b-30">
                    <div class="d-block d-sm-flex flex-nowrap align-items-center">
                        <div class="page-title mb-2 mb-sm-0">
                            <h1><i class="fas fa-box"></i> Products</h1>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Products</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fas fa-box"></i> Product Masterlist</h4>
                            </div>
                            <div>
                                <a href="/admin/add-product" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i> Add New Product
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper table-responsive">
                                <table id="productmasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Price Range</th>
                                            <th>Tags</th>
                                            <th>Featured</th>
                                            <th>Date Added</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Product Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">
                    <i class="fas fa-eye"></i> Product Details
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="productPreviewContent" style="max-height: 80vh; overflow-y: auto;">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading product details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<?=$this->include('templates/admin/footer');?>

<script>
    let baseUrl = "<?=base_url();?>";
</script>
<script src="<?=base_url();?>assets/js/admin/product-masterlist.js"></script>