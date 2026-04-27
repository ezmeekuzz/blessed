<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend Routes
$routes->get('/', 'HomeController::index');
$routes->get('/home', 'HomeController::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/authenticate', 'LoginController::authenticate');
$routes->get('/logout', 'LogoutController::index');
$routes->get('/register', 'RegisterController::index');
$routes->post('/register/insert', 'RegisterController::insert');
$routes->get('/verify-email/(:any)', 'RegisterController::verifyEmail/$1');
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
$routes->post('/contact/submit', 'ContactUsController::submit');
$routes->get('/faq', 'FAQController::index');
$routes->get('/privacy-policy', 'PrivacyPolicyController::index');
$routes->get('/how-to', 'HowToController::index');
$routes->get('/thank-you', 'ThankYouController::index');
$routes->get('/products', 'ProductsController::index');
$routes->get('/products/filter', 'ProductsController::filterByCategory');
$routes->get('/products/search', 'ProductsController::search');
$routes->get('/product/(:any)', 'ProductDetailsController::index/$1');
$routes->get('/product-details/getData', 'ProductDetailsController::getData');
$routes->get('/product-details/otherProducts', 'ProductDetailsController::otherProducts');
$routes->get('/product-details/getProductColorImages', 'ProductDetailsController::getProductColorImages');
$routes->get('/product-details/getProductColors', 'ProductDetailsController::getProductColors');
$routes->get('/product-details/getProductSizes', 'ProductDetailsController::getProductSizes');
$routes->get('/product-details/checkLoginStatus', 'ProductDetailsController::checkLoginStatus');

// Customize Design Routes
$routes->get('customize-design/(:any)', 'CustomizeDesignController::index/$1');
$routes->post('customize-design/save-design', 'CustomizeDesignController::saveDesign');
$routes->get('customize-design/load-design/(:num)', 'CustomizeDesignController::loadDesign/$1');
$routes->post('customize-design/delete-design', 'CustomizeDesignController::deleteDesign');
$routes->get('customize-design/stickers/(:any)', 'CustomizeDesignController::getStickers/$1');
$routes->get('customize-design/stickers', 'CustomizeDesignController::getStickers');
$routes->get('customize-design/clip-arts/(:any)', 'CustomizeDesignController::getClipArts/$1');
$routes->get('customize-design/clip-arts', 'CustomizeDesignController::getClipArts');
$routes->get('customize-design/fonts', 'CustomizeDesignController::getFonts');
$routes->post('customize-design/upload-preview', 'CustomizeDesignController::uploadPreview');
$routes->post('customize-design/generate-preview', 'CustomizeDesignController::generatePreview');
$routes->get('customize-design/product-price', 'CustomizeDesignController::getProductPrice');
$routes->post('customize-design/add-to-cart', 'CustomizeDesignController::addToCart');

// Blog Routes
$routes->get('/blogs/get-categories', 'BlogsController::getCategoriesAjax');
$routes->get('/blogs/get-posts', 'BlogsController::getPosts');
$routes->get('/blogs', 'BlogsController::index');
$routes->get('/blogs/(:any)', 'BlogDetailsController::index/$1');

// Newsletter Routes
$routes->post('/newsletter/subscribe', 'NewsletterController::subscribe');

// Checkout & Payment Routes
$routes->get('/check-out', 'CheckOutController::index');
$routes->get('/payment', 'PaymentController::index');

// Policy Routes
$routes->get('/terms-and-conditions', 'TermsAndConditionsController::index');
$routes->get('/exchange-and-refund-policy', 'ExchangeAndRefundPolicyController::index');
$routes->get('/shipping-policy', 'ShippingPolicyController::index');

// Customer Routes
$routes->get('/profile', 'ProfileController::index');
$routes->post('/profile/update', 'ProfileController::update');
$routes->post('/profile/change-password', 'ProfileController::changePassword');
$routes->get('/orders', 'OrdersController::index');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/wishlist', 'WishlistController::index');

