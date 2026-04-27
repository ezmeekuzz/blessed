<?= $this->include('templates/header'); ?>

        <section class="edit-layout-section py-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex gap-0" style="min-height: 600px; height: 600px; max-height: 600px;">
                            <!-- Sidebar with Tabs - fixed height -->
                            <div class="sidebar" id="sidebarMenu" style="height: 600px; overflow-y: auto; overflow-x: hidden;">
                                <button class="toggle-btn" id="toggleSidebar">
                                    <i class="bi bi-chevron-left" id="toggleIcon"></i>
                                </button>
                                
                                <nav class="mt-3" role="tablist">
                                    <div>
                                        <button class="menu-item tab-button active" id="design-tab" data-bs-toggle="tab" data-bs-target="#design-content" type="button" role="tab" aria-controls="design-content" aria-selected="false">
                                            <i class="fa-solid fa-table-columns menu-icon"></i>
                                            <span class="menu-text">Design</span>
                                        </button>
                                        <button class="menu-item tab-button" id="elements-tab" data-bs-toggle="tab" data-bs-target="#elements-content" type="button" role="tab" aria-controls="elements-content" aria-selected="false">
                                            <i class="fa-solid fa-palette menu-icon"></i>
                                            <span class="menu-text">Elements</span>
                                        </button>
                                        <button class="menu-item tab-button" id="add-text-tab" data-bs-toggle="tab" data-bs-target="#addtext-content" type="button" role="tab" aria-controls="addtext-content" aria-selected="false">
                                            <i class="fa-solid fa-font menu-icon"></i>
                                            <span class="menu-text">Add Text</span>
                                        </button>
                                        <button class="menu-item tab-button" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-content" type="button" role="tab" aria-controls="upload-content" aria-selected="true">
                                            <i class="fa-solid fa-cloud-arrow-up menu-icon"></i>
                                            <span class="menu-text">Uploads</span>
                                        </button>
                                        <button class="menu-item tab-button" id="tools-tab" data-bs-toggle="tab" data-bs-target="#tools-content" type="button" role="tab" aria-controls="tools-content" aria-selected="true">
                                            <i class="fa-solid fa-paintbrush menu-icon"></i>
                                            <span class="menu-text">Tools</span>
                                        </button>
                                        <button class="menu-item tab-button" id="bible-tab" data-bs-toggle="tab" data-bs-target="#bible-content" type="button" role="tab" aria-controls="bible-content" aria-selected="false">
                                            <i class="fa-solid fa-bible menu-icon"></i>
                                            <span class="menu-text">Bible</span>
                                        </button>
                                    </div>
                                    
                                    <!-- Create New Tab Button at the bottom -->
                                    <div style="margin-top: auto; padding-top: 15px;">
                                        <button class="menu-item tab-button" id="create-new-tab" data-bs-toggle="tab" data-bs-target="#create-new-content" type="button" role="tab" aria-controls="create-new-content" aria-selected="false" style="border-top: 1px solid rgba(61,32,78,0.2); border-radius: 0;">
                                            <i class="fa-solid fa-plus-circle menu-icon"></i>
                                            <span class="menu-text fw-bold">Create New</span>
                                        </button>
                                    </div>
                                </nav>
                            </div>
                            
                            <!-- Left Content Area - Tab Panels - fixed height with scrolling -->
                            <div class="flex-grow-1" style="background: #fff; padding: 24px; width: 20%; height: 600px; overflow-y: auto;">
                                <div class="tab-content" id="contentTabContent">
                                    <div class="tab-pane fade show active" id="design-content" role="tabpanel" aria-labelledby="design-tab">   
                                        <h5 class="fw-semibold" style="color: #3D204E;">Templates</h5>  
                                        <div class="row g-4 py-4">     
                                            <span>Recently Used</span>           
                                            <div class="col-md-4">
                                                <!-- Template Card 1 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-1.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <!-- Template Card 2 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-2.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                                        </div>     
                                        <div class="row g-4 py-3">    
                                            <span>All Results</span>      
                                            <div class="col-md-4">
                                                <!-- Template Card 1 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-1.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <!-- Template Card 2 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-2.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                    
                                            <div class="col-md-4">
                                                <!-- Template Card 2 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-3.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>       
                                            <div class="col-md-4">
                                                <!-- Template Card 1 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-4.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <!-- Template Card 2 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-5.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                    
                                            <div class="col-md-4">
                                                <!-- Template Card 2 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-6.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>       
                                            <div class="col-md-4">
                                                <!-- Template Card 1 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-7.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <!-- Template Card 2 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-8.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                    
                                            <div class="col-md-4">
                                                <!-- Template Card 2 - Letter Size -->
                                                <div class="template-card border" 
                                                    style="aspect-ratio: 8.5/11; width: 100%; border-radius: 16px; overflow: hidden;">
                                                    <img src="<?=base_url();?>images/template-9.png" class="w-100 h-100" style="object-fit: cover;" alt="">
                                                </div>
                                            </div>
                                        </div>     
                                    </div>
                                    <!-- Elements Tab Content - Replace the empty elements-content tab-pane -->
                                    <div class="tab-pane fade" id="elements-content" role="tabpanel" aria-labelledby="elements-tab">
                                        <div class="elements-container" id="elementsContainer">
                                            <!-- Browse Categories Header -->
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="fw-semibold mb-0" style="color: #3D204E;">Browse Categories</h5>
                                                <div class="d-flex gap-3">
                                                    <a href="#" class="text-decoration-none small" style="color: #3D204E;" id="recentlyUsedLink">Recently Used</a>
                                                    <a href="#" class="text-decoration-none small" style="color: #3D204E;" id="seeAllLink">See All</a>
                                                </div>
                                            </div>

                                            <!-- All Categories Section (Main View) -->
                                            <div class="mb-4" id="mainCategoriesView">
                                                <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem;">All Categories</h6>
                                                <div class="row g-2">
                                                    <!-- Shapes Category - Clickable -->
                                                    <div class="col-4">
                                                        <div class="element-card p-2 text-center category-item" data-category="shapes" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="element-preview mb-2 d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                <i class="fa-solid fa-shapes fs-1" style="color: #D4AF37;"></i>
                                                            </div>
                                                            <span class="small fw-semibold" style="color: #3D204E; font-size: 0.7rem; line-height: 1.2; display: block;">Shapes</span>
                                                        </div>
                                                    </div>

                                                    <!-- Graphics Category -->
                                                    <div class="col-4">
                                                        <div class="element-card p-2 text-center category-item" data-category="graphics" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="element-preview mb-2 d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                <i class="fa-solid fa-seedling fs-1" style="color: #3D204E;"></i>
                                                            </div>
                                                            <span class="small fw-semibold" style="color: #3D204E; font-size: 0.7rem; line-height: 1.2; display: block;">Graphics</span>
                                                        </div>
                                                    </div>

                                                    <!-- Photos Category -->
                                                    <div class="col-4">
                                                        <div class="element-card p-2 text-center category-item" data-category="photos" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="element-preview mb-2 d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                <i class="fa-solid fa-image fs-1" style="color: #8B4513;"></i>
                                                            </div>
                                                            <span class="small fw-semibold" style="color: #3D204E; font-size: 0.7rem; line-height: 1.2; display: block;">Photos</span>
                                                        </div>
                                                    </div>

                                                    <!-- Frames Category -->
                                                    <div class="col-4">
                                                        <div class="element-card p-2 text-center category-item" data-category="frames" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="element-preview mb-2 d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                <i class="fa-solid fa-crop-simple fs-1" style="color: #2E8B57;"></i>
                                                            </div>
                                                            <span class="small fw-semibold" style="color: #3D204E; font-size: 0.7rem; line-height: 1.2; display: block;">Frames</span>
                                                        </div>
                                                    </div>

                                                    <!-- Grids Category -->
                                                    <div class="col-4">
                                                        <div class="element-card p-2 text-center category-item" data-category="grids" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="element-preview mb-2 d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                <i class="fa-solid fa-table-columns fs-1" style="color: #FF69B4;"></i>
                                                            </div>
                                                            <span class="small fw-semibold" style="color: #3D204E; font-size: 0.7rem; line-height: 1.2; display: block;">Grids</span>
                                                        </div>
                                                    </div>

                                                    <!-- 3D Category -->
                                                    <div class="col-4">
                                                        <div class="element-card p-2 text-center category-item" data-category="3d" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="element-preview mb-2 d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                <i class="fa-solid fa-cubes fs-1" style="color: #228B22;"></i>
                                                            </div>
                                                            <span class="small fw-semibold" style="color: #3D204E; font-size: 0.7rem; line-height: 1.2; display: block;">3D</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Shapes Detailed View (Hidden by default) -->
                                            <div class="shapes-detailed-view" id="shapesDetailedView" style="display: none;">
                                                <!-- Back Button and Title -->
                                                <div class="d-flex align-items-center mb-4">
                                                    <button class="btn p-0 me-3 back-to-categories" style="color: #3D204E; border: none; background: transparent; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s ease;" onmouseover="this.style.background='#f3eff7'" onmouseout="this.style.background='transparent'">
                                                        <i class="fas fa-arrow-left fs-5"></i>
                                                    </button>
                                                    <h4 class="fw-bold mb-0" style="color: #3D204E; font-size: 1.8rem;">Shapes</h4>
                                                </div>

                                                <!-- Recently Used & See All Links -->
                                                <div class="d-flex justify-content-end align-items-center mb-4">
                                                    <div class="d-flex gap-4">
                                                        <a href="#" class="text-decoration-none small fw-semibold recently-used-link" style="color: #3D204E; font-size: 0.9rem; padding: 4px 12px; border-radius: 30px; transition: all 0.2s ease;" onmouseover="this.style.background='#f3eff7'" onmouseout="this.style.background='transparent'">Recently Used</a>
                                                        <a href="#" class="text-decoration-none small fw-semibold see-all-link" style="color: #3D204E; font-size: 0.9rem; padding: 4px 12px; border-radius: 30px; transition: all 0.2s ease;" onmouseover="this.style.background='#f3eff7'" onmouseout="this.style.background='transparent'">See All</a>
                                                    </div>
                                                </div>

                                                <!-- Quick Access - Basic Shapes Section -->
                                                <div class="mb-5">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">QUICK ACCESS</h6>
                                                    <div class="row g-3">
                                                        <!-- Circles -->
                                                        <div class="col-4">
                                                            <div class="shape-item p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="shape-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #D4AF37, #B8860B); box-shadow: 0 4px 8px rgba(212,175,55,0.3);"></div>
                                                                </div>
                                                                <span class="fw-semibold" style="color: #3D204E; font-size: 0.9rem;">Circles</span>
                                                            </div>
                                                        </div>

                                                        <!-- Squares -->
                                                        <div class="col-4">
                                                            <div class="shape-item p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="shape-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3D204E, #5a2e73); box-shadow: 0 4px 8px rgba(61,32,78,0.3);"></div>
                                                                </div>
                                                                <span class="fw-semibold" style="color: #3D204E; font-size: 0.9rem;">Squares</span>
                                                            </div>
                                                        </div>

                                                        <!-- Triangles -->
                                                        <div class="col-4">
                                                            <div class="shape-item p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="shape-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="width: 0; height: 0; border-left: 30px solid transparent; border-right: 30px solid transparent; border-bottom: 50px solid #2E8B57; filter: drop-shadow(0 4px 6px rgba(46,139,87,0.3));"></div>
                                                                </div>
                                                                <span class="fw-semibold" style="color: #3D204E; font-size: 0.9rem;">Triangles</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Elements Categories with Dividers -->
                                                <div class="elements-categories">
                                                    <!-- Lines -->
                                                    <div class="category-block mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1rem;">Lines</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-minus fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Straight</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-wave-square fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Wavy</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-grip-lines fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Dashed</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-arrow-right-long fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Arrow</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Basic Shapes -->
                                                    <div class="category-block mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1rem;">Basic Shapes</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-circle fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Circle</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-square fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Square</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-rectangle-ad fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Rectangle</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-circle-dot fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Oval</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Polygons -->
                                                    <div class="category-block mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1rem;">Polygons</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-caret-up fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Triangle</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-pentagon fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Pentagon</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-hexagon fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Hexagon</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-octagon fs-3" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Octagon</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Stars -->
                                                    <div class="category-block mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1rem;">Stars</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-star fs-3" style="color: #D4AF37;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">5 Point</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-star-half-stroke fs-3" style="color: #D4AF37;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">6 Point</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-compass fs-3" style="color: #D4AF37;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">8 Point</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-diamond fs-3" style="color: #D4AF37;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Sparkle</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Arrows -->
                                                    <div class="category-block mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1rem;">Arrows</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-arrow-right fs-3" style="color: #FF69B4;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Right</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-arrow-left fs-3" style="color: #FF69B4;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Left</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-arrow-up fs-3" style="color: #FF69B4;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Up</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-solid fa-arrow-down fs-3" style="color: #FF69B4;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Down</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Flowchart -->
                                                    <div class="category-block mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1rem;">Flowchart</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-2">
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-rectangle-ad fs-3" style="color: #228B22;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Process</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-diamond fs-3" style="color: #228B22;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Decision</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-circle fs-3" style="color: #228B22;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Terminator</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="shape-mini-card p-2 text-center" style="background: #f8f4fa; border-radius: 12px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 40px;">
                                                                        <i class="fa-regular fa-note-sticky fs-3" style="color: #228B22;"></i>
                                                                    </div>
                                                                    <span class="small" style="color: #3D204E;">Document</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Create Button -->
                                                <div class="mt-5 pt-3">
                                                    <button class="btn w-100 py-3 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-3 create-shape-btn" style="background: linear-gradient(135deg, #3D204E, #5a2e73); color: white; border: none; box-shadow: 0 8px 16px rgba(61,32,78,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'">
                                                        <i class="fa-solid fa-plus-circle fs-5"></i>
                                                        <span class="fs-6">Create Custom Shape</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="graphics-detailed-view" id="graphicsDetailedView" style="display: none;">
                                                <!-- Back Button and Title -->
                                                <div class="d-flex align-items-center mb-4">
                                                    <button class="btn p-0 me-3 back-to-categories" style="color: #3D204E; border: none; background: transparent; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s ease;" onmouseover="this.style.background='#f3eff7'" onmouseout="this.style.background='transparent'">
                                                        <i class="fas fa-arrow-left fs-5"></i>
                                                    </button>
                                                    <h4 class="fw-bold mb-0" style="color: #3D204E; font-size: 1.8rem;">Graphics</h4>
                                                </div>

                                                <!-- Recently Used Section -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">RECENTLY USED</h6>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-2">
                                                        <!-- Design -->
                                                        <div class="col-4">
                                                            <div class="recent-item p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.borderColor='transparent'">
                                                                <div class="recent-icon mb-2 d-flex align-items-center justify-content-center" style="height: 50px;">
                                                                    <i class="fa-solid fa-table-columns fs-2" style="color: #3D204E;"></i>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Design</span>
                                                            </div>
                                                        </div>
                                                        <!-- Elements -->
                                                        <div class="col-4">
                                                            <div class="recent-item p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.borderColor='transparent'">
                                                                <div class="recent-icon mb-2 d-flex align-items-center justify-content-center" style="height: 50px;">
                                                                    <i class="fa-solid fa-palette fs-2" style="color: #3D204E;"></i>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Elements</span>
                                                            </div>
                                                        </div>
                                                        <!-- Text -->
                                                        <div class="col-4">
                                                            <div class="recent-item p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.borderColor='transparent'">
                                                                <div class="recent-icon mb-2 d-flex align-items-center justify-content-center" style="height: 50px;">
                                                                    <i class="fa-solid fa-font fs-2" style="color: #3D204E;"></i>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Text</span>
                                                            </div>
                                                        </div>
                                                        <!-- Uploads -->
                                                        <div class="col-4">
                                                            <div class="recent-item p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.borderColor='transparent'">
                                                                <div class="recent-icon mb-2 d-flex align-items-center justify-content-center" style="height: 50px;">
                                                                    <i class="fa-solid fa-cloud-arrow-up fs-2" style="color: #3D204E;"></i>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Uploads</span>
                                                            </div>
                                                        </div>
                                                        <!-- Tools -->
                                                        <div class="col-4">
                                                            <div class="recent-item p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.borderColor='transparent'">
                                                                <div class="recent-icon mb-2 d-flex align-items-center justify-content-center" style="height: 50px;">
                                                                    <i class="fa-solid fa-paintbrush fs-2" style="color: #3D204E;"></i>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Tools</span>
                                                            </div>
                                                        </div>
                                                        <!-- Bible -->
                                                        <div class="col-4">
                                                            <div class="recent-item p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.borderColor='transparent'">
                                                                <div class="recent-icon mb-2 d-flex align-items-center justify-content-center" style="height: 50px;">
                                                                    <i class="fa-solid fa-bible fs-2" style="color: #3D204E;"></i>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Bible</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Social Media Section with Medium and Icons -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">SOCIAL MEDIA</h6>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    
                                                    <!-- Medium Category -->
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 0.95rem;">Medium</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <!-- Facebook -->
                                                            <div class="col-4">
                                                                <div class="social-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                    <div class="social-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                        <i class="fa-brands fa-facebook-f fs-1" style="color: #1877F2;"></i>
                                                                    </div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E; font-size: 0.9rem;">Facebook</span>
                                                                    <span class="small text-muted">24 graphics</span>
                                                                </div>
                                                            </div>
                                                            <!-- Instagram -->
                                                            <div class="col-4">
                                                                <div class="social-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                    <div class="social-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                        <i class="fa-brands fa-instagram fs-1" style="color: #E4405F;"></i>
                                                                    </div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E; font-size: 0.9rem;">Instagram</span>
                                                                    <span class="small text-muted">18 graphics</span>
                                                                </div>
                                                            </div>
                                                            <!-- Twitter/X -->
                                                            <div class="col-4">
                                                                <div class="social-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                    <div class="social-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                        <i class="fa-brands fa-x-twitter fs-1" style="color: #000000;"></i>
                                                                    </div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E; font-size: 0.9rem;">X (Twitter)</span>
                                                                    <span class="small text-muted">12 graphics</span>
                                                                </div>
                                                            </div>
                                                            <!-- LinkedIn -->
                                                            <div class="col-4">
                                                                <div class="social-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                    <div class="social-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                        <i class="fa-brands fa-linkedin-in fs-1" style="color: #0A66C2;"></i>
                                                                    </div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E; font-size: 0.9rem;">LinkedIn</span>
                                                                    <span class="small text-muted">15 graphics</span>
                                                                </div>
                                                            </div>
                                                            <!-- Pinterest -->
                                                            <div class="col-4">
                                                                <div class="social-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                    <div class="social-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                        <i class="fa-brands fa-pinterest-p fs-1" style="color: #BD081C;"></i>
                                                                    </div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E; font-size: 0.9rem;">Pinterest</span>
                                                                    <span class="small text-muted">9 graphics</span>
                                                                </div>
                                                            </div>
                                                            <!-- TikTok -->
                                                            <div class="col-4">
                                                                <div class="social-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                    <div class="social-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                        <i class="fa-brands fa-tiktok fs-1" style="color: #000000;"></i>
                                                                    </div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E; font-size: 0.9rem;">TikTok</span>
                                                                    <span class="small text-muted">7 graphics</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Icons Category -->
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 0.95rem;">Icons</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <!-- Heart Icons -->
                                                            <div class="col-3">
                                                                <div class="icon-card p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='scale(1)'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                        <i class="fa-solid fa-heart fs-1" style="color: #FF69B4;"></i>
                                                                    </div>
                                                                    <span class="small fw-semibold" style="color: #3D204E;">Hearts</span>
                                                                </div>
                                                            </div>
                                                            <!-- Star Icons -->
                                                            <div class="col-3">
                                                                <div class="icon-card p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='scale(1)'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                        <i class="fa-solid fa-star fs-1" style="color: #D4AF37;"></i>
                                                                    </div>
                                                                    <span class="small fw-semibold" style="color: #3D204E;">Stars</span>
                                                                </div>
                                                            </div>
                                                            <!-- Flower Icons -->
                                                            <div class="col-3">
                                                                <div class="icon-card p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='scale(1)'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                        <i class="fa-solid fa-seedling fs-1" style="color: #2E8B57;"></i>
                                                                    </div>
                                                                    <span class="small fw-semibold" style="color: #3D204E;">Nature</span>
                                                                </div>
                                                            </div>
                                                            <!-- Arrow Icons -->
                                                            <div class="col-3">
                                                                <div class="icon-card p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='scale(1)'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                        <i class="fa-solid fa-arrow-right fs-1" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small fw-semibold" style="color: #3D204E;">Arrows</span>
                                                                </div>
                                                            </div>
                                                            <!-- Check Icons -->
                                                            <div class="col-3">
                                                                <div class="icon-card p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='scale(1)'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                        <i class="fa-solid fa-check fs-1" style="color: #228B22;"></i>
                                                                    </div>
                                                                    <span class="small fw-semibold" style="color: #3D204E;">Checks</span>
                                                                </div>
                                                            </div>
                                                            <!-- Alert Icons -->
                                                            <div class="col-3">
                                                                <div class="icon-card p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='scale(1)'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                        <i class="fa-solid fa-circle-exclamation fs-1" style="color: #FF4444;"></i>
                                                                    </div>
                                                                    <span class="small fw-semibold" style="color: #3D204E;">Alerts</span>
                                                                </div>
                                                            </div>
                                                            <!-- Clock Icons -->
                                                            <div class="col-3">
                                                                <div class="icon-card p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='scale(1)'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                        <i class="fa-regular fa-clock fs-1" style="color: #3D204E;"></i>
                                                                    </div>
                                                                    <span class="small fw-semibold" style="color: #3D204E;">Time</span>
                                                                </div>
                                                            </div>
                                                            <!-- Calendar Icons -->
                                                            <div class="col-3">
                                                                <div class="icon-card p-2 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='scale(1.05)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='scale(1)'">
                                                                    <div class="d-flex align-items-center justify-content-center" style="height: 60px;">
                                                                        <i class="fa-regular fa-calendar fs-1" style="color: #FF69B4;"></i>
                                                                    </div>
                                                                    <span class="small fw-semibold" style="color: #3D204E;">Calendar</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Faith-Based Graphics Section (Added for completeness) -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">FAITH-BASED</h6>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-3">
                                                        <!-- Crosses -->
                                                        <div class="col-4">
                                                            <div class="faith-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                <div class="faith-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                    <i class="fa-solid fa-cross fs-1" style="color: #D4AF37;"></i>
                                                                </div>
                                                                <span class="fw-semibold d-block" style="color: #3D204E;">Crosses</span>
                                                                <span class="small text-muted">32 graphics</span>
                                                            </div>
                                                        </div>
                                                        <!-- Doves -->
                                                        <div class="col-4">
                                                            <div class="faith-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                <div class="faith-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                    <i class="fa-solid fa-dove fs-1" style="color: #FFFFFF; text-shadow: 0 2px 4px rgba(0,0,0,0.2);"></i>
                                                                </div>
                                                                <span class="fw-semibold d-block" style="color: #3D204E;">Doves</span>
                                                                <span class="small text-muted">15 graphics</span>
                                                            </div>
                                                        </div>
                                                        <!-- Praying Hands -->
                                                        <div class="col-4">
                                                            <div class="faith-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                <div class="faith-icon mb-2 d-flex align-items-center justify-content-center" style="height: 70px;">
                                                                    <i class="fa-solid fa-hands-praying fs-1" style="color: #8B4513;"></i>
                                                                </div>
                                                                <span class="fw-semibold d-block" style="color: #3D204E;">Praying Hands</span>
                                                                <span class="small text-muted">21 graphics</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Popular Tags Section -->
                                                <div class="mb-4">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 0.95rem;">POPULAR TAGS</h6>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <span class="badge rounded-pill px-3 py-2" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">#worship</span>
                                                        <span class="badge rounded-pill px-3 py-2" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">#prayer</span>
                                                        <span class="badge rounded-pill px-3 py-2" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">#blessed</span>
                                                        <span class="badge rounded-pill px-3 py-2" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">#faith</span>
                                                        <span class="badge rounded-pill px-3 py-2" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">#hope</span>
                                                        <span class="badge rounded-pill px-3 py-2" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">#love</span>
                                                        <span class="badge rounded-pill px-3 py-2" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">#jesus</span>
                                                        <span class="badge rounded-pill px-3 py-2" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.8rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">#christian</span>
                                                    </div>
                                                </div>

                                                <!-- Create Button -->
                                                <div class="mt-5 pt-3">
                                                    <button class="btn w-100 py-3 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-3 create-graphic-btn" style="background: linear-gradient(135deg, #3D204E, #5a2e73); color: white; border: none; box-shadow: 0 8px 16px rgba(61,32,78,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'">
                                                        <i class="fa-solid fa-plus-circle fs-5"></i>
                                                        <span class="fs-6">Create Custom Graphic</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Photos Detailed View (add this after the Graphics detailed view) -->
                                            <div class="photos-detailed-view" id="photosDetailedView" style="display: none;">
                                                <!-- Back Button and Title -->
                                                <div class="d-flex align-items-center mb-4">
                                                    <button class="btn p-0 me-3 back-to-categories" style="color: #3D204E; border: none; background: transparent; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s ease;" onmouseover="this.style.background='#f3eff7'" onmouseout="this.style.background='transparent'">
                                                        <i class="fas fa-arrow-left fs-5"></i>
                                                    </button>
                                                    <h4 class="fw-bold mb-0" style="color: #3D204E; font-size: 1.8rem;">Photos</h4>
                                                </div>

                                                <!-- Search Bar -->
                                                <div class="mb-4">
                                                    <div class="search-box d-flex align-items-center" style="border: 1px solid #e0e0e0; border-radius: 30px; padding: 0.5rem 1.2rem; background: white; box-shadow: 0 2px 8px rgba(61,32,78,0.05);">
                                                        <i class="fas fa-search text-secondary me-2" style="color: #3D204E;"></i>
                                                        <input type="text" placeholder="Search photos, keywords, or colors..." class="bg-transparent w-100" style="border: none; outline: none; font-size: 0.95rem;">
                                                    </div>
                                                </div>

                                                <!-- Recently Used Section -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">RECENTLY USED</h6>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-2">
                                                        <!-- Recent Photo 1 -->
                                                        <div class="col-4">
                                                            <div class="recent-photo-card" style="border-radius: 16px; overflow: hidden; aspect-ratio: 1/1; cursor: pointer; box-shadow: 0 4px 8px rgba(61,32,78,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.1)'">
                                                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=150&h=150&fit=crop" alt="Sunset landscape" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        </div>
                                                        <!-- Recent Photo 2 -->
                                                        <div class="col-4">
                                                            <div class="recent-photo-card" style="border-radius: 16px; overflow: hidden; aspect-ratio: 1/1; cursor: pointer; box-shadow: 0 4px 8px rgba(61,32,78,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.1)'">
                                                                <img src="https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=150&h=150&fit=crop" alt="Nature fog" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        </div>
                                                        <!-- Recent Photo 3 -->
                                                        <div class="col-4">
                                                            <div class="recent-photo-card" style="border-radius: 16px; overflow: hidden; aspect-ratio: 1/1; cursor: pointer; box-shadow: 0 4px 8px rgba(61,32,78,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.1)'">
                                                                <img src="https://images.unsplash.com/photo-1426604966848-d7adac402b18?w=150&h=150&fit=crop" alt="Mountains" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        </div>
                                                        <!-- Recent Photo 4 -->
                                                        <div class="col-4">
                                                            <div class="recent-photo-card" style="border-radius: 16px; overflow: hidden; aspect-ratio: 1/1; cursor: pointer; box-shadow: 0 4px 8px rgba(61,32,78,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.1)'">
                                                                <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=150&h=150&fit=crop" alt="Forest" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        </div>
                                                        <!-- Recent Photo 5 -->
                                                        <div class="col-4">
                                                            <div class="recent-photo-card" style="border-radius: 16px; overflow: hidden; aspect-ratio: 1/1; cursor: pointer; box-shadow: 0 4px 8px rgba(61,32,78,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.1)'">
                                                                <img src="https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=150&h=150&fit=crop" alt="Lake" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        </div>
                                                        <!-- Recent Photo 6 -->
                                                        <div class="col-4">
                                                            <div class="recent-photo-card" style="border-radius: 16px; overflow: hidden; aspect-ratio: 1/1; cursor: pointer; box-shadow: 0 4px 8px rgba(61,32,78,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.1)'">
                                                                <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?w=150&h=150&fit=crop" alt="Mountains lake" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Recommendation Section -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">RECOMMENDATION</h6>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>

                                                    <!-- TACO TACO Card -->
                                                    <div class="recommendation-card mb-3 p-3" style="background: linear-gradient(135deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                        <div class="d-flex gap-3">
                                                            <div class="recommendation-image" style="width: 100px; height: 100px; border-radius: 20px; overflow: hidden; flex-shrink: 0;">
                                                                <img src="https://images.unsplash.com/photo-1599974579688-8dbdd335c77f?w=200&h=200&fit=crop" alt="TACO TACO" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                            <div class="recommendation-content flex-grow-1">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <h5 class="fw-bold mb-1" style="color: #3D204E; font-size: 1.2rem;">TACO TACO</h5>
                                                                        <p class="small text-muted mb-2" style="font-size: 0.8rem;">Aq</p>
                                                                        <div class="d-flex align-items-center gap-2 mb-2">
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">Mexican</span>
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">Food</span>
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">Vibrant</span>
                                                                        </div>
                                                                    </div>
                                                                    <i class="fa-regular fa-heart fs-5" style="color: #3D204E;"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Crypto - Invest And Take Profits Card -->
                                                    <div class="recommendation-card mb-3 p-3" style="background: linear-gradient(135deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                        <div class="d-flex gap-3">
                                                            <div class="recommendation-image" style="width: 100px; height: 100px; border-radius: 20px; overflow: hidden; flex-shrink: 0;">
                                                                <img src="https://images.unsplash.com/photo-1518546305927-5a555bb7020d?w=200&h=200&fit=crop" alt="Crypto" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                            <div class="recommendation-content flex-grow-1">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <h5 class="fw-bold mb-1" style="color: #3D204E; font-size: 1.2rem;">Crypto - Invest And Take Profits</h5>
                                                                        <p class="small text-muted mb-2" style="font-size: 0.8rem;">Modern Crypto UI.</p>
                                                                        <div class="d-flex align-items-center gap-2 mb-2">
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">Crypto</span>
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">Finance</span>
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">UI</span>
                                                                        </div>
                                                                    </div>
                                                                    <i class="fa-regular fa-heart fs-5" style="color: #3D204E;"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Buying crypto made easy Card -->
                                                    <div class="recommendation-card p-3" style="background: linear-gradient(135deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                        <div class="d-flex gap-3">
                                                            <div class="recommendation-image" style="width: 100px; height: 100px; border-radius: 20px; overflow: hidden; flex-shrink: 0;">
                                                                <img src="https://images.unsplash.com/photo-1642790551116-18e150f248e3?w=200&h=200&fit=crop" alt="Crypto selfie" style="width: 100%; height: 100%; object-fit: cover;">
                                                            </div>
                                                            <div class="recommendation-content flex-grow-1">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <p class="mb-1" style="color: #3D204E; font-size: 0.95rem; line-height: 1.4;">Buying crypto made as easy as taking a selfie</p>
                                                                        <div class="d-flex align-items-center gap-2 mt-2">
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">Crypto</span>
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">App</span>
                                                                            <span class="badge px-2 py-1" style="background: rgba(61,32,78,0.1); color: #3D204E; border-radius: 20px; font-size: 0.7rem;">Selfie</span>
                                                                        </div>
                                                                    </div>
                                                                    <i class="fa-regular fa-heart fs-5" style="color: #3D204E;"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Categories Section -->
                                                <div class="mb-4">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">CATEGORIES</h6>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <span class="category-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#3D204E'; this.style.color='white'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'; this.style.borderColor='transparent'">Nature</span>
                                                        <span class="category-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#3D204E'; this.style.color='white'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'; this.style.borderColor='transparent'">Urban</span>
                                                        <span class="category-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#3D204E'; this.style.color='white'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'; this.style.borderColor='transparent'">Food</span>
                                                        <span class="category-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#3D204E'; this.style.color='white'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'; this.style.borderColor='transparent'">Travel</span>
                                                        <span class="category-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#3D204E'; this.style.color='white'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'; this.style.borderColor='transparent'">Animals</span>
                                                        <span class="category-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#3D204E'; this.style.color='white'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'; this.style.borderColor='transparent'">People</span>
                                                        <span class="category-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#3D204E'; this.style.color='white'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'; this.style.borderColor='transparent'">Technology</span>
                                                        <span class="category-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#3D204E'; this.style.color='white'; this.style.borderColor='#3D204E'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'; this.style.borderColor='transparent'">Architecture</span>
                                                    </div>
                                                </div>

                                                <!-- Color Filters -->
                                                <div class="mb-4">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">FILTER BY COLOR</h6>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <div class="color-dot" style="width: 35px; height: 35px; border-radius: 50%; background: #FF6B6B; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#3D204E'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='transparent'"></div>
                                                        <div class="color-dot" style="width: 35px; height: 35px; border-radius: 50%; background: #4ECDC4; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#3D204E'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='transparent'"></div>
                                                        <div class="color-dot" style="width: 35px; height: 35px; border-radius: 50%; background: #FFE66D; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#3D204E'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='transparent'"></div>
                                                        <div class="color-dot" style="width: 35px; height: 35px; border-radius: 50%; background: #1A535C; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#3D204E'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='transparent'"></div>
                                                        <div class="color-dot" style="width: 35px; height: 35px; border-radius: 50%; background: #FF9F1C; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#3D204E'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='transparent'"></div>
                                                        <div class="color-dot" style="width: 35px; height: 35px; border-radius: 50%; background: #E71D36; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#3D204E'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='transparent'"></div>
                                                        <div class="color-dot" style="width: 35px; height: 35px; border-radius: 50%; background: #2EC4B6; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#3D204E'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='transparent'"></div>
                                                        <div class="color-dot" style="width: 35px; height: 35px; border-radius: 50%; background: #8338EC; cursor: pointer; border: 2px solid transparent; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" onmouseover="this.style.transform='scale(1.1)'; this.style.borderColor='#3D204E'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='transparent'"></div>
                                                    </div>
                                                </div>

                                                <!-- Popular Collections -->
                                                <div class="mb-4">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">POPULAR COLLECTIONS</h6>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <div class="collection-card p-3 d-flex align-items-center gap-2" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 18px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='linear-gradient(145deg, #f8f4fa, #ede4f3)'; this.style.transform='translateX(0)'">
                                                                <i class="fa-solid fa-mountain-sun fs-3" style="color: #3D204E;"></i>
                                                                <div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E;">Nature</span>
                                                                    <span class="small text-muted">2.4k photos</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="collection-card p-3 d-flex align-items-center gap-2" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 18px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='linear-gradient(145deg, #f8f4fa, #ede4f3)'; this.style.transform='translateX(0)'">
                                                                <i class="fa-solid fa-city fs-3" style="color: #3D204E;"></i>
                                                                <div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E;">Urban</span>
                                                                    <span class="small text-muted">1.8k photos</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="collection-card p-3 d-flex align-items-center gap-2" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 18px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='linear-gradient(145deg, #f8f4fa, #ede4f3)'; this.style.transform='translateX(0)'">
                                                                <i class="fa-solid fa-utensils fs-3" style="color: #3D204E;"></i>
                                                                <div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E;">Food</span>
                                                                    <span class="small text-muted">3.2k photos</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="collection-card p-3 d-flex align-items-center gap-2" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 18px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='linear-gradient(145deg, #f8f4fa, #ede4f3)'; this.style.transform='translateX(0)'">
                                                                <i class="fa-solid fa-person-walking fs-3" style="color: #3D204E;"></i>
                                                                <div>
                                                                    <span class="fw-semibold d-block" style="color: #3D204E;">People</span>
                                                                    <span class="small text-muted">5.7k photos</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Create Button -->
                                                <div class="mt-5 pt-3">
                                                    <button class="btn w-100 py-3 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-3 create-photo-btn" style="background: linear-gradient(135deg, #3D204E, #5a2e73); color: white; border: none; box-shadow: 0 8px 16px rgba(61,32,78,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'">
                                                        <i class="fa-solid fa-plus-circle fs-5"></i>
                                                        <span class="fs-6">Create New Photo Collection</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Frames Detailed View (add this after the Photos detailed view) -->
                                            <div class="frames-detailed-view" id="framesDetailedView" style="display: none;">
                                                <!-- Back Button and Title -->
                                                <div class="d-flex align-items-center mb-4">
                                                    <button class="btn p-0 me-3 back-to-categories" style="color: #3D204E; border: none; background: transparent; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s ease;" onmouseover="this.style.background='#f3eff7'" onmouseout="this.style.background='transparent'">
                                                        <i class="fas fa-arrow-left fs-5"></i>
                                                    </button>
                                                    <h4 class="fw-bold mb-0" style="color: #3D204E; font-size: 1.8rem;">Frames</h4>
                                                </div>

                                                <!-- Recently Used Section -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">RECENTLY USED</h6>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-2">
                                                        <!-- Recent Frame 1 - Polaroid Style -->
                                                        <div class="col-3">
                                                            <div class="recent-frame-card p-2" style="background: white; border-radius: 16px; cursor: pointer; box-shadow: 0 4px 12px rgba(61,32,78,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-preview mb-2" style="aspect-ratio: 1/1; background: linear-gradient(145deg, #f0f0f0, #e0e0e0); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                                                    <div style="width: 70%; height: 70%; background: white; border: 2px solid #3D204E; border-radius: 4px; display: flex; align-items: flex-end; justify-content: center; padding-bottom: 5px;">
                                                                        <div style="width: 20px; height: 20px; background: #3D204E; border-radius: 2px;"></div>
                                                                    </div>
                                                                </div>
                                                                <span class="small fw-semibold d-block text-center" style="color: #3D204E;">Polaroid</span>
                                                            </div>
                                                        </div>
                                                        <!-- Recent Frame 2 - Classic Border -->
                                                        <div class="col-3">
                                                            <div class="recent-frame-card p-2" style="background: white; border-radius: 16px; cursor: pointer; box-shadow: 0 4px 12px rgba(61,32,78,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-preview mb-2" style="aspect-ratio: 1/1; background: linear-gradient(145deg, #f0f0f0, #e0e0e0); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                                                    <div style="width: 80%; height: 80%; background: white; border: 8px solid #D4AF37; border-radius: 8px;"></div>
                                                                </div>
                                                                <span class="small fw-semibold d-block text-center" style="color: #3D204E;">Classic</span>
                                                            </div>
                                                        </div>
                                                        <!-- Recent Frame 3 - Round Frame -->
                                                        <div class="col-3">
                                                            <div class="recent-frame-card p-2" style="background: white; border-radius: 16px; cursor: pointer; box-shadow: 0 4px 12px rgba(61,32,78,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-preview mb-2" style="aspect-ratio: 1/1; background: linear-gradient(145deg, #f0f0f0, #e0e0e0); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                                                    <div style="width: 70%; height: 70%; background: white; border: 6px solid #2E8B57; border-radius: 50%;"></div>
                                                                </div>
                                                                <span class="small fw-semibold d-block text-center" style="color: #3D204E;">Round</span>
                                                            </div>
                                                        </div>
                                                        <!-- Recent Frame 4 - Double Border -->
                                                        <div class="col-3">
                                                            <div class="recent-frame-card p-2" style="background: white; border-radius: 16px; cursor: pointer; box-shadow: 0 4px 12px rgba(61,32,78,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-preview mb-2" style="aspect-ratio: 1/1; background: linear-gradient(145deg, #f0f0f0, #e0e0e0); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                                                    <div style="width: 70%; height: 70%; background: white; border: 4px solid #3D204E; outline: 2px solid #D4AF37; outline-offset: 2px; border-radius: 4px;"></div>
                                                                </div>
                                                                <span class="small fw-semibold d-block text-center" style="color: #3D204E;">Double</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Film & Photo Section -->
                                                <div class="mb-5">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <h5 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1.2rem;">Film & Photo</h5>
                                                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-3">
                                                        <!-- 35mm Film Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative; width: 80px; height: 80px;">
                                                                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #3D204E; border-radius: 12px; transform: rotate(5deg); opacity: 0.3;"></div>
                                                                        <div style="position: absolute; top: 5px; left: 5px; width: 100%; height: 100%; background: #3D204E; border-radius: 12px; transform: rotate(-2deg); opacity: 0.6;"></div>
                                                                        <div style="position: absolute; top: 10px; left: 10px; width: 100%; height: 100%; background: #3D204E; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">35mm</div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">35mm Film</h6>
                                                                <p class="small text-muted text-center mb-0">24 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- Instant Photo Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 70px; height: 80px; background: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); position: relative;">
                                                                        <div style="position: absolute; top: 5px; left: 5px; right: 5px; bottom: 20px; background: #f0f0f0; border-radius: 4px;"></div>
                                                                        <div style="position: absolute; bottom: 5px; left: 20px; right: 20px; height: 10px; background: #3D204E; border-radius: 2px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Instant Photo</h6>
                                                                <p class="small text-muted text-center mb-0">18 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- Slide Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 90px; height: 60px; background: #3D204E; border-radius: 4px; position: relative;">
                                                                        <div style="position: absolute; top: 5px; left: 5px; right: 5px; bottom: 5px; background: white; border-radius: 2px;"></div>
                                                                        <div style="position: absolute; top: -3px; left: 50%; transform: translateX(-50%); width: 20px; height: 6px; background: #D4AF37; border-radius: 2px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Slide Frame</h6>
                                                                <p class="small text-muted text-center mb-0">12 frames</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Devices Section -->
                                                <div class="mb-5">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <h5 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1.2rem;">Devices</h5>
                                                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-3">
                                                        <!-- Smartphone Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 50px; height: 90px; background: #3D204E; border-radius: 12px; position: relative;">
                                                                        <div style="position: absolute; top: 10px; left: 5px; right: 5px; bottom: 10px; background: white; border-radius: 6px;"></div>
                                                                        <div style="position: absolute; bottom: 5px; left: 20px; right: 20px; height: 4px; background: #D4AF37; border-radius: 2px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Smartphone</h6>
                                                                <p class="small text-muted text-center mb-0">32 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- Tablet Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 80px; height: 60px; background: #3D204E; border-radius: 12px; position: relative;">
                                                                        <div style="position: absolute; top: 8px; left: 8px; right: 8px; bottom: 8px; background: white; border-radius: 6px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Tablet</h6>
                                                                <p class="small text-muted text-center mb-0">15 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- Laptop Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative;">
                                                                        <div style="width: 90px; height: 60px; background: #3D204E; border-radius: 8px 8px 0 0;"></div>
                                                                        <div style="width: 70px; height: 10px; background: #5a2e73; margin: 0 auto; border-radius: 0 0 4px 4px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Laptop</h6>
                                                                <p class="small text-muted text-center mb-0">9 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- Desktop Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 100px; height: 70px; background: #3D204E; border-radius: 8px; position: relative;">
                                                                        <div style="position: absolute; top: 5px; left: 5px; right: 5px; bottom: 5px; background: white; border-radius: 4px;"></div>
                                                                        <div style="position: absolute; bottom: -8px; left: 30px; right: 30px; height: 8px; background: #5a2e73; border-radius: 0 0 4px 4px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Desktop</h6>
                                                                <p class="small text-muted text-center mb-0">7 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- Smartwatch Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 60px; height: 70px; background: #3D204E; border-radius: 20px; position: relative;">
                                                                        <div style="position: absolute; top: 8px; left: 8px; right: 8px; bottom: 8px; background: white; border-radius: 12px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Smartwatch</h6>
                                                                <p class="small text-muted text-center mb-0">11 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- TV Frame -->
                                                        <div class="col-4">
                                                            <div class="frame-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="frame-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 90px; height: 60px; background: #3D204E; border-radius: 12px; position: relative;">
                                                                        <div style="position: absolute; top: 5px; left: 5px; right: 5px; bottom: 5px; background: white; border-radius: 8px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">TV Screen</h6>
                                                                <p class="small text-muted text-center mb-0">6 frames</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Paper Section -->
                                                <div class="mb-5">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <h5 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1.2rem;">Paper</h5>
                                                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-3">
                                                        <!-- Polaroid Style -->
                                                        <div class="col-4">
                                                            <div class="paper-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                <div class="paper-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="width: 60px; height: 70px; background: white; border-radius: 4px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                                                        <div style="width: 100%; height: 50px; background: #f0f0f0; border-radius: 4px 4px 0 0;"></div>
                                                                        <div style="width: 100%; height: 20px; background: white; border-radius: 0 0 4px 4px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Polaroid</h6>
                                                                <p class="small text-muted text-center mb-0">24 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- Mount Board -->
                                                        <div class="col-4">
                                                            <div class="paper-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                <div class="paper-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="width: 70px; height: 70px; background: #D4AF37; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                                        <div style="width: 50px; height: 50px; background: white; border-radius: 4px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Mount Board</h6>
                                                                <p class="small text-muted text-center mb-0">18 frames</p>
                                                            </div>
                                                        </div>
                                                        <!-- Vintage Paper -->
                                                        <div class="col-4">
                                                            <div class="paper-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                <div class="paper-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="width: 70px; height: 70px; background: #DEB887; border-radius: 8px; transform: rotate(-2deg); box-shadow: 0 4px 8px rgba(0,0,0,0.1);"></div>
                                                                </div>
                                                                <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Vintage Paper</h6>
                                                                <p class="small text-muted text-center mb-0">15 frames</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Trending Section -->
                                                <div class="mb-4">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <h5 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1.2rem;">Trending</h5>
                                                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="trending-grid">
                                                        <!-- Trending Item 1 -->
                                                        <div class="trending-item d-flex align-items-center gap-3 p-3 mb-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                            <div class="trending-number fs-4 fw-bold" style="color: #D4AF37; min-width: 40px;">#1</div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Neon Glow Frame</h6>
                                                                <span class="small text-muted">2.4k+ uses this week</span>
                                                            </div>
                                                            <i class="fas fa-chevron-right" style="color: #3D204E;"></i>
                                                        </div>
                                                        <!-- Trending Item 2 -->
                                                        <div class="trending-item d-flex align-items-center gap-3 p-3 mb-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                            <div class="trending-number fs-4 fw-bold" style="color: #D4AF37; min-width: 40px;">#2</div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Minimal Line Frame</h6>
                                                                <span class="small text-muted">1.8k+ uses this week</span>
                                                            </div>
                                                            <i class="fas fa-chevron-right" style="color: #3D204E;"></i>
                                                        </div>
                                                        <!-- Trending Item 3 -->
                                                        <div class="trending-item d-flex align-items-center gap-3 p-3 mb-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                            <div class="trending-number fs-4 fw-bold" style="color: #D4AF37; min-width: 40px;">#3</div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Vintage Film Border</h6>
                                                                <span class="small text-muted">1.2k+ uses this week</span>
                                                            </div>
                                                            <i class="fas fa-chevron-right" style="color: #3D204E;"></i>
                                                        </div>
                                                        <!-- Trending Item 4 -->
                                                        <div class="trending-item d-flex align-items-center gap-3 p-3" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                            <div class="trending-number fs-4 fw-bold" style="color: #D4AF37; min-width: 40px;">#4</div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Geometric Pattern Frame</h6>
                                                                <span class="small text-muted">956 uses this week</span>
                                                            </div>
                                                            <i class="fas fa-chevron-right" style="color: #3D204E;"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Create Button -->
                                                <div class="mt-5 pt-3">
                                                    <button class="btn w-100 py-3 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-3 create-frame-btn" style="background: linear-gradient(135deg, #3D204E, #5a2e73); color: white; border: none; box-shadow: 0 8px 16px rgba(61,32,78,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'">
                                                        <i class="fa-solid fa-plus-circle fs-5"></i>
                                                        <span class="fs-6">Create Custom Frame</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Grids Detailed View (add this after the Frames detailed view) -->
                                            <div class="grids-detailed-view" id="gridsDetailedView" style="display: none;">
                                                <!-- Back Button and Title -->
                                                <div class="d-flex align-items-center mb-4">
                                                    <button class="btn p-0 me-3 back-to-categories" style="color: #3D204E; border: none; background: transparent; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s ease;" onmouseover="this.style.background='#f3eff7'" onmouseout="this.style.background='transparent'">
                                                        <i class="fas fa-arrow-left fs-5"></i>
                                                    </button>
                                                    <h4 class="fw-bold mb-0" style="color: #3D204E; font-size: 1.8rem;">Grids</h4>
                                                </div>

                                                <!-- Recently Used Section -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">RECENTLY USED</h6>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-2">
                                                        <!-- Design Grid -->
                                                        <div class="col-4">
                                                            <div class="recent-grid-card p-2 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="grid-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 4px; width: 60px; height: 60px;">
                                                                        <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 6px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 6px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                    </div>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Design</span>
                                                            </div>
                                                        </div>
                                                        <!-- Elements Grid -->
                                                        <div class="col-4">
                                                            <div class="recent-grid-card p-2 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="grid-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 3px; width: 60px; height: 60px;">
                                                                        <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                        <div style="background: #2E8B57; border-radius: 4px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 4px;"></div>
                                                                        <div style="background: #FF69B4; border-radius: 4px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                        <div style="background: #2E8B57; border-radius: 4px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 4px;"></div>
                                                                        <div style="background: #FF69B4; border-radius: 4px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                    </div>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Elements</span>
                                                            </div>
                                                        </div>
                                                        <!-- Text Grid -->
                                                        <div class="col-4">
                                                            <div class="recent-grid-card p-2 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="grid-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 5px; width: 60px; height: 60px;">
                                                                        <div style="background: #3D204E; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                                            <span style="color: white; font-size: 12px; font-weight: bold;">A</span>
                                                                        </div>
                                                                        <div style="background: #D4AF37; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                                            <span style="color: white; font-size: 12px; font-weight: bold;">B</span>
                                                                        </div>
                                                                        <div style="background: #D4AF37; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                                            <span style="color: white; font-size: 12px; font-weight: bold;">C</span>
                                                                        </div>
                                                                        <div style="background: #3D204E; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                                            <span style="color: white; font-size: 12px; font-weight: bold;">D</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Text</span>
                                                            </div>
                                                        </div>
                                                        <!-- Uploads Grid -->
                                                        <div class="col-4">
                                                            <div class="recent-grid-card p-2 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="grid-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 4px; width: 60px; height: 60px;">
                                                                        <div style="background: #8B4513; border-radius: 4px;"></div>
                                                                        <div style="background: #2E8B57; border-radius: 4px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 4px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                    </div>
                                                                    <i class="fas fa-cloud-upload-alt" style="position: absolute; color: white; font-size: 12px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);"></i>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Uploads</span>
                                                            </div>
                                                        </div>
                                                        <!-- Tools Grid -->
                                                        <div class="col-4">
                                                            <div class="recent-grid-card p-2 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="grid-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; width: 60px; height: 60px;">
                                                                        <i class="fas fa-crop-alt" style="color: #3D204E; font-size: 20px;"></i>
                                                                        <i class="fas fa-paintbrush" style="color: #D4AF37; font-size: 20px;"></i>
                                                                        <i class="fas fa-eraser" style="color: #D4AF37; font-size: 20px;"></i>
                                                                        <i class="fas fa-magic" style="color: #3D204E; font-size: 20px;"></i>
                                                                    </div>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Tools</span>
                                                            </div>
                                                        </div>
                                                        <!-- Bible Grid -->
                                                        <div class="col-4">
                                                            <div class="recent-grid-card p-2 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="grid-preview mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 3px; width: 60px; height: 60px;">
                                                                        <div style="background: #D4AF37; border-radius: 2px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 2px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 2px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 2px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 2px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 2px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 2px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 2px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 2px;"></div>
                                                                    </div>
                                                                    <i class="fas fa-cross" style="position: absolute; color: white; font-size: 12px;"></i>
                                                                </div>
                                                                <span class="small fw-semibold" style="color: #3D204E;">Bible</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Grid Categories -->
                                                <div class="mb-5">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">GRID CATEGORIES</h6>
                                                    
                                                    <!-- Basic Grids -->
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 0.95rem;">Basic Grids</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-3">
                                                            <!-- 2x2 Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                    <div class="grid-icon mb-3 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; width: 70px; height: 70px;">
                                                                            <div style="background: #3D204E; border-radius: 8px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 8px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 8px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 8px;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">2x2 Grid</h6>
                                                                    <p class="small text-muted mb-0">4 cells</p>
                                                                </div>
                                                            </div>
                                                            <!-- 3x3 Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                    <div class="grid-icon mb-3 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 5px; width: 70px; height: 70px;">
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">3x3 Grid</h6>
                                                                    <p class="small text-muted mb-0">9 cells</p>
                                                                </div>
                                                            </div>
                                                            <!-- 4x4 Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                    <div class="grid-icon mb-3 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; width: 70px; height: 70px;">
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; border-radius: 4px;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">4x4 Grid</h6>
                                                                    <p class="small text-muted mb-0">16 cells</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Layout Grids -->
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 0.95rem;">Layout Grids</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-3">
                                                            <!-- Magazine Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                    <div class="grid-icon mb-3" style="height: 80px; display: grid; grid-template-columns: 1fr 1fr; gap: 5px;">
                                                                        <div style="background: #3D204E; border-radius: 8px; height: 80px;"></div>
                                                                        <div>
                                                                            <div style="background: #3D204E; border-radius: 8px; height: 37px; margin-bottom: 6px;"></div>
                                                                            <div style="background: #D4AF37; border-radius: 8px; height: 37px;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Magazine</h6>
                                                                    <p class="small text-muted text-center mb-0">12 layouts</p>
                                                                </div>
                                                            </div>
                                                            <!-- Gallery Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                    <div class="grid-icon mb-3" style="height: 80px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 4px;">
                                                                        <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 6px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 6px;"></div>
                                                                        <div style="background: #3D204E; border-radius: 6px;"></div>
                                                                        <div style="background: #D4AF37; border-radius: 6px;"></div>
                                                                    </div>
                                                                    <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Gallery</h6>
                                                                    <p class="small text-muted text-center mb-0">18 layouts</p>
                                                                </div>
                                                            </div>
                                                            <!-- Dashboard Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                    <div class="grid-icon mb-3" style="height: 80px;">
                                                                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 5px; height: 100%;">
                                                                            <div style="background: #3D204E; border-radius: 8px;"></div>
                                                                            <div style="display: grid; grid-template-rows: 1fr 1fr; gap: 5px;">
                                                                                <div style="background: #D4AF37; border-radius: 8px;"></div>
                                                                                <div style="background: #D4AF37; border-radius: 8px;"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="fw-semibold text-center mb-1" style="color: #3D204E;">Dashboard</h6>
                                                                    <p class="small text-muted text-center mb-0">9 layouts</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Specialty Grids -->
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 0.95rem;">Specialty Grids</h6>
                                                            <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                            <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                        </div>
                                                        <div class="row g-3">
                                                            <!-- Masonry Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                    <div class="grid-icon mb-3 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 4px; width: 70px;">
                                                                            <div style="background: #3D204E; height: 20px; border-radius: 4px;"></div>
                                                                            <div style="background: #D4AF37; height: 30px; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; height: 25px; border-radius: 4px;"></div>
                                                                            <div style="background: #D4AF37; height: 35px; border-radius: 4px;"></div>
                                                                            <div style="background: #3D204E; height: 20px; border-radius: 4px;"></div>
                                                                            <div style="background: #D4AF37; height: 28px; border-radius: 4px;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">Masonry</h6>
                                                                    <p class="small text-muted mb-0">24 layouts</p>
                                                                </div>
                                                            </div>
                                                            <!-- Golden Ratio Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                    <div class="grid-icon mb-3 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                        <div style="position: relative; width: 70px; height: 70px;">
                                                                            <div style="position: absolute; top: 0; left: 0; width: 43px; height: 43px; background: #3D204E; border-radius: 8px;"></div>
                                                                            <div style="position: absolute; top: 0; right: 0; width: 27px; height: 27px; background: #D4AF37; border-radius: 6px;"></div>
                                                                            <div style="position: absolute; bottom: 0; left: 0; width: 27px; height: 27px; background: #D4AF37; border-radius: 6px;"></div>
                                                                            <div style="position: absolute; bottom: 0; right: 0; width: 43px; height: 43px; background: #3D204E; border-radius: 8px;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">Golden Ratio</h6>
                                                                    <p class="small text-muted mb-0">8 layouts</p>
                                                                </div>
                                                            </div>
                                                            <!-- Spiral Grid -->
                                                            <div class="col-4">
                                                                <div class="grid-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                                    <div class="grid-icon mb-3 d-flex align-items-center justify-content-center" style="height: 80px;">
                                                                        <div style="width: 70px; height: 70px; background: conic-gradient(from 0deg, #3D204E 0deg 90deg, #D4AF37 90deg 180deg, #3D204E 180deg 270deg, #D4AF37 270deg 360deg); border-radius: 50%;"></div>
                                                                    </div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">Spiral</h6>
                                                                    <p class="small text-muted mb-0">12 layouts</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Popular Grid Templates -->
                                                <div class="mb-4">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">POPULAR TEMPLATES</h6>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <div class="template-card p-2 d-flex align-items-center gap-3" style="background: #f8f4fa; border-radius: 18px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #3D204E, #D4AF37); border-radius: 12px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 2px; padding: 2px;">
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                </div>
                                                                <div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">Photo Collage</h6>
                                                                    <span class="small text-muted">2.4k+ uses</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="template-card p-2 d-flex align-items-center gap-3" style="background: #f8f4fa; border-radius: 18px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #2E8B57, #3D204E); border-radius: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 2px; padding: 2px;">
                                                                    <div style="background: white; border-radius: 4px; grid-row: span 2;"></div>
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                </div>
                                                                <div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">Instagram Story</h6>
                                                                    <span class="small text-muted">1.8k+ uses</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="template-card p-2 d-flex align-items-center gap-3" style="background: #f8f4fa; border-radius: 18px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF69B4, #D4AF37); border-radius: 12px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; padding: 2px;">
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                    <div style="background: white; border-radius: 4px;"></div>
                                                                    <div style="background: white; border-radius: 4px; grid-column: span 3;"></div>
                                                                </div>
                                                                <div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">Pinterest Grid</h6>
                                                                    <span class="small text-muted">3.2k+ uses</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="template-card p-2 d-flex align-items-center gap-3" style="background: #f8f4fa; border-radius: 18px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #8B4513, #2E8B57); border-radius: 12px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 2px; padding: 2px;">
                                                                    <div style="background: white; border-radius: 4px; height: 20px;"></div>
                                                                    <div style="background: white; border-radius: 4px; height: 20px;"></div>
                                                                    <div style="background: white; border-radius: 4px; grid-column: span 2; height: 20px;"></div>
                                                                </div>
                                                                <div>
                                                                    <h6 class="fw-semibold mb-1" style="color: #3D204E;">Blog Layout</h6>
                                                                    <span class="small text-muted">1.2k+ uses</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Grid Settings/Quick Apply -->
                                                <div class="mb-4 p-3" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px;">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E;">QUICK GRID SETTINGS</h6>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col-6">
                                                            <label class="small text-muted mb-1">Columns</label>
                                                            <input type="number" class="form-control form-control-sm" value="3" min="1" max="12" style="border-radius: 12px; border: 1px solid #ddd;">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="small text-muted mb-1">Rows</label>
                                                            <input type="number" class="form-control form-control-sm" value="3" min="1" max="12" style="border-radius: 12px; border: 1px solid #ddd;">
                                                        </div>
                                                    </div>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col-6">
                                                            <label class="small text-muted mb-1">Gap Size</label>
                                                            <select class="form-select form-select-sm" style="border-radius: 12px; border: 1px solid #ddd;">
                                                                <option>Small (2px)</option>
                                                                <option selected>Medium (4px)</option>
                                                                <option>Large (8px)</option>
                                                                <option>None</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="small text-muted mb-1">Corner Radius</label>
                                                            <select class="form-select form-select-sm" style="border-radius: 12px; border: 1px solid #ddd;">
                                                                <option>Square</option>
                                                                <option selected>Rounded</option>
                                                                <option>Circle</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button class="btn w-100 py-2 rounded-pill fw-semibold" style="background: #3D204E; color: white; border: none;">
                                                        Apply Grid Settings
                                                    </button>
                                                </div>

                                                <!-- Create Button -->
                                                <div class="mt-4 pt-2">
                                                    <button class="btn w-100 py-3 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-3 create-grid-btn" style="background: linear-gradient(135deg, #3D204E, #5a2e73); color: white; border: none; box-shadow: 0 8px 16px rgba(61,32,78,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'">
                                                        <i class="fa-solid fa-plus-circle fs-5"></i>
                                                        <span class="fs-6">Create Custom Grid</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- 3D Detailed View (add this after the Grids detailed view) -->
                                            <div class="threed-detailed-view" id="threedDetailedView" style="display: none;">
                                                <!-- Back Button and Title -->
                                                <div class="d-flex align-items-center mb-4">
                                                    <button class="btn p-0 me-3 back-to-categories" style="color: #3D204E; border: none; background: transparent; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s ease;" onmouseover="this.style.background='#f3eff7'" onmouseout="this.style.background='transparent'">
                                                        <i class="fas fa-arrow-left fs-5"></i>
                                                    </button>
                                                    <h4 class="fw-bold mb-0" style="color: #3D204E; font-size: 1.8rem;">3D</h4>
                                                </div>

                                                <!-- Search Bar -->
                                                <div class="mb-4">
                                                    <div class="search-box d-flex align-items-center" style="border: 1px solid #e0e0e0; border-radius: 30px; padding: 0.5rem 1.2rem; background: white; box-shadow: 0 2px 8px rgba(61,32,78,0.05);">
                                                        <i class="fas fa-search text-secondary me-2" style="color: #3D204E;"></i>
                                                        <input type="text" placeholder="Search 3D elements, styles, or colors..." class="bg-transparent w-100" style="border: none; outline: none; font-size: 0.95rem;">
                                                    </div>
                                                </div>

                                                <!-- Recently Used Section -->
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="fw-semibold" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">RECENTLY USED</h6>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-2">
                                                        <!-- Recently Used 3D Item 1 -->
                                                        <div class="col-3">
                                                            <div class="recent-3d-card p-2" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="preview-3d mb-2 d-flex align-items-center justify-content-center" style="height: 90px; position: relative;">
                                                                    <!-- 3D Cube -->
                                                                    <div style="width: 50px; height: 50px; position: relative; transform-style: preserve-3d; animation: rotate3d 5s infinite linear;">
                                                                        <div style="position: absolute; width: 50px; height: 50px; background: rgba(61,32,78,0.9); transform: translateZ(25px); border-radius: 8px;"></div>
                                                                        <div style="position: absolute; width: 50px; height: 50px; background: rgba(212,175,55,0.9); transform: rotateY(90deg) translateZ(25px); border-radius: 8px;"></div>
                                                                        <div style="position: absolute; width: 50px; height: 50px; background: rgba(46,139,87,0.9); transform: rotateX(90deg) translateZ(25px); border-radius: 8px;"></div>
                                                                    </div>
                                                                </div>
                                                                <span class="small fw-semibold d-block text-center" style="color: #3D204E;">3D Cube</span>
                                                            </div>
                                                        </div>
                                                        <!-- Recently Used 3D Item 2 -->
                                                        <div class="col-3">
                                                            <div class="recent-3d-card p-2" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="preview-3d mb-2 d-flex align-items-center justify-content-center" style="height: 90px;">
                                                                    <!-- 3D Sphere -->
                                                                    <div style="width: 50px; height: 50px; background: radial-gradient(circle at 30% 30%, #D4AF37, #3D204E); border-radius: 50%; box-shadow: 0 10px 20px rgba(0,0,0,0.2);"></div>
                                                                </div>
                                                                <span class="small fw-semibold d-block text-center" style="color: #3D204E;">3D Sphere</span>
                                                            </div>
                                                        </div>
                                                        <!-- Recently Used 3D Item 3 -->
                                                        <div class="col-3">
                                                            <div class="recent-3d-card p-2" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="preview-3d mb-2 d-flex align-items-center justify-content-center" style="height: 90px;">
                                                                    <!-- 3D Cylinder -->
                                                                    <div style="width: 40px; height: 60px; background: linear-gradient(90deg, #3D204E, #D4AF37, #3D204E); border-radius: 50% / 20%; box-shadow: 0 10px 20px rgba(0,0,0,0.2);"></div>
                                                                </div>
                                                                <span class="small fw-semibold d-block text-center" style="color: #3D204E;">3D Cylinder</span>
                                                            </div>
                                                        </div>
                                                        <!-- Recently Used 3D Item 4 -->
                                                        <div class="col-3">
                                                            <div class="recent-3d-card p-2" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 20px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 8px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 8px rgba(61,32,78,0.08)'">
                                                                <div class="preview-3d mb-2 d-flex align-items-center justify-content-center" style="height: 90px;">
                                                                    <!-- 3D Pyramid -->
                                                                    <div style="width: 0; height: 0; border-left: 30px solid transparent; border-right: 30px solid transparent; border-bottom: 50px solid #D4AF37; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.2));"></div>
                                                                </div>
                                                                <span class="small fw-semibold d-block text-center" style="color: #3D204E;">3D Pyramid</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Characters & Emoji Section -->
                                                <div class="mb-5">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <h5 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1.2rem;">Characters & Emoji</h5>
                                                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-3">
                                                        <!-- 3D Character 1 - Smiley Face -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 70px; height: 70px; background: radial-gradient(circle at 30% 30%, #FFD700, #D4AF37); border-radius: 50%; position: relative; box-shadow: 0 10px 20px rgba(212,175,55,0.3);">
                                                                        <div style="position: absolute; top: 20px; left: 15px; width: 10px; height: 10px; background: #3D204E; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; top: 20px; right: 15px; width: 10px; height: 10px; background: #3D204E; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; bottom: 20px; left: 20px; right: 20px; height: 8px; background: #3D204E; border-radius: 20px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Smiley Face</h6>
                                                                <p class="small text-muted mb-0">24 styles</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Character 2 - Heart Eyes -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 70px; height: 70px; background: radial-gradient(circle at 30% 30%, #FF6B6B, #FF4444); border-radius: 50%; position: relative; box-shadow: 0 10px 20px rgba(255,68,68,0.3);">
                                                                        <div style="position: absolute; top: 20px; left: 15px; color: #3D204E;">❤️</div>
                                                                        <div style="position: absolute; top: 20px; right: 15px; color: #3D204E;">❤️</div>
                                                                        <div style="position: absolute; bottom: 20px; left: 25px; right: 25px; height: 8px; background: #3D204E; border-radius: 20px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Heart Eyes</h6>
                                                                <p class="small text-muted mb-0">18 styles</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Character 3 - Cool Face -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 70px; height: 70px; background: radial-gradient(circle at 30% 30%, #3D204E, #5a2e73); border-radius: 50%; position: relative; box-shadow: 0 10px 20px rgba(61,32,78,0.3);">
                                                                        <div style="position: absolute; top: 20px; left: 15px; width: 10px; height: 10px; background: #D4AF37; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; top: 20px; right: 15px; width: 10px; height: 10px; background: #D4AF37; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; bottom: 15px; left: 20px; right: 20px; border: 3px solid #D4AF37; border-top: none; height: 15px; border-radius: 0 0 20px 20px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Cool Face</h6>
                                                                <p class="small text-muted mb-0">15 styles</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Character 4 - Star Eyes -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(61,32,78,0.08);" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 12px rgba(61,32,78,0.08)'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 70px; height: 70px; background: radial-gradient(circle at 30% 30%, #2E8B57, #1E5C3B); border-radius: 50%; position: relative; box-shadow: 0 10px 20px rgba(46,139,87,0.3);">
                                                                        <div style="position: absolute; top: 15px; left: 10px; color: #D4AF37;">⭐</div>
                                                                        <div style="position: absolute; top: 15px; right: 10px; color: #D4AF37;">⭐</div>
                                                                        <div style="position: absolute; bottom: 20px; left: 25px; right: 25px; height: 8px; background: #D4AF37; border-radius: 20px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Star Eyes</h6>
                                                                <p class="small text-muted mb-0">12 styles</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Food & Lifestyle Section -->
                                                <div class="mb-5">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <h5 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1.2rem;">Food & Lifestyle</h5>
                                                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-3">
                                                        <!-- 3D Burger -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative; width: 70px; height: 70px;">
                                                                        <div style="position: absolute; top: 0; left: 10px; right: 10px; height: 15px; background: #DEB887; border-radius: 20px 20px 0 0;"></div>
                                                                        <div style="position: absolute; top: 10px; left: 5px; right: 5px; height: 20px; background: #2E8B57; border-radius: 4px;"></div>
                                                                        <div style="position: absolute; top: 25px; left: 0; right: 0; height: 15px; background: #FF6B6B; border-radius: 4px;"></div>
                                                                        <div style="position: absolute; top: 35px; left: 5px; right: 5px; height: 20px; background: #DEB887; border-radius: 0 0 20px 20px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">3D Burger</h6>
                                                                <p class="small text-muted mb-0">32 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Coffee Cup -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative;">
                                                                        <div style="width: 50px; height: 60px; background: #8B4513; border-radius: 0 0 20px 20px;"></div>
                                                                        <div style="position: absolute; top: 10px; right: -10px; width: 15px; height: 30px; background: #D4AF37; border-radius: 20px;"></div>
                                                                        <div style="position: absolute; top: 5px; left: 10px; right: 10px; height: 5px; background: white; border-radius: 4px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Coffee Cup</h6>
                                                                <p class="small text-muted mb-0">24 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Donut -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 60px; height: 60px; background: #DEB887; border-radius: 50%; position: relative;">
                                                                        <div style="position: absolute; top: 15px; left: 15px; right: 15px; bottom: 15px; background: #FF69B4; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; top: 5px; left: 20px; width: 10px; height: 10px; background: white; border-radius: 50%;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">3D Donut</h6>
                                                                <p class="small text-muted mb-0">18 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Pizza Slice -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 0; height: 0; border-left: 30px solid transparent; border-right: 30px solid transparent; border-bottom: 60px solid #DEB887; position: relative;">
                                                                        <div style="position: absolute; top: 20px; left: -15px; width: 10px; height: 10px; background: #FF6B6B; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; top: 30px; left: -5px; width: 10px; height: 10px; background: #2E8B57; border-radius: 50%;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Pizza Slice</h6>
                                                                <p class="small text-muted mb-0">21 items</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Creative & Abstract Section -->
                                                <div class="mb-5">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <h5 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1.2rem;">Creative & Abstract</h5>
                                                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-3">
                                                        <!-- Geometric Shapes -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="display: flex; gap: 5px; flex-wrap: wrap; width: 70px;">
                                                                        <div style="width: 30px; height: 30px; background: #3D204E; border-radius: 8px; transform: rotate(15deg);"></div>
                                                                        <div style="width: 30px; height: 30px; background: #D4AF37; border-radius: 50%;"></div>
                                                                        <div style="width: 30px; height: 30px; background: #2E8B57; clip-path: polygon(50% 0%, 0% 100%, 100% 100%);"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Geometric</h6>
                                                                <p class="small text-muted mb-0">45 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- Fluid Shapes -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #FF69B4, #D4AF37); border-radius: 60% 40% 70% 30% / 40% 60% 30% 70%; animation: morph 5s infinite ease-in-out;"></div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Fluid Shapes</h6>
                                                                <p class="small text-muted mb-0">28 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- Crystal Forms -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative;">
                                                                        <div style="width: 0; height: 0; border-left: 25px solid transparent; border-right: 25px solid transparent; border-bottom: 50px solid #3D204E; opacity: 0.8;"></div>
                                                                        <div style="width: 0; height: 0; border-left: 20px solid transparent; border-right: 20px solid transparent; border-top: 40px solid #D4AF37; position: absolute; top: 10px; left: -20px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Crystal Forms</h6>
                                                                <p class="small text-muted mb-0">19 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- Abstract Waves -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="display: flex; gap: 3px; align-items: flex-end; height: 60px;">
                                                                        <div style="width: 12px; height: 30px; background: #3D204E; border-radius: 20px;"></div>
                                                                        <div style="width: 12px; height: 50px; background: #D4AF37; border-radius: 20px;"></div>
                                                                        <div style="width: 12px; height: 20px; background: #2E8B57; border-radius: 20px;"></div>
                                                                        <div style="width: 12px; height: 45px; background: #FF69B4; border-radius: 20px;"></div>
                                                                        <div style="width: 12px; height: 35px; background: #3D204E; border-radius: 20px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">Abstract Waves</h6>
                                                                <p class="small text-muted mb-0">23 items</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Animals & Nature Section -->
                                                <div class="mb-5">
                                                    <div class="d-flex align-items-center gap-3 mb-3">
                                                        <h5 class="fw-semibold mb-0" style="color: #3D204E; font-size: 1.2rem;">Animals & Nature</h5>
                                                        <div style="flex: 1; height: 2px; background: linear-gradient(90deg, #3D204E 0%, rgba(61,32,78,0.1) 100%);"></div>
                                                        <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All →</a>
                                                    </div>
                                                    <div class="row g-3">
                                                        <!-- 3D Lion -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative;">
                                                                        <div style="width: 50px; height: 50px; background: #D4AF37; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; top: -10px; left: 0; width: 20px; height: 20px; background: #D4AF37; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; top: -10px; right: 0; width: 20px; height: 20px; background: #D4AF37; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; bottom: 10px; left: 10px; width: 6px; height: 6px; background: #3D204E; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; bottom: 10px; right: 10px; width: 6px; height: 6px; background: #3D204E; border-radius: 50%;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">3D Lion</h6>
                                                                <p class="small text-muted mb-0">15 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Elephant -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative;">
                                                                        <div style="width: 60px; height: 50px; background: #8B4513; border-radius: 50% 50% 30% 30%;"></div>
                                                                        <div style="position: absolute; top: 10px; left: -5px; width: 20px; height: 30px; background: #8B4513; border-radius: 40%;"></div>
                                                                        <div style="position: absolute; top: 10px; right: -5px; width: 20px; height: 30px; background: #8B4513; border-radius: 40%;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">3D Elephant</h6>
                                                                <p class="small text-muted mb-0">12 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Tree -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative;">
                                                                        <div style="width: 20px; height: 40px; background: #8B4513; margin: 0 auto;"></div>
                                                                        <div style="width: 50px; height: 40px; background: #2E8B57; border-radius: 50% 50% 0 0; position: absolute; top: -20px; left: -15px;"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">3D Tree</h6>
                                                                <p class="small text-muted mb-0">28 items</p>
                                                            </div>
                                                        </div>
                                                        <!-- 3D Butterfly -->
                                                        <div class="col-3">
                                                            <div class="threed-category-card p-3 text-center" style="background: linear-gradient(145deg, #f8f4fa, #ede4f3); border-radius: 24px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px) scale(1.02)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.15)'" onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='none'">
                                                                <div class="threed-icon mb-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                                                    <div style="position: relative;">
                                                                        <div style="width: 20px; height: 40px; background: #FF69B4; border-radius: 50%;"></div>
                                                                        <div style="position: absolute; top: 5px; left: -20px; width: 30px; height: 30px; background: #D4AF37; border-radius: 50% 0 50% 0; transform: rotate(-45deg);"></div>
                                                                        <div style="position: absolute; top: 5px; right: -20px; width: 30px; height: 30px; background: #D4AF37; border-radius: 0 50% 0 50%; transform: rotate(45deg);"></div>
                                                                    </div>
                                                                </div>
                                                                <h6 class="fw-semibold mb-1" style="color: #3D204E;">3D Butterfly</h6>
                                                                <p class="small text-muted mb-0">19 items</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Popular 3D Styles -->
                                                <div class="mb-4">
                                                    <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem; letter-spacing: 0.5px;">POPULAR 3D STYLES</h6>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <span class="style-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">Isometric</span>
                                                        <span class="style-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">Clay</span>
                                                        <span class="style-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">Glassmorphism</span>
                                                        <span class="style-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">Neon</span>
                                                        <span class="style-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">Metallic</span>
                                                        <span class="style-chip px-4 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.9rem; transition: all 0.2s ease;" onmouseover="this.style.background='#3D204E'; this.style.color='white'" onmouseout="this.style.background='#f8f4fa'; this.style.color='#3D204E'">Soft</span>
                                                    </div>
                                                </div>

                                                <!-- Add Animation Keyframes -->
                                                <style>
                                                    @keyframes rotate3d {
                                                        0% { transform: rotateX(0deg) rotateY(0deg); }
                                                        100% { transform: rotateX(360deg) rotateY(360deg); }
                                                    }
                                                    @keyframes morph {
                                                        0% { border-radius: 60% 40% 70% 30% / 40% 60% 30% 70%; }
                                                        50% { border-radius: 40% 60% 30% 70% / 60% 40% 70% 30%; }
                                                        100% { border-radius: 60% 40% 70% 30% / 40% 60% 30% 70%; }
                                                    }
                                                </style>

                                                <!-- Create Button -->
                                                <div class="mt-5 pt-3">
                                                    <button class="btn w-100 py-3 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-3 create-threed-btn" style="background: linear-gradient(135deg, #3D204E, #5a2e73); color: white; border: none; box-shadow: 0 8px 16px rgba(61,32,78,0.2); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(61,32,78,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(61,32,78,0.2)'">
                                                        <i class="fa-solid fa-plus-circle fs-5"></i>
                                                        <span class="fs-6">Create 3D Element</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Add Text Tab Content - Replace the empty addtext-content tab-pane -->
                                    <div class="tab-pane fade" id="addtext-content" role="tabpanel" aria-labelledby="add-text-tab">
                                        <div class="add-text-container">
                                            <!-- Search Fonts -->
                                            <div class="mb-4">
                                                <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem;">Search Fonts And Combinations</h6>
                                                <div class="search-box-mini d-flex align-items-center" style="border: 1px solid #ddd; border-radius: 30px; padding: 0.5rem 1rem; background: white;">
                                                    <i class="fas fa-search text-secondary me-2" style="font-size: 0.9rem;"></i>
                                                    <input type="text" placeholder="Search fonts..." class="bg-transparent w-100" style="border: none; outline: none; font-size: 0.9rem;">
                                                </div>
                                            </div>

                                            <!-- Add A Text Box Button -->
                                            <div class="mb-3">
                                                <button class="btn w-100 py-3 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-2" style="background: #3D204E; color: #f3eff7;" onclick="addTextBox()">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Add A Text Box</span>
                                                </button>
                                            </div>

                                            <!-- Font Combinations Section -->
                                            <div class="mb-4">
                                                <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem;">Default Text Styles</h6>
                                                
                                                <!-- Font Combination Grid -->
                                                <div class="row g-2">
                                                    <!-- Happy BIRTHDAY -->
                                                    <div class="col-6">
                                                        <div class="font-combo-card p-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="text-center">
                                                                <div style="font-family: 'Abel', sans-serif; line-height: 1.2;">
                                                                    <span style="font-size: 1.2rem; font-weight: 300; color: #3D204E;">Heading</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- quick WIN -->
                                                    <div class="col-6">
                                                        <div class="font-combo-card p-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="text-center">
                                                                <div style="font-family: 'Abel', sans-serif; line-height: 1.2;">
                                                                    <span style="font-size: 1.2rem; font-weight: 300; color: #3D204E;">Subheading</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- TECH STACK -->
                                                    <div class="col-6">
                                                        <div class="font-combo-card p-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="text-center">
                                                                <div style="font-family: 'Abel', sans-serif; line-height: 1.2;">
                                                                    <span style="font-size: 1.2rem; font-weight: 300; color: #3D204E;">Body</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Font Combinations Section -->
                                            <div class="mb-4">
                                                <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem;">Font Combination</h6>
                                                
                                                <!-- Font Combination Grid -->
                                                <div class="row g-2">
                                                    <!-- Happy BIRTHDAY -->
                                                    <div class="col-6">
                                                        <div class="font-combo-card p-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="text-center">
                                                                <div style="font-family: 'Abel', sans-serif; line-height: 1.2;">
                                                                    <span style="font-size: 1.2rem; font-weight: 300; color: #3D204E;">Happy</span>
                                                                    <br>
                                                                    <span style="font-size: 1.5rem; font-weight: 700; color: #3D204E; letter-spacing: 1px;">BIRTHDAY</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- quick WIN -->
                                                    <div class="col-6">
                                                        <div class="font-combo-card p-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="text-center">
                                                                <div style="font-family: 'Abel', sans-serif; line-height: 1.2;">
                                                                    <span style="font-size: 1.2rem; font-weight: 300; color: #3D204E;">quick</span>
                                                                    <br>
                                                                    <span style="font-size: 1.8rem; font-weight: 800; color: #3D204E; text-transform: uppercase;">WIN</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- TECH STACK -->
                                                    <div class="col-6">
                                                        <div class="font-combo-card p-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="text-center">
                                                                <div style="font-family: 'Abel', sans-serif; line-height: 1.2;">
                                                                    <span style="font-size: 1.8rem; font-weight: 700; color: #3D204E; letter-spacing: 2px;">TECH</span>
                                                                    <br>
                                                                    <span style="font-size: 1.2rem; font-weight: 300; color: #3D204E;">STACK</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- new PROJECT -->
                                                    <div class="col-6">
                                                        <div class="font-combo-card p-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="text-center">
                                                                <div style="font-family: 'Abel', sans-serif; line-height: 1.2;">
                                                                    <span style="font-size: 1.2rem; font-weight: 300; color: #3D204E;">new</span>
                                                                    <br>
                                                                    <span style="font-size: 1.8rem; font-weight: 700; color: #3D204E; text-transform: uppercase;">PROJECT</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Hoster BRAND -->
                                                    <div class="col-6">
                                                        <div class="font-combo-card p-2" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'">
                                                            <div class="text-center">
                                                                <div style="font-family: 'Abel', sans-serif; line-height: 1.2;">
                                                                    <span style="font-size: 1.5rem; font-weight: 700; color: #3D204E;">Hoster</span>
                                                                    <br>
                                                                    <span style="font-size: 1.2rem; font-weight: 300; color: #3D204E;">BRAND</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Upload Tab Content - Replace the empty upload-content tab-pane -->
                                    <div class="tab-pane fade" id="upload-content" role="tabpanel" aria-labelledby="upload-tab">
                                        <div class="uploads-container">
                                            <!-- Search Keywords, Tags, Color -->
                                            <div class="mb-4">
                                                <h6 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1rem;">Search Keywords, Tags, Color</h6>
                                                <div class="search-box-mini d-flex align-items-center" style="border: 1px solid #ddd; border-radius: 30px; padding: 0.5rem 1rem; background: white;">
                                                    <i class="fas fa-search text-secondary me-2" style="font-size: 0.9rem;"></i>
                                                    <input type="text" placeholder="Search uploads..." class="bg-transparent w-100" style="border: none; outline: none; font-size: 0.9rem;">
                                                </div>
                                            </div>

                                            <!-- Upload Files Button -->
                                            <div class="mb-4">
                                                <button class="btn w-100 py-3 rounded-pill fw-semibold d-flex align-items-center justify-content-center gap-2" style="background: #3D204E; color: white; border: none;" onclick="uploadFiles()">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <span>Upload Files</span>
                                                </button>
                                            </div>


                                            <div class="mb-4">
                                                <ul class="nav nav-tabs" id="uploadTab" role="tablist" style="border-bottom: 1px solid #dee2e6;">
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link active" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="true" style="color: #3D204E; font-weight: 600; border: none; background: transparent;">
                                                            Images
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button class="nav-link" id="folders-tab" data-bs-toggle="tab" data-bs-target="#folders" type="button" role="tab" aria-controls="folders" aria-selected="false" style="color: #999; font-weight: 500; border: none; background: transparent;">
                                                            Folders
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Tab Content -->
                                            <div class="tab-content py-2" id="uploadTabContent">
                                                <!-- Images Tab Pane -->
                                                <div class="tab-pane fade show active" id="images" role="tabpanel" aria-labelledby="images-tab">
                                                    <div class="row">
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-1.png" class="w-100" alt="">
                                                        </div>
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-2.png" class="w-100" alt="">
                                                        </div>
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-3.png" class="w-100" alt="">
                                                        </div>
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-4.png" class="w-100" alt="">
                                                        </div>
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-5.png" class="w-100" alt="">
                                                        </div>
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-6.png" class="w-100" alt="">
                                                        </div>
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-7.png" class="w-100" alt="">
                                                        </div>
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-8.png" class="w-100" alt="">
                                                        </div>
                                                        <div class="col-4 mb-3 p-3">
                                                            <img src="<?=base_url();?>images/template-9.png" class="w-100" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Folders Tab Pane -->
                                                <div class="tab-pane fade" id="folders" role="tabpanel" aria-labelledby="folders-tab">
                                                    <div class="upload-item-card mb-3 p-3 d-flex align-items-center gap-3" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                        <div class="upload-item-preview d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #3D204E; border-radius: 12px; overflow: hidden;">
                                                            <i class="fas fa-folder fs-1 text-white"></i>
                                                        </div>
                                                        <div class="upload-item-details flex-grow-1">
                                                            <h6 class="fw-semibold mb-1" style="color: #3D204E; font-size: 1rem;">Crypto Graphics</h6>
                                                            <p class="small text-muted mb-0" style="font-size: 0.85rem;">12 items</p>
                                                        </div>
                                                        <div class="upload-item-actions">
                                                            <i class="fas fa-chevron-right text-secondary"></i>
                                                        </div>
                                                    </div>

                                                    <div class="upload-item-card mb-3 p-3 d-flex align-items-center gap-3" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                        <div class="upload-item-preview d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #D4AF37; border-radius: 12px; overflow: hidden;">
                                                            <i class="fas fa-folder fs-1 text-white"></i>
                                                        </div>
                                                        <div class="upload-item-details flex-grow-1">
                                                            <h6 class="fw-semibold mb-1" style="color: #3D204E; font-size: 1rem;">Faith Based</h6>
                                                            <p class="small text-muted mb-0" style="font-size: 0.85rem;">24 items</p>
                                                        </div>
                                                        <div class="upload-item-actions">
                                                            <i class="fas fa-chevron-right text-secondary"></i>
                                                        </div>
                                                    </div>

                                                    <div class="upload-item-card mb-3 p-3 d-flex align-items-center gap-3" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateX(5px)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateX(0)'">
                                                        <div class="upload-item-preview d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: #2E8B57; border-radius: 12px; overflow: hidden;">
                                                            <i class="fas fa-folder fs-1 text-white"></i>
                                                        </div>
                                                        <div class="upload-item-details flex-grow-1">
                                                            <h6 class="fw-semibold mb-1" style="color: #3D204E; font-size: 1rem;">Bible Verses</h6>
                                                            <p class="small text-muted mb-0" style="font-size: 0.85rem;">8 items</p>
                                                        </div>
                                                        <div class="upload-item-actions">
                                                            <i class="fas fa-chevron-right text-secondary"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tools Tab Content - Replace the empty tools-content tab-pane -->
                                    <div class="tab-pane fade" id="tools-content" role="tabpanel" aria-labelledby="tools-tab">
                                        <div class="tools-container">
                                            <!-- Tools Header -->
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h5 class="fw-semibold mb-0" style="color: #3D204E;">Tools</h5>
                                                <a href="#" class="text-decoration-none small" style="color: #3D204E;">See All</a>
                                            </div>

                                            <!-- Tools Grid -->
                                            <div class="row g-3">
                                                <!-- Crop Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-crop-alt fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Crop</span>
                                                    </div>
                                                </div>

                                                <!-- Resize Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-expand-alt fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Resize</span>
                                                    </div>
                                                </div>

                                                <!-- Rotate Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-undo-alt fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Rotate</span>
                                                    </div>
                                                </div>

                                                <!-- Flip Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-arrows-alt-h fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Flip</span>
                                                    </div>
                                                </div>

                                                <!-- Adjust Colors Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-palette fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Adjust Colors</span>
                                                    </div>
                                                </div>

                                                <!-- Filters Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-filter fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Filters</span>
                                                    </div>
                                                </div>

                                                <!-- Layers Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-layer-group fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Layers</span>
                                                    </div>
                                                </div>

                                                <!-- Opacity Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-circle fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Opacity</span>
                                                    </div>
                                                </div>

                                                <!-- Blur Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-tint fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Blur</span>
                                                    </div>
                                                </div>

                                                <!-- Sharpen Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-eye fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Sharpen</span>
                                                    </div>
                                                </div>

                                                <!-- Background Remover Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-eraser fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Remove BG</span>
                                                    </div>
                                                </div>

                                                <!-- Text Tool -->
                                                <div class="col-6">
                                                    <div class="tool-card p-3 text-center" style="background: #f8f4fa; border-radius: 16px; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 6px 16px rgba(61,32,78,0.15)'" onmouseout="this.style.background='#f8f4fa'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="tool-icon mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px;">
                                                            <i class="fas fa-font fs-1" style="color: #3D204E;"></i>
                                                        </div>
                                                        <span class="fw-semibold" style="color: #3D204E; font-size: 1rem;">Text</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Recent Tools Section -->
                                            <div class="mt-4">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="fw-semibold mb-0" style="color: #3D204E; font-size: 0.95rem;">Recently Used</h6>
                                                    <a href="#" class="text-decoration-none small" style="color: #3D204E;">Clear</a>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <span class="recent-tool-chip px-3 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.85rem; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                        <i class="fas fa-crop-alt me-1"></i> Crop
                                                    </span>
                                                    <span class="recent-tool-chip px-3 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.85rem; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                        <i class="fas fa-filter me-1"></i> Filters
                                                    </span>
                                                    <span class="recent-tool-chip px-3 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.85rem; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                        <i class="fas fa-eraser me-1"></i> Remove BG
                                                    </span>
                                                    <span class="recent-tool-chip px-3 py-2 rounded-pill" style="background: #f8f4fa; color: #3D204E; cursor: pointer; font-size: 0.85rem; transition: all 0.2s ease;" onmouseover="this.style.background='#ede4f3'" onmouseout="this.style.background='#f8f4fa'">
                                                        <i class="fas fa-font me-1"></i> Text
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Bible Tab Content - Replace the empty bible-content tab-pane -->
                                    <div class="tab-pane fade" id="bible-content" role="tabpanel" aria-labelledby="bible-tab">
                                        <div class="bible-container">
                                            <!-- Bible Header with Book Selection -->
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="fw-semibold mb-0" style="color: #3D204E;">Bible</h5>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" style="background: #f3eff7; color: #3D204E; border: none; border-radius: 30px; padding: 0.3rem 1rem;">
                                                        Genesis
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" style="max-height: 300px; overflow-y: auto;">
                                                        <li><a class="dropdown-item" href="#">Genesis</a></li>
                                                        <li><a class="dropdown-item" href="#">Exodus</a></li>
                                                        <li><a class="dropdown-item" href="#">Leviticus</a></li>
                                                        <li><a class="dropdown-item" href="#">Numbers</a></li>
                                                        <li><a class="dropdown-item" href="#">Deuteronomy</a></li>
                                                        <li><a class="dropdown-item" href="#">Joshua</a></li>
                                                        <li><a class="dropdown-item" href="#">Judges</a></li>
                                                        <li><a class="dropdown-item" href="#">Ruth</a></li>
                                                        <li><a class="dropdown-item" href="#">1 Samuel</a></li>
                                                        <li><a class="dropdown-item" href="#">2 Samuel</a></li>
                                                        <li><a class="dropdown-item" href="#">1 Kings</a></li>
                                                        <li><a class="dropdown-item" href="#">2 Kings</a></li>
                                                        <li><a class="dropdown-item" href="#">1 Chronicles</a></li>
                                                        <li><a class="dropdown-item" href="#">2 Chronicles</a></li>
                                                        <li><a class="dropdown-item" href="#">Ezra</a></li>
                                                        <li><a class="dropdown-item" href="#">Nehemiah</a></li>
                                                        <li><a class="dropdown-item" href="#">Esther</a></li>
                                                        <li><a class="dropdown-item" href="#">Job</a></li>
                                                        <li><a class="dropdown-item" href="#">Psalms</a></li>
                                                        <li><a class="dropdown-item" href="#">Proverbs</a></li>
                                                        <li><a class="dropdown-item" href="#">Ecclesiastes</a></li>
                                                        <li><a class="dropdown-item" href="#">Song of Solomon</a></li>
                                                        <li><a class="dropdown-item" href="#">Isaiah</a></li>
                                                        <li><a class="dropdown-item" href="#">Jeremiah</a></li>
                                                        <li><a class="dropdown-item" href="#">Lamentations</a></li>
                                                        <li><a class="dropdown-item" href="#">Ezekiel</a></li>
                                                        <li><a class="dropdown-item" href="#">Daniel</a></li>
                                                        <li><a class="dropdown-item" href="#">Hosea</a></li>
                                                        <li><a class="dropdown-item" href="#">Joel</a></li>
                                                        <li><a class="dropdown-item" href="#">Amos</a></li>
                                                        <li><a class="dropdown-item" href="#">Obadiah</a></li>
                                                        <li><a class="dropdown-item" href="#">Jonah</a></li>
                                                        <li><a class="dropdown-item" href="#">Micah</a></li>
                                                        <li><a class="dropdown-item" href="#">Nahum</a></li>
                                                        <li><a class="dropdown-item" href="#">Habakkuk</a></li>
                                                        <li><a class="dropdown-item" href="#">Zephaniah</a></li>
                                                        <li><a class="dropdown-item" href="#">Haggai</a></li>
                                                        <li><a class="dropdown-item" href="#">Zechariah</a></li>
                                                        <li><a class="dropdown-item" href="#">Malachi</a></li>
                                                        <li><a class="dropdown-item" href="#">Matthew</a></li>
                                                        <li><a class="dropdown-item" href="#">Mark</a></li>
                                                        <li><a class="dropdown-item" href="#">Luke</a></li>
                                                        <li><a class="dropdown-item" href="#">John</a></li>
                                                        <li><a class="dropdown-item" href="#">Acts</a></li>
                                                        <li><a class="dropdown-item" href="#">Romans</a></li>
                                                        <li><a class="dropdown-item" href="#">1 Corinthians</a></li>
                                                        <li><a class="dropdown-item" href="#">2 Corinthians</a></li>
                                                        <li><a class="dropdown-item" href="#">Galatians</a></li>
                                                        <li><a class="dropdown-item" href="#">Ephesians</a></li>
                                                        <li><a class="dropdown-item" href="#">Philippians</a></li>
                                                        <li><a class="dropdown-item" href="#">Colossians</a></li>
                                                        <li><a class="dropdown-item" href="#">1 Thessalonians</a></li>
                                                        <li><a class="dropdown-item" href="#">2 Thessalonians</a></li>
                                                        <li><a class="dropdown-item" href="#">1 Timothy</a></li>
                                                        <li><a class="dropdown-item" href="#">2 Timothy</a></li>
                                                        <li><a class="dropdown-item" href="#">Titus</a></li>
                                                        <li><a class="dropdown-item" href="#">Philemon</a></li>
                                                        <li><a class="dropdown-item" href="#">Hebrews</a></li>
                                                        <li><a class="dropdown-item" href="#">James</a></li>
                                                        <li><a class="dropdown-item" href="#">1 Peter</a></li>
                                                        <li><a class="dropdown-item" href="#">2 Peter</a></li>
                                                        <li><a class="dropdown-item" href="#">1 John</a></li>
                                                        <li><a class="dropdown-item" href="#">2 John</a></li>
                                                        <li><a class="dropdown-item" href="#">3 John</a></li>
                                                        <li><a class="dropdown-item" href="#">Jude</a></li>
                                                        <li><a class="dropdown-item" href="#">Revelation</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Chapter Navigation -->
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <button class="btn btn-sm d-flex align-items-center gap-1" style="background: #f3eff7; color: #3D204E; border: none; border-radius: 30px; padding: 0.3rem 1rem;" onclick="previousChapter()">
                                                    <i class="fas fa-chevron-left"></i> Prev
                                                </button>
                                                <span class="fw-semibold" style="color: #3D204E;">Chapter 1</span>
                                                <button class="btn btn-sm d-flex align-items-center gap-1" style="background: #f3eff7; color: #3D204E; border: none; border-radius: 30px; padding: 0.3rem 1rem;" onclick="nextChapter()">
                                                    Next <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>

                                            <!-- Bible Content -->
                                            <div class="bible-content p-3" style="background: #f8f4fa; border-radius: 20px; max-height: 400px; overflow-y: auto;">
                                                <!-- GENESIS 1 - Main Title -->
                                                <h1 class="text-center fw-bold mb-2" style="color: #3D204E; font-size: 2.5rem; letter-spacing: 2px;">GENESIS 1</h1>
                                                
                                                <!-- GENESIS Subtitle -->
                                                <h2 class="text-center fw-semibold mb-3" style="color: #3D204E; font-size: 1.5rem;">GENESIS</h2>
                                                
                                                <!-- The Creation of the World - Subheading -->
                                                <h3 class="fw-semibold mb-3" style="color: #3D204E; font-size: 1.2rem;">The Creation of the World</h3>
                                                
                                                <!-- Bible Verses -->
                                                <div class="bible-verses">
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">1</span> In the beginning, God created the heavens and the earth. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">2</span> The earth was without form and void, and darkness was over the face of the deep. And the Spirit of God was hovering over the face of the waters.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">3</span> And God said, “Let there be light,” and there was light. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">4</span> And God saw that the light was good. And God separated the light from the darkness. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">5</span> God called the light Day, and the darkness he called Night. And there was evening and there was morning, the first day.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">6</span> And God said, “Let there be an expanse in the midst of the waters, and let it separate the waters from the waters.” 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">7</span> And God made the expanse and separated the waters that were under the expanse from the waters that were above the expanse. And it was so. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">8</span> And God called the expanse Heaven. And there was evening and there was morning, the second day.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">9</span> And God said, “Let the waters under the heavens be gathered together into one place, and let the dry land appear.” And it was so. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">10</span> God called the dry land Earth, and the waters that were gathered together he called Seas. And God saw that it was good.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">11</span> And God said, “Let the earth sprout vegetation, plants yielding seed, and fruit trees bearing fruit in which is their seed, each according to its kind, on the earth.” And it was so. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">12</span> The earth brought forth vegetation, plants yielding seed according to their own kinds, and trees bearing fruit in which is their seed, each according to its kind. And God saw that it was good. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">13</span> And there was evening and there was morning, the third day.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">14</span> And God said, “Let there be lights in the expanse of the heavens to separate the day from the night. And let them be for signs and for seasons, and for days and years, 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">15</span> and let them be lights in the expanse of the heavens to give light upon the earth.” And it was so. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">16</span> And God made the two great lights—the greater light to rule the day and the lesser light to rule the night—and the stars. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">17</span> And God set them in the expanse of the heavens to give light on the earth, 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">18</span> to rule over the day and over the night, and to separate the light from the darkness. And God saw that it was good. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">19</span> And there was evening and there was morning, the fourth day.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">20</span> And God said, “Let the waters swarm with swarms of living creatures, and let birds fly above the earth across the expanse of the heavens.” 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">21</span> So God created the great sea creatures and every living creature that moves, with which the waters swarm, according to their kinds, and every winged bird according to its kind. And God saw that it was good. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">22</span> And God blessed them, saying, “Be fruitful and multiply and fill the waters in the seas, and let birds multiply on the earth.” 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">23</span> And there was evening and there was morning, the fifth day.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">24</span> And God said, “Let the earth bring forth living creatures according to their kinds—livestock and creeping things and beasts of the earth according to their kinds.” And it was so. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">25</span> And God made the beasts of the earth according to their kinds and the livestock according to their kinds, and everything that creeps on the ground according to its kind. And God saw that it was good.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">26</span> Then God said, “Let us make man in our image, after our likeness. And let them have dominion over the fish of the sea and over the birds of the heavens and over the livestock and over all the earth and over every creeping thing that creeps on the earth.”
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">27</span> So God created man in his own image, in the image of God he created him; male and female he created them.
                                                    </p>
                                                    
                                                    <p class="mb-2" style="color: #333; line-height: 1.7;">
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">28</span> And God blessed them. And God said to them, “Be fruitful and multiply and fill the earth and subdue it, and have dominion over the fish of the sea and over the birds of the heavens and over every living thing that moves on the earth.” 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">29</span> And God said, “Behold, I have given you every plant yielding seed that is on the face of all the earth, and every tree with seed in its fruit. You shall have them for food. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">30</span> And to every beast of the earth and to every bird of the heavens and to everything that creeps on the earth, everything that has the breath of life, I have given every green plant for food.” And it was so. 
                                                        <span class="verse-number fw-bold me-1" style="color: #3D204E;">31</span> And God saw everything that he had made, and behold, it was very good. And there was evening and there was morning, the sixth day.
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="d-flex gap-2 mt-3">
                                                <button class="btn flex-grow-1 py-2 rounded-pill d-flex align-items-center justify-content-center gap-2" style="background: #3D204E; color: white; border: none;" onclick="addToDesign()">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Add to Design</span>
                                                </button>
                                                <button class="btn flex-grow-1 py-2 rounded-pill d-flex align-items-center justify-content-center gap-2" style="background: transparent; border: 2px solid #3D204E; color: #3D204E;" onclick="copyVerse()">
                                                    <i class="fas fa-copy"></i>
                                                    <span>Copy</span>
                                                </button>
                                            </div>

                                            <!-- Chapter Selection -->
                                            <div class="chapter-grid mt-3 p-2" style="background: #f8f4fa; border-radius: 16px;">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="small fw-semibold" style="color: #3D204E;">Quick Chapters</span>
                                                    <span class="small text-muted">Genesis</span>
                                                </div>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(1)">1</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(2)">2</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(3)">3</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(4)">4</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(5)">5</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(6)">6</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(7)">7</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(8)">8</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(9)">9</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(10)">10</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(11)">11</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(12)">12</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(13)">13</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(14)">14</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(15)">15</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(16)">16</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(17)">17</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(18)">18</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(19)">19</button>
                                                    <button class="btn btn-sm chapter-btn" style="width: 35px; height: 35px; background: white; color: #3D204E; border: 1px solid #ddd; border-radius: 8px;" onclick="selectChapter(20)">20</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                        <!-- Create New Tab Content -->
                                    <div class="tab-pane fade" id="create-new-content" role="tabpanel" aria-labelledby="create-new-tab">
                                        <div class="create-new-container d-flex flex-column" style="height: 100%; position: relative;">
                                            <!-- Sticky Header -->
                                            <h5 class="fw-semibold mb-4 py-2" style="color: #3D204E; position: sticky; top: 0; background: white; z-index: 20; margin-top: -8px;">Create New Design</h5>
                                            
                                            <!-- Scrollable Content Area -->
                                            <div style="flex: 1; overflow-y: auto; padding-right: 5px;">
                                                <div class="row g-4">
                                                    <div class="col-lg-4">
                                                        <!-- Custom Size Form - Block layout -->
                                                        <div class="custom-size-form">
                                                            <div class="mb-4">
                                                                <label class="form-label fw-medium d-block" style="color: #3D204E; font-size: 0.9rem;">Width</label>
                                                                <input type="number" class="form-control d-block w-100" placeholder="Enter width" style="border-radius: 12px; border: 1px solid #ddd; padding: 0.6rem 1rem;">
                                                            </div>
                                                            
                                                            <div class="mb-4">
                                                                <label class="form-label fw-medium d-block" style="color: #3D204E; font-size: 0.9rem;">Height</label>
                                                                <input type="number" class="form-control d-block w-100" placeholder="Enter height" style="border-radius: 12px; border: 1px solid #ddd; padding: 0.6rem 1rem;">
                                                            </div>
                                                            
                                                            <div class="mb-4">
                                                                <label class="form-label fw-medium d-block" style="color: #3D204E; font-size: 0.9rem;">Units</label>
                                                                <select class="form-select d-block w-100" style="border-radius: 12px; border: 1px solid #ddd; padding: 0.6rem 1rem;">
                                                                    <option selected>Pixels (px)</option>
                                                                    <option>Inches (in)</option>
                                                                    <option>Centimeters (cm)</option>
                                                                    <option>Millimeters (mm)</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="mt-5">
                                                                <button class="btn w-100 py-3 rounded-pill fw-semibold d-block" style="background: #3D204E; color: white; border: none;">
                                                                    Create New Design
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Right Column - Scrollable Template Cards -->
                                                    <div class="col-lg-8" style="height: 100%;">
                                                        <div class="row py-2" style="max-height: 500px; overflow-y: auto; padding-right: 10px;">
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="template-card p-3 py-5 d-flex align-items-center">
                                                                    <div class="template-img me-3 flex-shrink-0">
                                                                        <img src="<?=base_url();?>images/front-mug.png" width="80" alt="">
                                                                    </div>
                                                                    <h5 class="fw-semibold mb-0" style="color: #3D204E;">Vision Board</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Image Area - Main Product Display - fixed height -->
                            <div class="main-image-area" style="background: #EEEEEE; padding: 16px; width: 55%; height: 600px; position: relative; overflow: hidden;">
                                <div class="d-flex flex-column h-100">
                                    <!-- Centered image that takes all space - unaffected by buttons -->
                                    <div class="d-flex align-items-center justify-content-center h-100 w-100">
                                        <img src="<?=base_url();?>images/template-1.png" alt="White Glossy Mug" class="img-fluid" style="max-width: 80%; max-height: 95%; object-fit: contain;" onerror="this.src='https://placehold.co/400x400/3D204E/white?text=Mug'">
                                    </div>
                                    <div class="col-12 text-center mt-5">
                                        <a href="#products" class="btn px-5 py-2 rounded-pill text-white fs-5" style="background: #3D204E; display: inline-block;">Add To Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="instagram-products py-5">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-6">
                        <h2 class="display-6 fw-bold mb-4" style="color: #3D204E;">Check Out Our Products On Instagram</h2>
                    </div>
                </div>

                <div class="row g-3 mb-5">
                    <div class="col-6 col-md-3">
                        <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                            <img src="<?=base_url();?>images/instagram-product-1.png" alt="Product 1" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                            <img src="<?=base_url();?>images/instagram-product-2.png" alt="Product 2" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                            <img src="<?=base_url();?>images/instagram-product-3.png" alt="Product 3" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="position-relative overflow-hidden rounded-4 shadow-sm hover-effect" style="aspect-ratio: 1/1;">
                            <img src="<?=base_url();?>images/instagram-product-4.png" alt="Product 4" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 w-100 h-100 overlay" style="background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.5) 100%);"></div>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <i class="bi bi-instagram text-white fs-2 p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5); width: 60px; height: 60px;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?= $this->include('templates/footer'); ?>
        <script src="<?=base_url();?>js/designer-app-customize-template.js"></script>
<script src="<?= base_url('js/customize-design.js') ?>"></script>