<?=$this->include('templates/admin/header');?>

<style>
    /* Fix for tags column */
    .table-bordered td:nth-child(3),
    .table-bordered th:nth-child(3) {
        width: 18% !important;
        max-width: 180px;
        min-width: 150px;
    }
    
    /* Tags container styling */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    
    .tag-item {
        display: inline-block;
        background-color: #f0f0f0;
        color: #333;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    /* Ensure table cells don't expand */
    .datatable-wrapper table td,
    .datatable-wrapper table th {
        word-break: break-word;
        vertical-align: middle;
    }
    
    /* Fix for table layout */
    #blogmasterlist {
        table-layout: fixed;
        width: 100%;
    }
    
    /* Column widths */
    #blogmasterlist th:nth-child(1) { width: 25%; } /* Title */
    #blogmasterlist th:nth-child(2) { width: 12%; } /* Category */
    #blogmasterlist th:nth-child(3) { width: 18%; } /* Tags */
    #blogmasterlist th:nth-child(4) { width: 8%; } /* Views */
    #blogmasterlist th:nth-child(5) { width: 10%; } /* Status */
    #blogmasterlist th:nth-child(6) { width: 12%; } /* Date Published */
    #blogmasterlist th:nth-child(7) { width: 10%; } /* Featured */
    #blogmasterlist th:nth-child(8) { width: 5%; } /* Actions */
    
    /* View count styling */
    .view-count {
        font-weight: 600;
        color: #3D204E;
    }
    
    /* Featured star styling */
    .featured-star {
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .featured-star:hover {
        transform: scale(1.2);
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
                            <h1><i class="fas fa-blog"></i> Blogs</h1>
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
                                    <li class="breadcrumb-item active text-primary" aria-current="page">Blogs</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-statistics">
                        <div class="card-header d-flex align-items-center">
                            <div class="card-heading">
                                <h4 class="card-title"><i class="fas fa-blog"></i> Blog Posts</h4>
                            </div>
                            <div class="ml-auto">
                                <a href="/admin/add-blog" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add New Blog
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="datatable-wrapper table-responsive">
                                <table id="blogmasterlist" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Tags</th>
                                            <th>Views</th>
                                            <th>Status</th>
                                            <th>Date Published</th>
                                            <th>Featured</th>
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

<!-- View Blog Modal -->
<div class="modal fade" id="viewBlogModal" tabindex="-1" role="dialog" aria-labelledby="viewBlogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBlogModalLabel">
                    <i class="fas fa-eye"></i> Blog Preview
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="blogPreviewContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Loading blog content...</p>
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
<script src="<?=base_url();?>assets/js/admin/blog-masterlist.js"></script>