// Temporary uploads route for layout builder (must be outside admin group for direct access)
$routes->get('temp-uploads/(:any)', function($filename) {
    $path = WRITEPATH . 'temp_uploads/' . $filename;
    if (file_exists($path)) {
        $mime = mime_content_type($path);
        $response = service('response');
        $response->setHeader('Content-Type', $mime);
        $response->setBody(file_get_contents($path));
        return $response;
    }
    return service('response')->setStatusCode(404);
});

// ==================== ADMIN ROUTES ====================
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    
    // Authentication
    $routes->get('login', 'LoginController::index');
    $routes->post('login/authenticate', 'LoginController::authenticate');
    $routes->get('logout', 'LogoutController::index');
    $routes->get('dashboard', 'DashboardController::index');
    
    // ===== Blog Management =====
    $routes->get('blog-categories', 'BlogCategoriesController::index');
    $routes->post('blogcategories/getData', 'BlogCategoriesController::getData');
    $routes->post('blogcategories/insert', 'BlogCategoriesController::insert');
    $routes->delete('blogcategories/delete/(:num)', 'BlogCategoriesController::delete/$1');
    $routes->post('blogcategories/update/(:num)', 'BlogCategoriesController::update/$1');
    $routes->get('blogcategories/getCategory/(:num)', 'BlogCategoriesController::getCategory/$1');
    
    $routes->get('add-blog', 'AddBlogController::index');
    $routes->post('addblog/insert', 'AddBlogController::insert');
    $routes->get('addblog/categoryList', 'AddBlogController::categoryList');
    
    $routes->get('blog-masterlist', 'BlogMasterlistController::index');
    $routes->post('blogmasterlist/getData', 'BlogMasterlistController::getData');
    $routes->get('blogmasterlist/getBlog/(:num)', 'BlogMasterlistController::getBlog/$1');
    $routes->post('blogmasterlist/update/(:num)', 'BlogMasterlistController::update/$1');
    $routes->delete('blogmasterlist/delete/(:num)', 'BlogMasterlistController::delete/$1');
    $routes->post('blogmasterlist/updateStatus/(:num)', 'BlogMasterlistController::updateStatus/$1');
    $routes->get('blogmasterlist/getCategories', 'BlogMasterlistController::getCategories');
    $routes->post('blogmasterlist/toggleFeatured/(:num)', 'BlogMasterlistController::toggleFeatured/$1');
    
    $routes->get('edit-blog/(:num)', 'EditBlogController::index/$1');
    $routes->post('editblog/update/(:num)', 'EditBlogController::update/$1');
    $routes->get('editblog/getCategories', 'EditBlogController::getCategories');
    
    // ===== Product Management =====
    $routes->get('product-categories', 'ProductCategoriesController::index');
    $routes->post('productcategories/getData', 'ProductCategoriesController::getData');
    $routes->post('productcategories/insert', 'ProductCategoriesController::insert');
    $routes->delete('productcategories/delete/(:num)', 'ProductCategoriesController::delete/$1');
    $routes->post('productcategories/update/(:num)', 'ProductCategoriesController::update/$1');
    $routes->get('productcategories/getCategory/(:num)', 'ProductCategoriesController::getCategory/$1');
    
    $routes->get('add-product', 'AddProductController::index');
    $routes->post('add-product/store', 'AddProductController::store');
    $routes->post('add-product/upload-temp', 'AddProductController::uploadTempImage');
    $routes->post('add-product/upload-color-image', 'AddProductController::uploadColorImage');
    $routes->get('add-product/categories', 'AddProductController::getCategories');
    $routes->post('add-product/delete-temp-image', 'AddProductController::deleteTempImage');
    
    $routes->get('edit-product/(:num)', 'EditProductController::index/$1');
    $routes->post('edit-product/update/(:num)', 'EditProductController::update/$1');
    
    $routes->get('product-masterlist', 'ProductMasterlistController::index');
    $routes->post('productmasterlist/getData', 'ProductMasterlistController::getData');
    $routes->get('productmasterlist/getProduct/(:num)', 'ProductMasterlistController::getProduct/$1');
    $routes->delete('productmasterlist/delete/(:num)', 'ProductMasterlistController::delete/$1');
    $routes->post('productmasterlist/toggleFeatured/(:num)', 'ProductMasterlistController::toggleFeatured/$1');
    
    // ===== Grid Templates Management =====
    $routes->get('add-grid-template', 'AddGridTemplateController::index');
    $routes->post('addgridtemplate/insert', 'AddGridTemplateController::insert');
    
    $routes->get('grid-templates-masterlist', 'GridTemplatesMasterlistController::index');
    $routes->post('gridtemplatesmasterlist/getData', 'GridTemplatesMasterlistController::getData');
    $routes->get('gridtemplatesmasterlist/getTemplate/(:num)', 'GridTemplatesMasterlistController::getTemplate/$1');
    $routes->delete('gridtemplatesmasterlist/delete/(:num)', 'GridTemplatesMasterlistController::delete/$1');
    $routes->post('gridtemplatesmasterlist/toggleFeatured/(:num)', 'GridTemplatesMasterlistController::toggleFeatured/$1');
    
    $routes->get('edit-grid-template/(:num)', 'EditGridTemplateController::index/$1');
    $routes->post('edit-grid-template/update/(:num)', 'EditGridTemplateController::update/$1');
    $routes->get('edit-grid-template/getTemplateData/(:num)', 'EditGridTemplateController::getTemplateData/$1');
    
    // ===== Layout Templates Management =====
    $routes->get('add-layout-template', 'AddLayoutTemplateController::index');
    $routes->get('add-layout-template/edit/(:num)', 'AddLayoutTemplateController::edit/$1');
    $routes->post('add-layout-template/save', 'AddLayoutTemplateController::save');
    $routes->post('add-layout-template/update/(:num)', 'AddLayoutTemplateController::update/$1');
    $routes->get('add-layout-template/check-name', 'AddLayoutTemplateController::checkName');

    // Edit Layout Template Routes
    $routes->get('edit-layout-template/(:num)', 'EditLayoutTemplateController::index/$1');
    $routes->post('edit-layout-template/update/(:num)', 'EditLayoutTemplateController::update/$1');
    
    $routes->get('layout-templates-masterlist', 'LayoutTemplatesMasterlistController::index');
    $routes->post('layout-templates-masterlist/getData', 'LayoutTemplatesMasterlistController::getData');
    $routes->get('layout-templates-masterlist/getTemplate/(:num)', 'LayoutTemplatesMasterlistController::getTemplate/$1');
    $routes->delete('layout-templates-masterlist/delete/(:num)', 'LayoutTemplatesMasterlistController::delete/$1');
    $routes->post('layout-templates-masterlist/duplicate/(:num)', 'LayoutTemplatesMasterlistController::duplicate/$1');
    
    // ===== Fonts Management =====
    $routes->get('add-font', 'AddFontController::index');
    $routes->post('addfont/insert', 'AddFontController::insert');
    
    $routes->get('font-masterlist', 'FontMasterlistController::index');
    $routes->post('fontmasterlist/getData', 'FontMasterlistController::getData');
    $routes->get('fontmasterlist/getFont/(:num)', 'FontMasterlistController::getFont/$1');
    $routes->delete('fontmasterlist/delete/(:num)', 'FontMasterlistController::delete/$1');
    $routes->post('fontmasterlist/toggleFeatured/(:num)', 'FontMasterlistController::toggleFeatured/$1');
    $routes->get('fontmasterlist/download/(:any)', 'FontMasterlistController::download/$1');
    
    $routes->get('edit-font/(:num)', 'EditFontController::index/$1');
    $routes->post('editfont/update/(:num)', 'EditFontController::update/$1');
    
    // ===== Clipart & Icons Management =====
    $routes->get('add-clipart', 'AddClipArtController::index');
    $routes->post('add-clipart/store', 'AddClipArtController::store');
    
    $routes->get('clipart-masterlist', 'ClipArtMasterlistController::index');
    $routes->post('clipartmasterlist/getData', 'ClipArtMasterlistController::getData');
    $routes->post('clipartmasterlist/getTrashData', 'ClipArtMasterlistController::getTrashData');
    $routes->get('clipartmasterlist/getTrashCount', 'ClipArtMasterlistController::getTrashCount');
    $routes->get('clipartmasterlist/getClipArt/(:num)', 'ClipArtMasterlistController::getClipArt/$1');
    $routes->post('clipartmasterlist/toggleStatus/(:num)', 'ClipArtMasterlistController::toggleStatus/$1');
    $routes->delete('clipartmasterlist/softDelete/(:num)', 'ClipArtMasterlistController::softDelete/$1');
    $routes->post('clipartmasterlist/restore/(:num)', 'ClipArtMasterlistController::restore/$1');
    $routes->delete('clipartmasterlist/forceDelete/(:num)', 'ClipArtMasterlistController::forceDelete/$1');
    
    $routes->get('edit-clipart/(:num)', 'EditClipArtController::index/$1');
    $routes->post('edit-clipart/update/(:num)', 'EditClipArtController::update/$1');
    
    // ===== Stickers Management =====
    $routes->get('add-sticker', 'AddStickerController::index');
    $routes->post('add-sticker/store', 'AddStickerController::store');
    
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
    
    // ===== Customer Management =====
    $routes->get('add-customer', 'AddCustomerController::index');
    $routes->post('add-customer/store', 'AddCustomerController::store');
    
    $routes->get('customer-masterlist', 'CustomerMasterlistController::index');
    $routes->post('customermasterlist/getData', 'CustomerMasterlistController::getData');
    $routes->get('customermasterlist/getCustomer/(:num)', 'CustomerMasterlistController::getCustomer/$1');
    $routes->post('customermasterlist/toggleStatus/(:num)', 'CustomerMasterlistController::toggleStatus/$1');
    $routes->post('customermasterlist/toggleEmailVerification/(:num)', 'CustomerMasterlistController::toggleEmailVerification/$1');
    $routes->delete('customermasterlist/delete/(:num)', 'CustomerMasterlistController::delete/$1');
    
    $routes->get('edit-customer/(:num)', 'EditCustomerController::index/$1');
    $routes->post('edit-customer/update/(:num)', 'EditCustomerController::update/$1');
    
    // ===== Newsletter & Messaging =====
    $routes->get('subscribers-masterlist', 'SubscribersMasterlistController::index');
    $routes->post('subscribersmasterlist/getData', 'SubscribersMasterlistController::getData');
    $routes->get('subscribersmasterlist/getSubscriber/(:num)', 'SubscribersMasterlistController::getSubscriber/$1');
    $routes->post('subscribersmasterlist/updateStatus/(:num)', 'SubscribersMasterlistController::updateStatus/$1');
    $routes->delete('subscribersmasterlist/delete/(:num)', 'SubscribersMasterlistController::delete/$1');
    $routes->get('subscribersmasterlist/export', 'SubscribersMasterlistController::export');
    
    $routes->get('messages', 'MessagesController::index');
    $routes->post('messages/getData', 'MessagesController::getData');
    $routes->get('messages/getMessage/(:num)', 'MessagesController::getMessage/$1');
    $routes->delete('messages/delete/(:num)', 'MessagesController::delete/$1');
    $routes->post('messages/bulkMarkRead', 'MessagesController::bulkMarkRead');
    $routes->post('messages/bulkDelete', 'MessagesController::bulkDelete');
    $routes->get('messages/unread-count', 'MessagesController::getUnreadCount');
    
    // ===== Send Newsletter =====
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
    
    // ===== Email Templates =====
    $routes->get('email-templates', 'EmailTemplatesController::index');
    $routes->get('email-templates/list', 'EmailTemplatesController::getList');
    $routes->get('email-templates/stats', 'EmailTemplatesController::getStats');
    $routes->get('email-templates/get/(:num)', 'EmailTemplatesController::getTemplate/$1');
    $routes->post('email-templates/save', 'EmailTemplatesController::save');
    $routes->post('email-templates/toggleStatus/(:num)', 'EmailTemplatesController::toggleStatus/$1');
    $routes->post('email-templates/duplicate/(:num)', 'EmailTemplatesController::duplicate/$1');
    $routes->post('email-templates/incrementUsage/(:num)', 'EmailTemplatesController::incrementUsage/$1');
    $routes->delete('email-templates/delete/(:num)', 'EmailTemplatesController::delete/$1');
    
    // ===== General Settings =====
    $routes->get('settings', 'SettingsController::index');
    $routes->post('settings/update', 'SettingsController::update');
});