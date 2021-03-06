<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AuthController AS ApiAuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ShoppingCartProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Resources\UserResource;

use App\Http\Controllers\Api\Admin\CategoryController AS AdminCategoryController;
use App\Http\Controllers\Api\Admin\ProductController AS AdminProductController;
use App\Http\Controllers\Api\Admin\OrderController AS AdminOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->get('/product', [ProductController::class, 'get']);

Route
::get('/auth/user', [ApiAuthController::class, 'user'])
->name('api.auth.user.get');

Route
::post('/auth/login', [ApiAuthController::class, 'postLogin'])
->name('api.auth.login.post')
->middleware('guest');

Route
::post('/auth/register', [RegisterController::class, 'register'])
->name('api.auth.register.post')
->middleware('guest');

// Product

Route
::get('/product', [ProductController::class, 'get'])
->name('api.product.get')
->middleware('auth');

Route
::get('/product/{product_slug}', [ProductController::class, 'getDetail'])
->name('api.product.get_detail');

Route
::get('/product', [ProductController::class, 'get'])
->name('api.product.get')
->middleware('auth');

Route
::get('/newest-products', [ProductController::class, 'getNewestProducts'])
->name('api.products.newest');

Route
::get('/most-viewed-products', [ProductController::class, 'getMostViewedProducts'])
->name('api.products.most-viewed');

Route
::get('/product/category/{slug}', [ProductController::class, 'getProductsByCategorySlugs'])
->where('slug', '.+');

// Category

Route
::get('/category', [CategoryController::class, 'get'])
->name('api.category.get');

Route
::get('/category/{category_id}', [CategoryController::class, 'getDetail'])
->name('api.category.get_detail')
->middleware('auth');

Route
::put('/category', [CategoryController::class, 'put'])
->name('api.category.put')
->middleware('auth');

Route
::patch('/category', [CategoryController::class, 'patch'])
->name('api.category.patch')
->middleware('auth');

Route
::get('/product', [ProductController::class, 'get'])
->name('api.product.get')
->middleware('auth');

// Shopping Cart Product

Route
::get('/shopping-cart-product', [ShoppingCartProductController::class, 'get'])
->name('api.shopping_cart_product.get')
->middleware('auth');

Route
::put('/shopping-cart-product', [ShoppingCartProductController::class, 'put'])
->name('api.shopping_cart_product.put')
->middleware('auth');

Route
::patch('/shopping-cart-product', [ShoppingCartProductController::class, 'patch'])
->name('api.shopping_cart_product.patch')
->middleware('auth');

Route
::delete('/shopping-cart-product', [ShoppingCartProductController::class, 'destroy'])
->name('api.shopping_cart_product.destroy')
->middleware('auth');

// Order

Route
::get('/order', [OrderController::class, 'get'])
->name('api.order.get')
->middleware('auth');

Route
::get('/order/{order_id}', [OrderController::class, 'getDetail'])
->name('api.order.getDetail')
->middleware('auth');

Route
::put('/order', [OrderController::class, 'put'])
->name('api.order.put')
->middleware('auth');

Route
::patch('/order', [OrderController::class, 'patch'])
->name('api.order.patch')
->middleware('auth');

Route
::delete('/order', [OrderController::class, 'destroy'])
->name('api.order.delete')
->middleware('auth');

// Review

Route
::get('/review/{product_slug}', [ReviewController::class, 'get'])
->name('api.review.get');

Route
::put('/review', [ReviewController::class, 'put'])
->name('api.review.put')
->middleware('auth');

// Admin Product

Route
::get('/admin/product', [AdminProductController::class, 'get'])
->name('admin.api.product.get')
->middleware('auth');

Route
::get('/admin/product/detail/{product_id}', [AdminProductController::class, 'getDetail'])
->name('admin.api.product.detail.get')
->middleware('auth');

Route
::get('/admin/product/{product_id}', [AdminProductController::class, 'getDetail'])
->name('admin.api.product.get_detail')
->middleware('auth');

Route
::put('/admin/product', [AdminProductController::class, 'put'])
->name('admin.api.product.put')
->middleware('auth');

Route
::patch('/admin/product', [AdminProductController::class, 'patch'])
->name('admin.api.product.patch')
->middleware('auth');

Route
::delete('/admin/product', [AdminProductController::class, 'destroy'])
->name('admin.api.product.delete')
->middleware('auth');

// Category

Route
::get('/admin/category', [AdminCategoryController::class, 'get'])
->name('admin.api.category.get')
->middleware('auth');

Route
::get('/admin/category/detail/{category_id}', [AdminCategoryController::class, 'getDetail'])
->name('admin.api.category.detail.get')
->middleware('auth');

Route
::get('/admin/category/options', [AdminCategoryController::class, 'getOptions'])
->name('admin.api.category.options.get')
->middleware('auth');

Route
::put('/admin/category', [AdminCategoryController::class, 'put'])
->name('admin.api.category.put')
->middleware('auth');

Route
::patch('/admin/category', [AdminCategoryController::class, 'patch'])
->name('admin.api.category.patch')
->middleware('auth');

Route
::delete('/admin/category', [AdminCategoryController::class, 'destroy'])
->name('admin.api.category.destroy')
->middleware('auth');

Route
::delete('/admin/category', [AdminCategoryController::class, 'destroy'])
->name('admin.api.category.destroy')
->middleware('auth');

// Admin Order

Route
::get('/admin/order', [AdminOrderController::class, 'get'])
->name('admin.api.order.get')
->middleware('auth');
