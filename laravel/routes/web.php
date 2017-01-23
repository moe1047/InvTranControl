<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('test', function(){
    return \App\Sale::find(21)->user;
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');

    Route::get('/items', function () {
        return \App\Item::select('name','id','qty','alert_qty')->get();
    });
    Route::get('/customers', function () {
        return \App\People::where('type','customer')->pluck('name','id');
    });
    Route::get('/drivers', function () {
        return \App\People::where('type','driver')->pluck('name','id');
    });
    Route::get('/branches', function () {
        return \App\People::where('type','branch')->pluck('name','id');
    });
    Route::get("item/all","ItemController@all");
    Route::get("item/summary","ItemController@summary");
    Route::post("item/create","ItemController@create")->middleware(['sales']);
    Route::post("category/create","ItemController@createCategory")->middleware(['sales']);
    Route::post("item/{id}/delete","ItemController@delete")->middleware(['sales']);
    Route::get("item/categories","ItemController@categories")->middleware(['sales']);

    Route::get("item/category/{id}/edit","ItemController@category_edit")->middleware(['sales']);
    Route::post("item/category/{id}/update","ItemController@category_update")->name('category.update')->middleware(['sales']);

    Route::get("item/{id}/edit","ItemController@edit")->middleware(['sales']);
    Route::post("item/{id}/update","ItemController@update")->name('item.update')->middleware(['sales']);

    Route::get("users/all","HomeController@users")->middleware(['owner']);
    Route::get("users/{id}/activate","HomeController@activate")->middleware(['owner']);
    Route::get("users/{id}/deactivate","HomeController@deactivate")->middleware(['owner']);
    Route::get("users/{id}/delete","HomeController@delete")->middleware(['owner']);

    Route::get("sale/{id}/complete","SaleController@complete")->middleware(['sales']);
    Route::get("sale/{id}/cancelRemaining","SaleController@cancelRemaining")->middleware(['sales']);
    Route::post("sale/complete","SaleController@completePost")->middleware(['sales']);

    Route::get("sale/search","SaleController@search");
    Route::get("sale/{id}/print","SaleController@printt");
    Route::get("sale/{id}/delete","SaleController@delete")->middleware(['sales']);
    Route::get("sale/{id}/detail","SaleController@detail")->middleware(['sales']);
    Route::get("saleitems",function(){
        return \App\Sale::find(6)->saleItems()->where('item_id',4)->get();
    });
    Route::resource("sale","SaleController");
    Route::get("purchase/{id}/detail","PurchaseController@detail")->middleware(['sales']);
    Route::get("purchase/search","PurchaseController@search");
    Route::post("purchase/{id}/delete","PurchaseController@delete")->middleware(['sales']);
    Route::resource("purchase","PurchaseController");
    Route::post('people/{id}/delete', 'PeopleController@delete')->middleware(['sales']);
    Route::get('people/{id}/edit', 'PeopleController@edit')->middleware(['sales']);
    Route::post('people/{id}/update', 'PeopleController@update')->name('peoplee.update')->middleware(['sales']);
    Route::get('people/customers', 'PeopleController@customers');
    Route::post('people/customers/create', 'PeopleController@postCustomer')->middleware(['sales']);
    Route::get('people/drivers', 'PeopleController@drivers');
    Route::post('people/drivers/create', 'PeopleController@postDriver')->middleware(['sales']);
    Route::get('people/branches', 'PeopleController@branches');
    Route::post('people/branches/create', 'PeopleController@postBranch')->middleware(['sales']);
    Route::resource("people","PeopleController");
});
// for dropdown Ajax request



/*Route::get('/sale', function () {
    return view("sale");
});*/

Auth::routes();


