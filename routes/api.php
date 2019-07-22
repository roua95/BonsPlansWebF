<?php

use Illuminate\Http\Request;

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
/////admin stuff
Route::get('getAllUsers', 'UserController@getAllUsers');
Route::get('showAllAdmins', 'UserController@showAllAdmins');

/////////////////////user registration and login
Route::post('register', 'UserController@register');

//Route::post('login', 'UserController@authenticate');
Route::get('open', 'DataController@open');
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');});

//not used anymore (mobile part is considering it)
Route::get('auth/{provider}', 'socialAuthController@redirect');
Route::get('auth/{provider}/callback', 'socialAuthController@Callback');

Route::group([
    'namespace' => 'Auth',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');
});

//////////////////////category CRUD routes

Route::post('/category/create', 'CategoryController@create');
Route::post('/category/delete', 'CategoryController@delete');
Route::put('/category/edit', 'CategoryController@edit');
Route::get('/category/index', 'CategoryController@index');
Route::get('/category/show', 'CategoryController@show');
Route::get('/category/getPlansByCategoryName', 'CategoryController@getPlansByCategoryName');


/////////////////////plan CRUD routes and other functionalities (like and favorite)


Route::post('/plan/create', 'PlanController@create');
Route::post('/plan/delete', 'PlanController@delete');
Route::put('/plan/update', 'PlanController@update');
Route::get('/plan/index', 'PlanController@index');
Route::get('/plan/show', 'PlanController@show');
Route::put('/plan/approve', 'PlanController@approve');
Route::get('/plan/showAllApprovedPlans', 'PlanController@showAllApprovedPlans');
Route::post('/plan/ratePlan', 'PlanController@ratePlan');
Route::put('/plan/changeRating', 'PlanController@changeRating');
Route::get('/plan/getFavoritePlans', 'PlanController@getFavoritePlans');
Route::get('/plan/getRecommandedPlans', 'PlanController@getRecommandedPlans');
Route::put('/plan/like', 'PlanController@like');
Route::put('/plan/unlike', 'PlanController@unlike');
Route::get('/plan/like/{id}', ['as' => 'plan.like', 'uses' => 'LikeController@likePlan']);
Route::post('/plan/addToFavorites', 'PlanController@addToFavorites');
Route::post('/plan/removeFromFavorites', 'PlanController@removeFromFavorites');
Route::get('/plan/favoriteCount', 'PlanController@favoriteCount');
Route::get('/plan/whoFavoritePlan', 'PlanController@whoFavoritePlan');
Route::get('/plan/isFavorited', 'PlanController@isFavorited');

////liking stuff
Route::post('/plan/like', 'PlanController@like');
Route::get('/plan/whoLikedThisPost', 'PlanController@whoLikedThisPost');
Route::get('/plan/isLikedByMe', 'PlanController@isLikedByMe');
Route::get('/plan/likesNumber', 'PlanController@likesNumber');
Route::get('/plan/getAllPlansLikedByUser', 'PlanController@getAllPlansLikedByUser');
Route::get('/plan/mostLikedPlans', 'PlanController@mostLikedPlans');


///////////////////comment CRUD routes

Route::post('/comment/create', 'CommentController@create');
Route::post('/comment/index', 'CommentController@index');
Route::post('/comment/show', 'CommentController@show');
Route::post('/comment/update', 'CommentController@update');
Route::post('/comment/destroy', 'CommentController@destroy');

////////favorite plans


Route::get('/favourite/index', 'UserController@getFavoritePlans');



///search per filter region/category
Route::get('/filter/region', 'PlanController@searchPlanByRegion');
Route::get('/filter/category', 'PlanController@searchPlanByCategorie');
Route::get('/filter/searchByClosestInCategory', 'PlanController@searchByClosestInCategory');
Route::get('/filter/searchPlanByName', 'PlanController@searchPlanByName');
Route::get('/filter/filterProximity', 'PlanController@filterProximity');

//share plans

Route::post('/share/shareOnFacebook', 'PlanController@shareOnFacebook');

///Image settings
Route::post('/image/create', 'ImageController@create');
Route::post('/image/delete', 'ImageController@delete');
Route::get('/image/index', 'ImageController@index');
Route::get('/image/show', 'ImageController@show');


// city settings
Route::post('/city/create', 'CityController@create');
Route::post('/city/index', 'CityController@index');


Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});
