<?php

use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;

use App\Http\Controllers\PizzaController;

use App\Http\Controllers\CartController;

use App\Http\Controllers\IngredientsController;

use App\Http\Controllers\ExtraController;

use App\Http\Controllers\BreadController;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {

    //Pizzas
    Route::get('/create_pizza', [PizzaController::class, 'create_pizza'])->name('admin.create_pizza');
    Route::get('/show_pizzas', [PizzaController::class, 'show_pizzas'])->name('admin.show_pizzas');
    Route::get('/edit_pizza/{id}', [PizzaController::class, 'edit'])->name('edit_pizza');
    Route::put('/pizzas/{id}', [PizzaController::class, 'update'])->name('pizzas.update');
    Route::delete('/pizza/{id}', [PizzaController::class, 'destroy'])->name('pizza.destroy');
    Route::post('/pizzas', [PizzaController::class, 'store'])->name('pizzas.store');

    //End of pizzas

    // Ingredients
    Route::get('/ingredients', [IngredientsController::class, 'ingredients'])->name('admin.ingredients');
    Route::get('/edit_ingredients/{id}', [IngredientsController::class, 'edit'])->name('ingredients.edit');
    Route::put('/edit_ingredients/{id}', [IngredientsController::class, 'update'])->name('ingredients.update');
    Route::get('/create_ingredient', [IngredientsController::class, 'create'])->name('ingredients.create');
    Route::post('/edit_ingredients', action: [IngredientsController::class, 'add'])->name('ingredients.add');
    Route::delete('/edit_ingredients/{id}', action: [IngredientsController::class, 'destroy'])->name('ingredients.destroy');

    Route::post('/ingredients/{id}/toggle', [IngredientsController::class, 'toggleActive'])->name('ingredients.toggle');
    // End of Ingredients

    // Esxtras
    Route::get('/extras', [ExtraController::class, 'extras'])->name('admin.extras');
    Route::get('/edit_extras/{id}', [ExtraController::class, 'edit'])->name('extras.edit');
    Route::put('/edit_extras/{id}', [ExtraController::class, 'update'])->name('extras.update');
    Route::get('/create_extras', [ExtraController::class, 'create'])->name('extras.create');
    Route::post('/edit_extras', action: [ExtraController::class, 'add'])->name('extras.add');
    Route::delete('/edit_extras/{id}', action: [ExtraController::class, 'destroy'])->name('extras.destroy');

    Route::post('/extras/{id}/toggle', [ExtraController::class, 'toggleActive'])->name('extras.toggle');
    // End of  Esxtras

    // Bread
    Route::get('/breads', [BreadController::class, 'breads'])->name('admin.breads');
    Route::get('/edit_breads/{id}', [BreadController::class, 'edit'])->name('breads.edit');
    Route::put('/edit_breads/{id}', [BreadController::class, 'update'])->name('breads.update');
    Route::get('/create_breads', [BreadController::class, 'create'])->name('breads.create');
    Route::post('/edit_breads', action: [BreadController::class, 'add'])->name('breads.add');
    Route::delete('/edit_breads/{id}', action: [BreadController::class, 'destroy'])->name('breads.destroy');

    Route::post('/breads/{id}/toggle', [BreadController::class, 'toggleActive'])->name('breads.toggle');
    // End of Bread

    // Orders
    Route::get('/show_orders', [OrderController::class, 'show'])->name('admin.show_orders');
    Route::get('/history_orders', [OrderController::class, 'show_history'])->name('admin.history_orders');
    Route::put('/orders/confirm_order/{order}', [OrderController::class, 'confirm_order'])->name('orders.confirm_order');
    Route::delete('/orders/history_delete/{id}', [OrderController::class, 'history_delete'])->name('history_orders.history_delete');
    Route::delete('/orders/delete/{id}', [OrderController::class, 'delete'])->name('orders.delete');
    Route::get('/orders/get_orders_data', [OrderController::class, 'getOrdersData'])->name('orders.get_orders_data');
    // End Of Orders

    Route::get('/admin/new_user/registration', [AuthController::class, 'showRegistrationForm'])->name('admin.registration');
    Route::post('/admin/new_user/registration', [AuthController::class, 'register'])->name('admin.register');


});

Route::get('/log_in', [AuthController::class, 'showLoginForm'])->name('login.show');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/order', [OrderController::class, 'showForm']);

Route::post('/order', [OrderController::class, 'submitForm']);



Route::get('/', [OrderController::class, 'pizza_tb']);

Route::get('/pizza_info/{id}', [OrderController::class, 'pizza_info']);

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');


Route::get('/cart/index', [CartController::class, 'showCart'])->name('cart');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');


Route::post('submit_order', [OrderController::class, 'submit_order'])->name('submit_order');


Route::get('contact', [PizzaController::class, 'show_contact'])->name('show_contact');







