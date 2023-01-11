<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\AutocompleteController;
use App\Models\Task;
use Illuminate\Http\Request;

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
Route::middleware(['auth'])->prefix('admin')->group(function(){
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('',[DashboardController::class,'Index']);
    Route::get('notification',[NotificationController::class,'markAsRead'])->name('mark-as-read');
    Route::get('notification-read',[NotificationController::class,'read'])->name('read');
    Route::get('profile',[UserController::class,'profile'])->name('profile');
    Route::post('profile/{user}',[UserController::class,'updateProfile'])->name('profile.update');
    Route::put('profile/update-password/{user}',[UserController::class,'updatePassword'])->name('update-password');
    Route::post('logout',[LogoutController::class,'index'])->name('logout');

    Route::resource('users',UserController::class);
    Route::resource('permissions',PermissionController::class)->only(['index','store','destroy']);
    Route::put('permission',[PermissionController::class,'update'])->name('permissions.update');
    Route::resource('roles',RoleController::class);
    Route::resource('suppliers',SupplierController::class);
    Route::resource('categories',CategoryController::class)->only(['index','store','destroy']);
    Route::put('categories',[CategoryController::class,'update'])->name('categories.update');
    Route::resource('purchases',PurchaseController::class)->except('show');
    Route::get('purchases/reports',[PurchaseController::class,'reports'])->name('purchases.report');
    Route::post('purchases/reports',[PurchaseController::class,'generateReport']);
    Route::resource('products',ProductController::class)->except('show');
    Route::get('products/outstock',[ProductController::class,'outstock'])->name('outstock');
    Route::get('products/expired',[ProductController::class,'expired'])->name('expired');
    Route::resource('sales',SaleController::class)->except('show');
    Route::get('sales/reports',[SaleController::class,'reports'])->name('sales.report');
    Route::post('sales/reports',[SaleController::class,'generateReport']);

    Route::get('backup', [BackupController::class,'index'])->name('backup.index');
    Route::put('backup/create', [BackupController::class,'create'])->name('backup.store');
    Route::get('backup/download/{file_name?}', [BackupController::class,'download'])->name('backup.download');
    Route::delete('backup/delete/{file_name?}', [BackupController::class,'destroy'])->where('file_name', '(.*)')->name('backup.destroy');

    Route::get('settings',[SettingController::class,'index'])->name('settings');

    Route::get('/showFromNotification/{purchase}/{notification}', [PurchaseController::class, 'showFromNotification'])->name('purchases.showFromNotification');
    Route::get('/showFrmNotification/{sale}/{notification}', [SaleController::class, 'showFrmNotification'])->name('sales.showFrmNotification');
});

Route::middleware(['guest'])->prefix('admin')->group(function () {
    Route::get('',[DashboardController::class,'Index']);

    Route::get('login',[LoginController::class,'index'])->name('login');
    Route::post('login',[LoginController::class,'login']);

    Route::get('register',[RegisterController::class,'index'])->name('register');
    Route::post('register',[RegisterController::class,'store']);

    Route::get('forgot-password',[ForgotPasswordController::class,'index'])->name('password.request');
    Route::post('forgot-password',[ForgotPasswordController::class,'requestEmail']);
    Route::get('reset-password/{token}',[ResetPasswordController::class,'index'])->name('password.reset');
    Route::post('reset-password',[ResetPasswordController::class,'resetPassword'])->name('password.update');
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/tasks', function () {
    return view('welcom');
})->name('task');

/* Route::post('/tasks',function(Request $request) { */
Route::post('tasks',[SaleController::class,'tasks']);
/* 
Route::post('/tasks',function(Request $request) {
    
    $request->validate([
       'task_name' => 'required',
       'cost' => 'required'
    ]);
    
    $count = count($request->task_name);

    for ($i=0; $i < $count; $i++) { 
	  $task = new Task();
	  $task->task_name = $request->task_name[$i];
	  $task->cost = $request->cost[$i];
	  $task->save();
    }

    return redirect()->back();
}); */

Route::get('/autocomplete', [AutocompleteController::class, 'index']);
Route::post('/autocomplete/fetch', [AutocompleteController::class, 'fetch'])->name('autocomplete.fetch');
Route::post('/product/fetch', [SaleController::class, 'fetch'])->name('product.fetch');