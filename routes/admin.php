<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin'], function () {

  Route::get('orders-msg-attachment/{id}', 'OrderController@orderMsgAttachment')->name('admin.orders.msg.attachment');

  // Login
  Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.login');
  Route::post('login', 'Auth\LoginController@login');
  Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

  // Register
  Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('admin.register');
  Route::post('register', 'Auth\RegisterController@register');

  // Passwords
  Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');

  // Verify
  Route::get('email/verify', 'Auth\VerificationController@show')->name('admin.verification.notice');
  Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('admin.verification.verify');
  Route::post('email/resend', 'Auth\VerificationController@resend')->name('admin.verification.resend');
});

Route::group(['middleware' => ['admin.auth:admin', 'admin.verified'], 'namespace' => 'Admin', 'as' => 'admin.'], function () {
  Route::post('save-variant-images', 'HomeController@saveVariantImages')->name('product.image.saveVariantImages');

  Route::get('/', 'HomeController@index')->name('home');
  Route::get('size/chart', 'HomeController@sizeChart')->name('size.chart');
  Route::get('variant/chart', 'HomeController@variantChart')->name('variant.chart');
  Route::get('material/chart', 'HomeController@materialChart')->name('material.chart');
  Route::get('country/chart', 'HomeController@countryChart')->name('country.chart');

  Route::get('test', 'OrderController@test');

  Route::group(['namespace' => 'Access'], function () {

    Route::post('user/list', 'UserController@dataList')->name('user.dataList');
    Route::post('user/{id}/status', 'UserController@changeStatus')->name('user.status');
    Route::get('user/email/unique', 'UserController@emailUnique')->name('user.email.unique');
    Route::resource('user', 'UserController');

    Route::get('get/role', 'RoleController@getRoleList')->name('get.role');
    Route::post('assign/{role}/permission', 'RoleController@assignPermission')->name('role.permission.assign');
    Route::post('role/exists', 'RoleController@roleExists')->name('role.exists');
    Route::post('role/data-list', 'RoleController@dataList')->name('role.dataList');
    Route::post('role/{id}/status', 'RoleController@changeStatus')->name('role.status');
    Route::resource('role', 'RoleController');


    Route::get('get/permission', 'PermissionController@getPermissionList')->name('get.permission');
    Route::post('permission/exists', 'PermissionController@permissionExists')->name('permission.exists');
    Route::post('permission/data-list', 'PermissionController@dataList')->name('permission.dataList');
    Route::post('permission/{id}/status', 'PermissionController@changeStatus')->name('permission.status');
    Route::resource('permission', 'PermissionController');
  });

  Route::resource('profile', 'ProfileController');
  Route::post('profile/update-image/{admin}', 'ProfileController@updateImage')->name('profile.update.image');

  Route::get('category/exists', 'CategoryController@exists')->name('category.exists');
  Route::post('category/{id}/status', 'CategoryController@changeStatus')->name('category.status');
  Route::post('category/data-list', 'CategoryController@dataList')->name('category.dataList');
  Route::resource('category', 'CategoryController');

  Route::get('sub-category/exists', 'SubCategoryController@exists')->name('sub-category.exists');
  Route::post('sub-category/{id}/status', 'SubCategoryController@changeStatus')->name('sub-category.status');
  Route::post('sub-category/data-list', 'SubCategoryController@dataList')->name('sub-category.dataList');
  Route::resource('sub-category', 'SubCategoryController');


  Route::post('product/status', 'ProductController@changeStatus')->name('product.status');
  Route::post('product/list', 'ProductController@dataListing')->name('product.list');
  Route::get('product/slug/unique', 'ProductController@slugExists')->name('product.slug');
  Route::get('product/clone/{id}', 'ProductController@cloneProduct')->name('product.clone');
  Route::resource('product', 'ProductController');

  Route::post('product/{product_id}/image/alt', 'ProductImageController@changeAlt')->name('product.image.alt');
  Route::post('product/{product_id}/image/removeimage', 'ProductImageController@removeImage')->name('product.image.remove');
  Route::post('product/{product_id}/image/removeAll', 'ProductImageController@removeAll')->name('product.image.remove.all');
  Route::post('product/{product_id}/image/update', 'ProductImageController@positionImage')->name('product.image.position');
  Route::resource('product/{product_id}/image', 'ProductImageController');

  Route::post('product/{product_id}/variation-edit/{id}', 'ProductVariationController@updateVariantform')->name('variation.variation_update_form');
  Route::get('product/{product_id}/variation-edit/{id}', 'ProductVariationController@editVariantform')->name('variation.variation_edit_form');
  Route::get('product/{product_id}/variation-add', 'ProductVariationController@addVariantform')->name('variation.variation_add');
  Route::post('product/{product_id}/variation-add-save', 'ProductVariationController@addSaveVariantform')->name('variation.variation_add_save');

  Route::get('product/{product_id}/variation-edit', 'ProductVariationController@editVariant')->name('variation.variation_edit');
  Route::get('product/{product_id}/variation/{id}/delete', 'ProductVariationController@deletevariant')->name('variation.deletevariant');
  Route::resource('product/{product_id}/variation', 'ProductVariationController');

  Route::post('inventory/bulk', 'InventoryController@updateAll')->name('inventory.update_all');
  Route::post('inventory/variant/bulk', 'InventoryController@updateBulk')->name('inventory.bulk.update_all');
  Route::post('inventory/list', 'InventoryController@dataListing')->name('inventory.list');
  Route::get('inventory/change/qty', 'InventoryController@changeQty')->name('inventory.change.qty');
  Route::resource('inventory', 'InventoryController');

  Route::get('blog/exists', 'BlogController@exists')->name('blog.exists');
  Route::post('blog/{id}/status', 'BlogController@changeStatus')->name('blog.status');
  Route::post('blog/data-list', 'BlogController@dataList')->name('blog.dataList');
  Route::resource('blog', 'BlogController');

  Route::get('/chat', 'MessageController@index')->name('chat.order');

  Route::post('message-snippet/{id}/status', 'MessageSnippetController@changeStatus')->name('message-snippet.status');
  Route::post('message-snippet/data-list', 'MessageSnippetController@dataList')->name('message-snippet.dataList');
  Route::resource('message-snippet', 'MessageSnippetController');

  Route::get('testimonial/exists', 'TestimonialController@exists')->name('testimonial.exists');
  Route::post('testimonial/{id}/status', 'TestimonialController@changeStatus')->name('testimonial.status');
  Route::post('testimonial/data-list', 'TestimonialController@dataList')->name('testimonial.dataList');
  Route::resource('testimonial', 'TestimonialController');


  Route::get('get/tag', 'TagController@getTagList')->name('get.tag');
  Route::post('tag/exists', 'TagController@exists')->name('tag.exists');
  Route::post('tag/data-list', 'TagController@dataList')->name('tag.dataList');
  Route::post('tag/{id}/status', 'TagController@changeStatus')->name('tag.status');
  Route::resource('tag', 'TagController');


  Route::post('newsletter/list', 'NewsletterController@dataListing')->name('newsletter.list');
  Route::resource('newsletter', 'NewsletterController');

  Route::post('contact/list', 'ContactController@dataListing')->name('contact.list');
  Route::resource('contact', 'ContactController');

  Route::get('get/customer', 'CustomerController@getCustomerList')->name('get.customer');
  Route::post('customer/status', 'CustomerController@changeStatus')->name('customer.status');
  Route::post('customer/list', 'CustomerController@dataListing')->name('customer.list');
  Route::resource('customer', 'CustomerController');

  Route::post('review/status', 'ReviewController@changeStatus')->name('review.status');
  Route::post('review/list', 'ReviewController@dataListing')->name('review.list');
  Route::resource('review', 'ReviewController');

  Route::post('faq/list', 'FrequentAskQuestionController@dataListing')->name('faq.list');
  Route::resource('faq', 'FrequentAskQuestionController');

  Route::post('story/list', 'StoryController@dataListing')->name('story.list');
  Route::resource('story', 'StoryController');

  Route::post('team/exists', 'TeamController@exists')->name('team.exists');
  Route::post('team/{id}/status', 'TeamController@changeStatus')->name('team.status');
  Route::post('team/list', 'TeamController@dataListing')->name('team.list');
  Route::resource('team', 'TeamController');


  Route::post('discount/status', 'DiscountController@changeStatus')->name('discount.status');
  Route::post('discount/checkDiscountCode', 'DiscountController@checkDiscountCode')->name('discount.checkDiscountCode');
  Route::post('discount/list', 'DiscountController@dataListing')->name('discount.list');
  Route::resource('discount', 'DiscountController');


  Route::post('order/status', 'OrderController@changeStatus')->name('order.status');
  Route::post('order/checkorderCode', 'OrderController@checkorderCode')->name('order.checkorderCode');
  Route::post('order/list', 'OrderController@dataListing')->name('order.list');
  Route::get('order/download/{id}', 'OrderController@orderImageDownload')->name('order.download');
  Route::get('order/rmeove-image/{id}', 'OrderController@orderRemovePic')->name('order.removepic');
  Route::get('order/invoice/{id}', 'OrderController@orderInvoice')->name('order.inv');

  Route::get('order/pdf/{id}', 'OrderController@orderPdf')->name('order.pdf');

  Route::post('order/sendWhatsapp/{id}', 'OrderController@sendWhatsapp')->name('order.whatsapp');
  Route::post('order/sendSms/{id}', 'OrderController@sendSms')->name('order.sms');

  Route::resource('order', 'OrderController');
  Route::post('orders-msg', 'OrderController@orderMsg')->name('orders.msg');



  Route::get('export/print/', 'ExportController@exportPrint')->name('export.print');
  Route::get('export/pdf/', 'ExportController@exportPdf')->name('export.pdf');
  Route::get('export/excel/', 'ExportController@exportExcel')->name('export.excel');



  Route::group(['namespace' => 'Settings', 'middleware' => ['hasSettingPermission']], function () {

    Route::post('pages/list', 'PagesController@dataListing')->name('pages.list');
    Route::get('pages/slug/unique', 'PagesController@slugExists')->name('pages.slug');
    Route::resource('pages', 'PagesController');

    Route::get('deal-of-day', 'DealOfDayController@index')->name('dealofday.index');
    Route::post('deal-of-day/update', 'DealOfDayController@update')->name('dealofday.update');

    Route::get('site-map', 'SiteMapController@index')->name('sitemap.index');
    Route::post('site-map/update', 'SiteMapController@store')->name('sitemap.update');


    Route::get('website-setting', 'SettingController@showSettingPage')->name('website-setting');
    Route::resource('settings', 'SettingController');
    Route::resource('smtp', 'SmtpSettingController');

    Route::post('option/list', 'OptionController@dataListing')->name('option.list');
    Route::get('option/exists', 'OptionController@hashExists')->name('option.exists');
    Route::resource('option', 'OptionController');

    Route::post('optionvalue/list', 'OptionValueController@dataList')->name('optionvalue.list');
    Route::post('optionvalue/exists', 'OptionValueController@exists')->name('optionvalue.exists');
    Route::post('optionvalue/{id}/status', 'OptionValueController@changeStatus')->name('optionvalue.status');
    Route::resource('optionvalue', 'OptionValueController');

    Route::post('bannder/list', 'HomepagebannerController@dataListing')->name('bannder.list');
    Route::post('bannder/status', 'HomepagebannerController@changeStatus')->name('homepagebanners.status');
    Route::resource('homepagebanners', 'HomepagebannerController');

    Route::resource('common-banner', 'CommonBannerController');

    Route::post('hscode/list', 'HsCodeController@dataListing')->name('hscode.list');
    Route::get('hscode/exists', 'HsCodeController@hashExists')->name('hscode.exists');
    Route::resource('hscode', 'HsCodeController');

    Route::post('shipping-country/list', 'ShippingCountryController@dataList')->name('shipping-country.list');
    Route::post('shipping-country/exists', 'ShippingCountryController@exists')->name('shipping-country.exists');
    Route::post('shipping-country/{id}/status', 'ShippingCountryController@changeStatus')->name('shipping-country.status');
    Route::resource('shipping-country', 'ShippingCountryController');

    Route::resource('payment', 'PaymentController');
  });
});

Route::group(['as' => 'admin.'], function () {
  Route::get('get/option', 'Controller@getOption')->name('get.option');
  Route::get('get/optionvalue', 'Controller@getOptionValue')->name('get.optionvalue');
  Route::get('get/category', 'Controller@getCategory')->name('get.category');
  Route::get('get/sub-country', 'Controller@getSubCategory')->name('get.sub-category');
  Route::get('get/product', 'Controller@getProduct')->name('get.product');
  Route::get('get/search/product', 'Controller@getSearchProduct')->name('get.search.product');
  Route::get('get/hsncode', 'Controller@getHsnCode')->name('get.taxable_percentage');
  Route::get('get/country', 'Controller@getCountry')->name('get.country');
});