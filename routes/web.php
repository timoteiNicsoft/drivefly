<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/daily', 'HomeController@daily')->name('daily');
Route::get('/prices', 'HomeController@prices')->name('prices');
Route::get('/stats', 'HomeController@stats')->name('stats');
Route::get('/levels', 'HomeController@levels')->name('levels');
Route::get('/products', 'HomeController@products')->name('products');
Route::get('/monthly', 'HomeController@monthly')->name('monthly');
Route::get('/alerts', 'HomeController@alerts')->name('alerts');
Route::get('/logs', 'HomeController@logs')->name('logs');
Route::get('/daily-without-terminal', 'HomeController@daily_without_terminal')->name('daily_without_terminal');
Route::get('/extra-payments', 'HomeController@extra_payments')->name('extra_payments');
Route::get('/printer-settings', 'PrinterSettingController@index')->name('printer-settings');
Route::get('/image_upload', 'HomeController@image_upload');

Route::post('/alerts', 'AlertController@store')->name('alerts_post');
Route::post('/ajax_search', 'HomeController@ajax_search');
Route::post('/image_upload', 'HomeController@image_upload');
Route::post('/image_delete', 'HomeController@image_delete');
Route::post('/ajax_payment_setaspaid', 'ExtraPaymentController@ajax_payment_setaspaid');
Route::post('/ajax_payment_delete', 'ExtraPaymentController@ajax_payment_delete');
Route::post('/ajax_payment_add', 'ExtraPaymentController@ajax_payment_add');
Route::post('/ajax_report_save', 'ReportController@ajax_report_save');
Route::post('/ajax_report', 'ReportController@ajax_report');
Route::post('/ajax_reports', 'ReportController@ajax_reports');
Route::post('/ajax_stats', 'HomeController@ajax_stats');
Route::post('/ajax_levels', 'HomeController@ajax_levels');
Route::post('/ajax_monthly', 'HomeController@ajax_monthly');
Route::post('/ajax_log', 'HomeController@ajax_log');
Route::post('/ajax_extra_payments', 'HomeController@ajax_extra_payments');
Route::post('/ajax_save_content_product', 'ProductController@ajax_save_content_product');
Route::post('/ajax_save_show_hide_product', 'ProductController@ajax_save_show_hide_product');
Route::post('/ajax_save_printer_settings', 'PrinterSettingController@save_position')->name('save_position_printer');

Route::get('/admin_price_get_product', 'HomeController@admin_price_get_product');
Route::get('/admin_price_get_promo', 'HomeController@admin_price_get_promo');
Route::post('/admin_price_set_bands', 'HomeController@admin_price_set_bands');
Route::post('/admin_price_set_grid', 'HomeController@admin_price_set_grid');

Route::put('product/{id}','ProductController@update')->name('product_update');