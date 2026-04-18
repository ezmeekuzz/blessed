<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/authenticate', 'LoginController::authenticate');
$routes->get('/logout', 'LogoutController::index');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/insert', 'RegisterController::insert');
$routes->get('/verify-email', 'RegisterController::verifyEmail/$1');
$routes->get('/verification-sent', function() {
    $data = [
        'title' => 'Verification Email Sent',
        'message' => 'Please check your email inbox and click the verification link to complete your registration.',
        'type' => 'success',
        'activeMenu' => 'home'
    ];
    return view('pages/verification_status', $data);
});
$routes->get('/about-us', 'AboutUsController::index');
$routes->get('/contact-us', 'ContactUsController::index');
$routes->get('/faq', 'FAQController::index');
$routes->get('/privacy-policy', 'PrivacyPolicyController::index');
$routes->get('/how-to', 'HowToController::index');
$routes->get('/thank-you', 'ThankYouController::index');
$routes->get('/products', 'ProductsController::index');
$routes->get('/blogs', 'BlogsController::index');
$routes->get('/blog-details', 'BlogDetailsController::index');
$routes->get('/check-out', 'CheckOutController::index');
$routes->get('/payment', 'PaymentController::index');
$routes->get('/product-details', 'ProductDetailsController::index');

//Admin Routes
$routes->get('/admin/login', 'Admin\LoginController::index');
$routes->post('/admin/login/authenticate', 'Admin\LoginController::authenticate');
$routes->get('/admin/logout', 'Admin\LogoutController::index');
$routes->get('/admin/dashboard', 'Admin\DashboardController::index');
$routes->get('/admin/blog-categories', 'Admin\BlogCategoriesController::index');
$routes->post('/admin/blogcategories/getData', 'Admin\BlogCategoriesController::getData');
$routes->post('/admin/blogcategories/insert', 'Admin\BlogCategoriesController::insert');
$routes->delete('/admin/blogcategories/delete/(:num)', 'Admin\BlogCategoriesController::delete/$1');
$routes->post('/admin/blogcategories/update/(:num)', 'Admin\BlogCategoriesController::update/$1');
$routes->get('/admin/blogcategories/getCategory/(:num)', 'Admin\BlogCategoriesController::getCategory/$1');
$routes->get('/admin/add-blog', 'Admin\AddBlogController::index');
$routes->post('/admin/addblog/insert', 'Admin\AddBlogController::insert');
$routes->get('/admin/addblog/categoryList', 'Admin\AddBlogController::categoryList');
$routes->get('/admin/blog-masterlist', 'Admin\BlogMasterlistController::index');
$routes->post('/admin/blogmasterlist/getData', 'Admin\BlogMasterlistController::getData');
$routes->get('/admin/blogmasterlist/getBlog/(:num)', 'Admin\BlogMasterlistController::getBlog/$1');
$routes->post('/admin/blogmasterlist/update/(:num)', 'Admin\BlogMasterlistController::update/$1');
$routes->delete('/admin/blogmasterlist/delete/(:num)', 'Admin\BlogMasterlistController::delete/$1');
$routes->post('/admin/blogmasterlist/updateStatus/(:num)', 'Admin\BlogMasterlistController::updateStatus/$1');
$routes->get('/admin/blogmasterlist/getCategories', 'Admin\BlogMasterlistController::getCategories');
$routes->get('/admin/blogmasterlist/getBlog/(:num)', 'Admin\BlogMasterlistController::getBlog/$1');
$routes->get('/admin/edit-blog/(:num)', 'Admin\EditBlogController::index/$1');
$routes->post('/admin/editblog/update/(:num)', 'Admin\EditBlogController::update/$1');
$routes->get('/admin/editblog/getCategories', 'Admin\EditBlogController::getCategories');
$routes->get('/admin/product-categories', 'Admin\ProductCategoriesController::index');
$routes->post('/admin/productcategories/getData', 'Admin\ProductCategoriesController::getData');
$routes->post('/admin/productcategories/insert', 'Admin\ProductCategoriesController::insert');
$routes->delete('/admin/productcategories/delete/(:num)', 'Admin\ProductCategoriesController::delete/$1');
$routes->post('/admin/productcategories/update/(:num)', 'Admin\ProductCategoriesController::update/$1');
$routes->get('/admin/productcategories/getCategory/(:num)', 'Admin\ProductCategoriesController::getCategory/$1');
// Admin Product Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('add-product', 'AddProductController::index');
    $routes->post('add-product/store', 'AddProductController::store');
    $routes->post('add-product/upload-temp', 'AddProductController::uploadTempImage');
    $routes->post('add-product/upload-color-image', 'AddProductController::uploadColorImage');
    $routes->get('add-product/categories', 'AddProductController::getCategories');
    $routes->post('add-product/delete-temp-image', 'AddProductController::deleteTempImage');
    $routes->get('edit-product/(:num)', 'EditProductController::index/$1');
    $routes->post('edit-product/update/(:num)', 'EditProductController::update/$1');
});
// Product Masterlist Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('product-masterlist', 'ProductMasterlistController::index');
    $routes->post('productmasterlist/getData', 'ProductMasterlistController::getData');
    $routes->get('productmasterlist/getProduct/(:num)', 'ProductMasterlistController::getProduct/$1');
    $routes->delete('productmasterlist/delete/(:num)', 'ProductMasterlistController::delete/$1');
    $routes->post('productmasterlist/toggleFeatured/(:num)', 'ProductMasterlistController::toggleFeatured/$1');
});
// Add Font Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('add-font', 'AddFontController::index');
    $routes->post('addfont/insert', 'AddFontController::insert');
});
// Font Masterlist Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('font-masterlist', 'FontMasterlistController::index');
    $routes->post('fontmasterlist/getData', 'FontMasterlistController::getData');
    $routes->get('fontmasterlist/getFont/(:num)', 'FontMasterlistController::getFont/$1');
    $routes->delete('fontmasterlist/delete/(:num)', 'FontMasterlistController::delete/$1');
    $routes->post('fontmasterlist/toggleFeatured/(:num)', 'FontMasterlistController::toggleFeatured/$1');
    $routes->get('fontmasterlist/download/(:any)', 'FontMasterlistController::download/$1');
});
// Edit Font Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('edit-font/(:num)', 'EditFontController::index/$1');
    $routes->post('editfont/update/(:num)', 'EditFontController::update/$1');
});
// Add Templates Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('add-template', 'AddTemplateController::index');
    $routes->post('addtemplate/insert', 'AddTemplateController::insert');
});
// Templates Masterlist Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('templates-masterlist', 'TemplatesMasterlistController::index');
    $routes->post('templatesmasterlist/getData', 'TemplatesMasterlistController::getData');
    $routes->get('templatesmasterlist/getTemplate/(:num)', 'TemplatesMasterlistController::getTemplate/$1');
    $routes->delete('templatesmasterlist/delete/(:num)', 'TemplatesMasterlistController::delete/$1');
    $routes->post('templatesmasterlist/toggleFeatured/(:num)', 'TemplatesMasterlistController::toggleFeatured/$1');
});
// Edit Template Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('edit-template/(:num)', 'EditTemplateController::index/$1');
    $routes->post('edit-template/update/(:num)', 'EditTemplateController::update/$1');
    $routes->get('edit-template/getTemplateData/(:num)', 'EditTemplateController::getTemplateData/$1');
});
// Add Clipart and Icons Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('add-clipart', 'AddClipArtController::index');
    $routes->post('add-clipart/store', 'AddClipArtController::store');
});

