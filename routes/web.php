<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\FrontPageController;

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ShopppingCartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\OrderController;

use App\Http\Controllers\Web\Admin\DashboardController AS AdminDashboardController;
use App\Http\Controllers\Web\Admin\CategoryController AS AdminCategoryController;
use App\Http\Controllers\Web\Admin\ProductController AS AdminProductController;
use Inertia\Inertia;

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

// Login

Route
::get('/auth/login', function (Request $request)
{
});

// Register

Route
::get('/auth/register', function ()
{
    return Inertia::render('Auth/Register');
});

// Admin Login

Route
::get('/admin/auth/login', [AuthController::class, 'showLoginForm'])
->name('admin.auth.login')
->middleware('guest');

// Logout

Route
::get('/admin/auth/logout', [AuthController::class, 'logout'])
->name('admin.auth.logout')
->middleware('auth');

// Front Page

Route
::get('/', [FrontPageController::class, 'index'])
->name('frontpage');

// Product

Route
::get('/product/{slug}', [ProductController::class, 'single'])
->name('frontpage');

// Category

Route
::get('/category/{slug}', [CategoryController::class, 'single'])
->name('category')
->where('slug','.+');

// Shopping Cart

Route
::get('/shopping-cart', [ShopppingCartController::class, 'index'])
->name('shoppping_cart.index')
->middleware('auth');

// Checkout

Route
::get('/checkout', [CheckoutController::class, 'index'])
->name('checkout.index')
->middleware('auth');

// Order

Route
::get('/order/{order_id}', [OrderController::class, 'single'])
->name('order.index')
->middleware('auth');

// 500 error

Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});

// Admin Dashboard

Route
::get('/admin', [AdminDashboardController::class, 'index'])
->name('admin.dashboard')
->middleware('auth');

// Admin Category

Route
::get('/admin/category', [AdminCategoryController::class, 'index'])
->name('admin.category.index')
->middleware('auth');

Route
::get('/admin/category/insert', [AdminCategoryController::class, 'insert'])
->name('admin.category.insert')
->middleware('auth');

Route
::get('/admin/category/update/{category_id}', [AdminCategoryController::class, 'update'])
->name('admin.category.update')
->middleware('auth');

// Product

Route
::get('/admin/product', [AdminProductController::class, 'index'])
->name('admin.product.index')
->middleware('auth');

Route
::get('/admin/product/insert', [AdminProductController::class, 'insert'])
->name('admin.product.insert')
->middleware('auth');

Route
::get('/admin/product/update/{product_id}', [AdminProductController::class, 'update'])
->name('admin.product.update')
->middleware('auth');
