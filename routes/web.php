<?php

// use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login_post', [LoginController::class, 'checkLogin'])->name(('login_post'));
Route::get('/logout', [LoginController::class, 'logout'])->name(('logout'));


Route::group(['middleware' => 'auth'], function () {
    // User
    Route::get('/user', function () {
        return redirect()->route('userindex');
    });
    Route::prefix('user')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('userindex');
        Route::get('/getlistusers', [UserController::class, 'getListUsers'])->name('getlistusers');
        Route::get('/edit/{id}', [UserController::class, 'editUser'])->name('edituser');
        Route::post('/store', [UserController::class, 'storeUser'])->name('storeuser');
        Route::post('/update', [UserController::class, 'updateUser'])->name('updateuser');
        Route::post('/delete', [UserController::class, 'deleteUser'])->name('deleteuser');
        Route::post('/lock', [UserController::class, 'lockUser'])->name('lockuser');
        Route::get('/export', [UserController::class, 'export'])->name('exportuser');
        Route::post('/import', [UserController::class, 'import'])->name('importuser');
        Route::get('/download', [UserController::class, 'download'])->name('download');
    });

    // Product
    Route::get('/product', function () {
        return redirect()->route('productindex');
    });
    Route::prefix('product')->group(function () {
        Route::get('/index', [ProductController::class, 'index'])->name('productindex');
        Route::get('/getlistproducts', [ProductController::class, 'getListProducts'])->name('getlistproducts');
        Route::post('/delete', [ProductController::class, 'deleteProduct'])->name('deleteproduct');
        Route::get('/add', [ProductController::class, 'addProduct'])->name('addproduct');
        Route::post('/store', [ProductController::class, 'storeProduct'])->name('storeproduct');
        Route::get('/detail/{id}', [ProductController::class, 'detailProduct'])->name('detailproduct');
        Route::post('/update', [ProductController::class, 'updateProduct'])->name('updateproduct');
        Route::get('/getimage/{id}', [ProductController::class, 'getImage'])->name('getimage');
    });

    //Role
    Route::get('/role', function () {
        return redirect()->route('roleindex');
    });
    Route::prefix('role')->group(function () {
        Route::get('/index', [RoleController::class, 'index'])->name('roleindex');
        Route::get('/getlistroles', [RoleController::class, 'getListRoles'])->name('getlistroles');
        Route::get('/getrole/{id}', [RoleController::class, 'getRole'])->name('getrole');
        Route::post('/update', [RoleController::class, 'updateRole'])->name('updaterole');
        Route::post('/store', [RoleController::class, 'storeRole'])->name('storerole');
        Route::post('/delete', [RoleController::class, 'deleteRole'])->name('deleterole');
        Route::post('/changepermission', [RoleController::class, 'changePermission'])->name('changepermission');
    });

    Route::prefix('permission')->group(function () {
        Route::get('/getlistpermissions', [PermissionController::class, 'getListPermissions'])->name('getlistpermissions');
    });
});