// Clipart Masterlist Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('clipart-masterlist', 'ClipArtMasterlistController::index');
    $routes->post('clipartmasterlist/getData', 'ClipArtMasterlistController::getData');
    $routes->post('clipartmasterlist/getTrashData', 'ClipArtMasterlistController::getTrashData');
    $routes->get('clipartmasterlist/getTrashCount', 'ClipArtMasterlistController::getTrashCount'); // New route
    $routes->get('clipartmasterlist/getClipArt/(:num)', 'ClipArtMasterlistController::getClipArt/$1');
    $routes->post('clipartmasterlist/toggleStatus/(:num)', 'ClipArtMasterlistController::toggleStatus/$1');
    $routes->delete('clipartmasterlist/softDelete/(:num)', 'ClipArtMasterlistController::softDelete/$1');
    $routes->post('clipartmasterlist/restore/(:num)', 'ClipArtMasterlistController::restore/$1');
    $routes->delete('clipartmasterlist/forceDelete/(:num)', 'ClipArtMasterlistController::forceDelete/$1');
});

// Edit Clipart Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('edit-clipart/(:num)', 'EditClipArtController::index/$1');
    $routes->post('edit-clipart/update/(:num)', 'EditClipArtController::update/$1');
});
// Add Sticker Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('add-sticker', 'AddStickerController::index');
    $routes->post('add-sticker/store', 'AddStickerController::store');
});
// Sticker Masterlist Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('sticker-masterlist', 'StickerMasterlistController::index');
    $routes->post('stickermasterlist/getData', 'StickerMasterlistController::getData');
    $routes->post('stickermasterlist/getTrashData', 'StickerMasterlistController::getTrashData');
    $routes->get('stickermasterlist/getTrashCount', 'StickerMasterlistController::getTrashCount');
    $routes->get('stickermasterlist/getSticker/(:num)', 'StickerMasterlistController::getSticker/$1');
    $routes->post('stickermasterlist/toggleStatus/(:num)', 'StickerMasterlistController::toggleStatus/$1');
    $routes->delete('stickermasterlist/softDelete/(:num)', 'StickerMasterlistController::softDelete/$1');
    $routes->post('stickermasterlist/restore/(:num)', 'StickerMasterlistController::restore/$1');
    $routes->delete('stickermasterlist/forceDelete/(:num)', 'StickerMasterlistController::forceDelete/$1');
    
    $routes->get('edit-sticker/(:num)', 'EditStickerController::index/$1');
    $routes->post('edit-sticker/update/(:num)', 'EditStickerController::update/$1');
});
// Edit Sticker Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('edit-sticker/(:num)', 'EditStickerController::index/$1');
    $routes->post('edit-sticker/update/(:num)', 'EditStickerController::update/$1');
});

