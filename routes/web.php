<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\BootstrapTables;
use App\Http\Livewire\Category;
use App\Http\Livewire\Components\Buttons;
use App\Http\Livewire\Components\Forms;
use App\Http\Livewire\Components\Modals;
use App\Http\Livewire\Components\Notifications;
use App\Http\Livewire\Components\Typography;
use App\Http\Livewire\Customer;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Err404;
use App\Http\Livewire\Err500;
use App\Http\Livewire\ItemList;
use App\Http\Livewire\OrderList;
use App\Http\Livewire\ResetPassword;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\Lock;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\ForgotPasswordExample;
use App\Http\Livewire\Index;
use App\Http\Livewire\LoginExample;
use App\Http\Livewire\ProfileExample;
use App\Http\Livewire\RegisterExample;
use App\Http\Livewire\Transactions;
use App\Http\Livewire\VinylItem;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ResetPasswordExample;
use App\Http\Livewire\UpgradeToPro;
use App\Http\Livewire\Users;

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

Route::redirect('/', '/login');

Route::get('/register', Register::class)->name('register');

Route::get('/login', Login::class)->name('login');

Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}', ResetPassword::class)->name('reset-password')->middleware('signed');

Route::get('/404', Err404::class)->name('404');
Route::get('/500', Err500::class)->name('500');
Route::get('/upgrade-to-pro', UpgradeToPro::class)->name('upgrade-to-pro');

Route::middleware('auth')->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/customers', Customer::class)->name('customers');
    Route::get('/customers-data', [UserController::class, 'getCustomerData']);

    /*
     * Categories
     */

    Route::get('/categories', Category::class)->name('categories');
    Route::get('/category-data', [CategoryController::class, 'categoryTableData'])->name('category-data');
    Route::post('/create-category', [CategoryController::class, 'create']);
    Route::post('/update-category', [CategoryController::class, 'update']);
    Route::post('/delete-category', [CategoryController::class, 'delete']);

    /*
     * Items
     */
    Route::get('/item/{item}', ItemList::class)->name('items');
    Route::post('/add-item', [ItemsController::class, 'create']);
    Route::post('/update-item', [ItemsController::class, 'update']);
    Route::post('/delete-item', [ItemsController::class, 'delete']);
    Route::get('/items/{type}', [ItemsController::class, 'itemTableData'])->name('items');
    Route::post('/check-producer-code', [ItemsController::class, 'checkExistingProducerCode']);
    Route::post('/update-existing-item', [ItemsController::class, 'updateExistingProducerCodeQty']);

    /*
     * Orders
     */
    Route::get('/orders', OrderList::class)->name('orders');
    Route::get('/order-data', [OrderController::class, 'orderTableData'])->name('order-data');
});
