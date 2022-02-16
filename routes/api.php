<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::resource('products', ProductController::class);
// Public Routes
Route::post('/register', [AuthController::class,'register']);
Route::get('/products', [ProductController::class,'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::post('/login', [AuthController::class,'login']);

// Protected Routes
Route::group(['middleware'=>['auth:sanctum']], function (){
  // Route::get('/products/search/{name}', [ProductController::class, 'search']);
  Route::post('/products', [ProductController::class,'store']);
  Route::put('/products/{id}', [ProductController::class,'update']);
  Route::delete('/products/{id}', [ProductController::class,'destroy']);
  Route::post('/logout', [AuthController::class,'logout']);
});

// Before Controller
// Route::post('/products',function(){
//   return Product::create([
//     'name' => 'Product One',
//     'slug' => 'product-one',
//     'description' => 'This is product one',
//     'price' => '99.99'
//   ]);
// });


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
