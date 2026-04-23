<?= $this->include('templates/header'); ?>

<style>
/* Orders Page CSS */
.orders-section {
    background: #f0f2f5;
    min-height: calc(100vh - 200px);
    padding: 40px 0;
}

/* Page Header */
.page-header {
    margin-bottom: 30px;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.page-subtitle {
    color: #65676b;
    font-size: 14px;
}

/* Stats Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.2s ease;
    margin-bottom: 24px;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: #f0e9f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}

.stat-icon i {
    font-size: 24px;
    color: #3D204E;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 13px;
    color: #65676b;
}

/* Tabs */
.orders-tabs {
    background: white;
    border-radius: 16px;
    margin-bottom: 24px;
    overflow: hidden;
}

.tab-btn {
    flex: 1;
    text-align: center;
    padding: 14px 20px;
    background: white;
    border: none;
    font-weight: 600;
    color: #65676b;
    transition: all 0.2s ease;
    position: relative;
    cursor: pointer;
}

.tab-btn:hover {
    color: #3D204E;
    background: #f8f9fa;
}

.tab-btn.active {
    color: #3D204E;
}

.tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #3D204E;
}

/* Order Card */
.order-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    transition: all 0.2s ease;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.order-header {
    padding: 16px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #e4e6eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.order-info {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
}

.order-info-item {
    font-size: 13px;
}

.order-info-label {
    color: #65676b;
    margin-right: 8px;
}

.order-info-value {
    font-weight: 600;
    color: #1a1a2e;
}

.order-status {
    padding: 4px 12px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
}

.status-delivered {
    background: #28a74520;
    color: #28a745;
    border: 1px solid #28a74540;
}

.status-processing {
    background: #ffc10720;
    color: #856404;
    border: 1px solid #ffc10740;
}

.status-shipped {
    background: #17a2b820;
    color: #17a2b8;
    border: 1px solid #17a2b840;
}

.status-pending {
    background: #fd7e1420;
    color: #fd7e14;
    border: 1px solid #fd7e1440;
}

.status-cancelled {
    background: #dc354520;
    color: #dc3545;
    border: 1px solid #dc354540;
}

.order-body {
    padding: 20px;
}

.order-product {
    display: flex;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid #f0f2f5;
}

.order-product:last-child {
    border-bottom: none;
}

.product-image {
    width: 70px;
    height: 70px;
    background: #f8f9fa;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image i {
    font-size: 30px;
    color: #3D204E;
}

.product-details {
    flex: 1;
}

.product-name {
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 4px;
}

.product-sku {
    font-size: 12px;
    color: #65676b;
    margin-bottom: 4px;
}

.product-price {
    font-size: 14px;
    font-weight: 600;
    color: #3D204E;
}

.product-quantity {
    font-size: 13px;
    color: #65676b;
}

.order-footer {
    padding: 16px 20px;
    background: #f8f9fa;
    border-top: 1px solid #e4e6eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.order-total {
    font-size: 14px;
}

.order-total-label {
    color: #65676b;
    margin-right: 8px;
}

.order-total-value {
    font-size: 18px;
    font-weight: 700;
    color: #3D204E;
}

.order-actions {
    display: flex;
    gap: 10px;
}

.btn-sm-custom {
    padding: 6px 16px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.btn-outline-order {
    background: transparent;
    border: 1px solid #3D204E;
    color: #3D204E;
}

.btn-outline-order:hover {
    background: #3D204E;
    color: white;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
}

.empty-icon {
    font-size: 80px;
    color: #e4e6eb;
    margin-bottom: 20px;
}

.empty-title {
    font-size: 20px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.empty-text {
    color: #65676b;
    margin-bottom: 24px;
}

/* Loading State */
.loading-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 16px;
}

.spinner-custom {
    width: 50px;
    height: 50px;
    border: 3px solid #f0f2f5;
    border-top-color: #3D204E;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .orders-section {
        padding: 20px 0;
    }
    
    .page-title {
        font-size: 24px;
    }
    
    .order-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .order-info {
        flex-direction: column;
        gap: 8px;
    }
    
    .order-footer {
        flex-direction: column;
        align-items: stretch;
    }
    
    .order-actions {
        justify-content: center;
    }
    
    .stat-value {
        font-size: 22px;
    }
    
    .tab-btn {
        padding: 10px 12px;
        font-size: 12px;
    }
}
</style>

<section class="orders-section">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">My Orders</h1>
            <p class="page-subtitle">Track and manage your orders</p>
        </div>

        <!-- Stats Row -->
        <div class="row" id="statsRow">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-value" id="totalOrders">0</div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value" id="pendingOrders">0</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="stat-value" id="shippedOrders">0</div>
                    <div class="stat-label">Shipped</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value" id="deliveredOrders">0</div>
                    <div class="stat-label">Delivered</div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="orders-tabs">
            <div class="d-flex">
                <button class="tab-btn active" data-status="all">All Orders</button>
                <button class="tab-btn" data-status="pending">Pending</button>
                <button class="tab-btn" data-status="processing">Processing</button>
                <button class="tab-btn" data-status="shipped">Shipped</button>
                <button class="tab-btn" data-status="delivered">Delivered</button>
                <button class="tab-btn" data-status="cancelled">Cancelled</button>
            </div>
        </div>

        <!-- Orders List -->
        <div id="ordersList">
            <!-- Loading State -->
            <div class="loading-state">
                <div class="spinner-custom"></div>
                <p>Loading your orders...</p>
            </div>
        </div>
    </div>
