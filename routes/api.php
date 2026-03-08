<?php

use App\Http\Controllers\Api\Admin\BranchController;
use App\Http\Controllers\Api\Admin\BranchProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\ColorController;
use App\Http\Controllers\Api\Admin\EmployeeController;
use App\Http\Controllers\Api\Admin\InventoryTransactionController;
use App\Http\Controllers\Api\Admin\InventoryTypeController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\ProductVariantController;
use App\Http\Controllers\Api\Admin\TagController;
use App\Http\Controllers\Api\Admin\AttributeController;
use App\Http\Controllers\Api\User\UserAddressController;
use L5Swagger\Http\Controllers\SwaggerController;
use App\Http\Controllers\ApiDocController;

Route::get('/api/documentation', [SwaggerController::class, 'api'])->name('swagger.docs');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'getUser']);
        Route::put('user', [AuthController::class, 'updateUser']);
    });
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::get('users', [AuthController::class, 'getAllUser']);
    });
});

// User Address routes
Route::prefix('user-addresses')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::get('/', [UserAddressController::class, 'index']);
        Route::get('/search', [UserAddressController::class, 'search']);
        Route::get('/{id}', [UserAddressController::class, 'show']);
        Route::post('/', [UserAddressController::class, 'store']);
        Route::put('/{id}', [UserAddressController::class, 'update']);
        Route::delete('/{id}', [UserAddressController::class, 'destroy']);
    });
});

// Color routes
Route::prefix('colors')->group(function () {
    Route::get('/', [ColorController::class, 'index']);
    Route::get('/search', [ColorController::class, 'search']);
    Route::get('/{id}', [ColorController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [ColorController::class, 'store']);
        Route::put('/{id}', [ColorController::class, 'update']);
        Route::delete('/{id}', [ColorController::class, 'destroy']);
    });
});

// Branch routes
Route::prefix('branches')->group(function () {
    Route::get('/', [BranchController::class, 'index']);
    Route::get('/search', [BranchController::class, 'search']);
    Route::get('/{id}', [BranchController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [BranchController::class, 'store']);
        Route::put('/{id}', [BranchController::class, 'update']);
        Route::delete('/{id}', [BranchController::class, 'destroy']);
    });
});

// Employee routes
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('/search', [EmployeeController::class, 'search']);
    Route::get('/{id}', [EmployeeController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [EmployeeController::class, 'store']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'destroy']);
    });
});

// Brand routes
Route::prefix('brands')->group(function () {
    Route::get('/', [BrandController::class, 'index']);
    Route::get('/search', [BrandController::class, 'search']);
    Route::get('/{id}', [BrandController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [BrandController::class, 'store']);
        Route::put('/{id}', [BrandController::class, 'update']);
        Route::delete('/{id}', [BrandController::class, 'destroy']);
    });
});

// Category routes
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/search', [CategoryController::class, 'search']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
});

// Tag routes
Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::get('/search', [TagController::class, 'search']);
    Route::get('/{id}', [TagController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [TagController::class, 'store']);
        Route::put('/{id}', [TagController::class, 'update']);
        Route::delete('/{id}', [TagController::class, 'destroy']);
    });
});

// Attribute routes
Route::prefix('attributes')->group(function () {
    Route::get('/', [AttributeController::class, 'index']);
    Route::get('/search', [AttributeController::class, 'search']);
    Route::get('/{id}', [AttributeController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [AttributeController::class, 'store']);
        Route::put('/{id}', [AttributeController::class, 'update']);
        Route::delete('/{id}', [AttributeController::class, 'destroy']);
    });
});


// Product routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/search', [ProductController::class, 'search']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [ProductController::class, 'store']);
        Route::post('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
    });
});

//product variant routes
Route::prefix('product-variants')->group(function () {
    Route::get('/', [ProductVariantController::class, 'index']);
    Route::get('/search', [ProductVariantController::class, 'search']);
    Route::get('/{id}', [ProductVariantController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [ProductVariantController::class, 'store']);
        Route::post('/{id}', [ProductVariantController::class, 'update']);
        Route::delete('/{id}', [ProductVariantController::class, 'destroy']);
    });
});

Route::prefix('branch-products')->group(function () {
    Route::get('/', [BranchProductController::class, 'index']);
    Route::get('/search', [BranchProductController::class, 'search']);
    Route::get('/{id}', [BranchProductController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [BranchProductController::class, 'store']);
        Route::post('/{id}', [BranchProductController::class, 'update']);
        Route::delete('/{id}', [BranchProductController::class, 'destroy']);
    });
});

// Inventory routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('inventory-types')->group(function () {
        Route::get('/', [InventoryTypeController::class, 'index']);
        Route::get('/search', [InventoryTypeController::class, 'search']);
        Route::get('/{id}', [InventoryTypeController::class, 'show']);
        Route::middleware('admin')->group(function () {
            Route::post('/', [InventoryTypeController::class, 'store']);
            Route::put('/{id}', [InventoryTypeController::class, 'update']);
            Route::delete('/{id}', [InventoryTypeController::class, 'destroy']);
        });
    });

    Route::prefix('inventory-transactions')->group(function () {
        Route::get('/', [InventoryTransactionController::class, 'index']);
        Route::get('/search', [InventoryTransactionController::class, 'search']);
        Route::get('/{id}', [InventoryTransactionController::class, 'show']);
        Route::middleware('admin')->group(function () {
            Route::post('/', [InventoryTransactionController::class, 'store']);
            Route::put('/{id}', [InventoryTransactionController::class, 'update']);
            Route::delete('/{id}', [InventoryTransactionController::class, 'destroy']);
        });
    });
});

// City routes
Route::prefix('cities')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\CityController::class, 'index']);
    Route::get('/search', [\App\Http\Controllers\Api\CityController::class, 'search']);
    Route::get('/{id}', [\App\Http\Controllers\Api\CityController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [\App\Http\Controllers\Api\CityController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Api\CityController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\CityController::class, 'destroy']);
    });
});

// Ward routes
Route::prefix('wards')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\WardController::class, 'index']);
    Route::get('/search', [\App\Http\Controllers\Api\WardController::class, 'search']);
    Route::get('/{id}', [\App\Http\Controllers\Api\WardController::class, 'show']);
    Route::middleware(['auth:api', 'admin'])->group(function () {
        Route::post('/', [\App\Http\Controllers\Api\WardController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Api\WardController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\WardController::class, 'destroy']);
    });
});
// AUTO-GENERATED CRUD ROUTES START


// AUTO-GENERATED CRUD ROUTES END

// Dummy ping endpoint for Swagger PathItem
Route::get('/ping', [ApiDocController::class, 'ping']);

Route::namespace('App\Http\Controllers\Api\Admin')->prefix('admin')->group(function () {});

Route::namespace('App\Http\Controllers\Api\User')->group(function () {});