//Add Customer Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('add-customer', 'AddCustomerController::index');
    $routes->post('add-customer/store', 'AddCustomerController::store');
});

//Customer Masterlist Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('customer-masterlist', 'CustomerMasterlistController::index');
    $routes->post('customermasterlist/getData', 'CustomerMasterlistController::getData');
    $routes->get('customermasterlist/getCustomer/(:num)', 'CustomerMasterlistController::getCustomer/$1');
    $routes->post('customermasterlist/toggleStatus/(:num)', 'CustomerMasterlistController::toggleStatus/$1');
    $routes->post('customermasterlist/toggleEmailVerification/(:num)', 'CustomerMasterlistController::toggleEmailVerification/$1');
    $routes->delete('customermasterlist/delete/(:num)', 'CustomerMasterlistController::delete/$1');
});

//Edit Customer Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('edit-customer/(:num)', 'EditCustomerController::index/$1');
    $routes->post('edit-customer/update/(:num)', 'EditCustomerController::update/$1');
});

// Newsletter Subscribers Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('subscribers-masterlist', 'SubscribersMasterlistController::index');
    $routes->post('subscribersmasterlist/getData', 'SubscribersMasterlistController::getData');
    $routes->get('subscribersmasterlist/getSubscriber/(:num)', 'SubscribersMasterlistController::getSubscriber/$1');
    $routes->post('subscribersmasterlist/updateStatus/(:num)', 'SubscribersMasterlistController::updateStatus/$1');
    $routes->delete('subscribersmasterlist/delete/(:num)', 'SubscribersMasterlistController::delete/$1');
    $routes->get('subscribersmasterlist/export', 'SubscribersMasterlistController::export');
});

// Contact Messages Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('messages', 'MessagesController::index');
    $routes->post('messages/getData', 'MessagesController::getData');
    $routes->get('messages/getMessage/(:num)', 'MessagesController::getMessage/$1');
    $routes->post('messages/reply/(:num)', 'MessagesController::reply/$1');
    $routes->delete('messages/delete/(:num)', 'MessagesController::delete/$1');
    $routes->post('messages/bulkMarkRead', 'MessagesController::bulkMarkRead');
    $routes->post('messages/bulkDelete', 'MessagesController::bulkDelete');
});

// Send Newsletter Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('send-newsletter', 'SendNewsletterController::index');
    $routes->get('send-newsletter/stats', 'SendNewsletterController::getStats');
    $routes->get('send-newsletter/subscribers', 'SendNewsletterController::getSubscribers');
    $routes->post('send-newsletter/recipient-count', 'SendNewsletterController::getRecipientCount');
    $routes->post('send-newsletter/send', 'SendNewsletterController::send');
    $routes->post('send-newsletter/saveDraft', 'SendNewsletterController::saveDraft');
    $routes->get('send-newsletter/getCampaign/(:num)', 'SendNewsletterController::getCampaign/$1');
    $routes->get('send-newsletter/campaigns', 'SendNewsletterController::getCampaigns');
    $routes->post('send-newsletter/cancel/(:num)', 'SendNewsletterController::cancel/$1');
    $routes->delete('send-newsletter/delete/(:num)', 'SendNewsletterController::delete/$1');
});

// Email Templates Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('email-templates', 'EmailTemplatesController::index');
    $routes->get('email-templates/list', 'EmailTemplatesController::getList');
    $routes->get('email-templates/get/(:num)', 'EmailTemplatesController::getTemplate/$1');
    $routes->post('email-templates/save', 'EmailTemplatesController::save');
    $routes->delete('email-templates/delete/(:num)', 'EmailTemplatesController::delete/$1');
    $routes->post('email-templates/toggleStatus/(:num)', 'EmailTemplatesController::toggleStatus/$1');
    $routes->post('email-templates/duplicate/(:num)', 'EmailTemplatesController::duplicate/$1');
    $routes->get('email-templates/stats', 'EmailTemplatesController::getStats');
    $routes->post('email-templates/incrementUsage/(:num)', 'EmailTemplatesController::incrementUsage/$1');
});