</section>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header" style="border-bottom: 1px solid #e4e6eb; padding: 20px 24px;">
                <h5 class="modal-title fw-bold" style="color: #1a1a2e;">
                    <i class="fas fa-receipt me-2" style="color: #3D204E;"></i> Order Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="orderDetailsContent">
                <!-- Dynamic content will be loaded here -->
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e4e6eb; padding: 16px 24px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer'); ?>

<script>
$(document).ready(function() {
    let currentStatus = 'all';
    
    // Load orders on page load
    loadOrders();
    
    // Tab switching
    $('.tab-btn').on('click', function() {
        currentStatus = $(this).data('status');
        $('.tab-btn').removeClass('active');
        $(this).addClass('active');
        loadOrders();
    });
    
    // Load orders function
    function loadOrders() {
        $('#ordersList').html(`
            <div class="loading-state">
                <div class="spinner-custom"></div>
                <p>Loading your orders...</p>
            </div>
        `);
        
        // Simulate API call - Replace with actual AJAX call to your backend
        setTimeout(function() {
            displayOrders(currentStatus);
        }, 800);
    }
    
    // Display orders (Sample data - Replace with actual data from database)
    function displayOrders(status) {
        // Sample order data - This should come from your database
        const allOrders = [
            {
                id: 'ORD-2024-001',
                date: '2024-01-15',
                status: 'delivered',
                items: [
                    { name: 'Custom Bible Cover', sku: 'CBC-001', price: 45.99, quantity: 1, image: 'bible-cover' },
                    { name: 'Faith Journal', sku: 'FJ-002', price: 24.99, quantity: 2, image: 'journal' }
                ],
                total: 95.97,
                shipping: 5.99,
                tax: 8.50
            },
            {
                id: 'ORD-2024-002',
                date: '2024-02-20',
                status: 'shipped',
                items: [
                    { name: 'Scripture Mug', sku: 'SM-003', price: 19.99, quantity: 3, image: 'mug' },
                    { name: 'Prayer Shawl', sku: 'PS-004', price: 34.99, quantity: 1, image: 'shawl' }
                ],
                total: 94.96,
                shipping: 4.99,
                tax: 8.00
            },
            {
                id: 'ORD-2024-003',
                date: '2024-03-10',
                status: 'processing',
                items: [
                    { name: 'Cross Necklace', sku: 'CN-005', price: 29.99, quantity: 1, image: 'necklace' },
                    { name: 'Devotional Book', sku: 'DB-006', price: 18.99, quantity: 1, image: 'book' }
                ],
                total: 48.98,
                shipping: 3.99,
                tax: 4.50
            },
            {
                id: 'ORD-2024-004',
                date: '2024-03-25',
                status: 'pending',
                items: [
                    { name: 'Wall Art - Psalm 23', sku: 'WA-007', price: 39.99, quantity: 1, image: 'wall-art' }
                ],
                total: 39.99,
                shipping: 5.99,
                tax: 3.50
            }
        ];
        
        // Filter orders by status
        let filteredOrders = allOrders;
        if (status !== 'all') {
            filteredOrders = allOrders.filter(order => order.status === status);
        }
        
        // Update stats
        updateStats(allOrders);
        
        // Display orders
        if (filteredOrders.length === 0) {
            $('#ordersList').html(`
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3 class="empty-title">No orders found</h3>
                    <p class="empty-text">You haven't placed any orders yet.</p>
                    <a href="/shop" class="btn btn-primary-custom">Start Shopping</a>
                </div>
            `);
            return;
        }
        
        let ordersHtml = '';
        filteredOrders.forEach(order => {
            const orderDate = new Date(order.date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            const statusClass = getStatusClass(order.status);
            const statusText = order.status.charAt(0).toUpperCase() + order.status.slice(1);
            
            ordersHtml += `
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-info-item">
                                <span class="order-info-label">Order #:</span>
                                <span class="order-info-value">${order.id}</span>
                            </div>
                            <div class="order-info-item">
                                <span class="order-info-label">Date:</span>
                                <span class="order-info-value">${orderDate}</span>
                            </div>
                            <div class="order-info-item">
                                <span class="order-info-label">Items:</span>
                                <span class="order-info-value">${order.items.length}</span>
                            </div>
                        </div>
                        <div>
                            <span class="order-status ${statusClass}">${statusText}</span>
                        </div>
                    </div>
                    <div class="order-body">
            `;
            
            order.items.forEach(item => {
                ordersHtml += `
                    <div class="order-product">
                        <div class="product-image">
                            <i class="fas fa-${item.image}"></i>
                        </div>
                        <div class="product-details">
                            <div class="product-name">${item.name}</div>
                            <div class="product-sku">SKU: ${item.sku}</div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="product-price">$${item.price.toFixed(2)}</div>
                                <div class="product-quantity">Qty: ${item.quantity}</div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            ordersHtml += `
                    </div>
                    <div class="order-footer">
                        <div class="order-total">
                            <span class="order-total-label">Total Amount:</span>
                            <span class="order-total-value">$${order.total.toFixed(2)}</span>
                        </div>
                        <div class="order-actions">
                            <button class="btn btn-sm-custom btn-outline-order view-order-btn" data-order='${JSON.stringify(order)}'>
                                <i class="fas fa-eye me-1"></i> View Details
                            </button>
                            ${order.status === 'pending' ? '<button class="btn btn-sm-custom btn-outline-order cancel-order-btn" data-order-id="' + order.id + '"><i class="fas fa-times me-1"></i> Cancel</button>' : ''}
                            ${order.status === 'delivered' ? '<button class="btn btn-sm-custom btn-outline-order"><i class="fas fa-star me-1"></i> Write Review</button>' : ''}
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#ordersList').html(ordersHtml);
        
        // View order details
        $('.view-order-btn').on('click', function() {
            const order = $(this).data('order');
            showOrderDetails(order);
        });
        
        // Cancel order
        $('.cancel-order-btn').on('click', function() {
            const orderId = $(this).data('order-id');
            Swal.fire({
                title: 'Cancel Order?',
                text: 'Are you sure you want to cancel this order?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    showNotification('Order has been cancelled.', 'success');
                    loadOrders();
                }
            });
        });
    }
    
    // Update statistics
    function updateStats(orders) {
        const total = orders.length;
        const pending = orders.filter(o => o.status === 'pending').length;
        const shipped = orders.filter(o => o.status === 'shipped').length;
        const delivered = orders.filter(o => o.status === 'delivered').length;
        
        $('#totalOrders').text(total);
        $('#pendingOrders').text(pending);
        $('#shippedOrders').text(shipped);
        $('#deliveredOrders').text(delivered);
    }
    
    // Get status class
    function getStatusClass(status) {
        switch(status) {
            case 'delivered': return 'status-delivered';
            case 'shipped': return 'status-shipped';
            case 'processing': return 'status-processing';
            case 'pending': return 'status-pending';
            case 'cancelled': return 'status-cancelled';
            default: return 'status-pending';
        }
    }
    
    // Show order details modal
    function showOrderDetails(order) {
        const orderDate = new Date(order.date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        let itemsHtml = '';
        order.items.forEach(item => {
            itemsHtml += `
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="product-image" style="width: 50px; height: 50px;">
                                <i class="fas fa-${item.image}"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">${item.name}</div>
                                <div class="small text-muted">SKU: ${item.sku}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">$${item.price.toFixed(2)}</td>
                    <td class="text-center">${item.quantity}</td>
                    <td class="text-end fw-semibold">$${(item.price * item.quantity).toFixed(2)}</td>
                </tr>
            `;
        });
        
        const modalContent = `
            <div class="mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="small text-muted mb-1">Order Number</div>
                            <div class="fw-bold">${order.id}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="small text-muted mb-1">Order Date</div>
                            <div class="fw-bold">${orderDate}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="small text-muted mb-1">Order Status</div>
                            <div><span class="order-status ${getStatusClass(order.status)}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3" style="background: #f8f9fa; border-radius: 12px;">
                            <div class="small text-muted mb-1">Payment Method</div>
                            <div class="fw-bold">Credit Card / PayPal</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h6 class="fw-bold mb-3">Order Items</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${itemsHtml}
                    </tbody>
                    <tfoot style="border-top: 2px solid #e4e6eb;">
                        <tr>
                            <td colspan="3" class="text-end fw-semibold">Subtotal:</td>
                            <td class="text-end">$${order.total.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end text-muted">Shipping:</td>
                            <td class="text-end text-muted">$${order.shipping.toFixed(2)}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end text-muted">Tax:</td>
                            <td class="text-end text-muted">$${order.tax.toFixed(2)}</td>
                        </tr>
                        <tr style="border-top: 1px solid #e4e6eb;">
                            <td colspan="3" class="text-end fw-bold fs-5">Total:</td>
                            <td class="text-end fw-bold fs-5" style="color: #3D204E;">$${(order.total + order.shipping + order.tax).toFixed(2)}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        `;
        
        $('#orderDetailsContent').html(modalContent);
        $('#orderDetailsModal').modal('show');
    }
    
    // Notification function
    function showNotification(message, type) {
        $('.notification-toast').remove();
        const toast = $('<div class="notification-toast" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; min-width: 250px; padding: 12px 20px; border-radius: 10px; color: white; font-weight: 500; display: none;"></div>');
        const bgColor = type === 'success' ? '#28a745' : '#dc3545';
        toast.css('background', bgColor);
        toast.text(message);
        $('body').append(toast);
        toast.fadeIn(300);
        setTimeout(() => toast.fadeOut(300, () => toast.remove()), 5000);
    }
});
</script>