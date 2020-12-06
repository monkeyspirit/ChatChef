<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['middleware'=>['language']], function (){
    Route::get('/lang/{lang}',['as'=>'setLang', 'uses'=>'LangController@changeLanguage']);

    Route::get('/', ['as'=>'home', 'uses'=>'FrontController@getHome'] );
    Route::get('/account_settings', ['as'=>'account_settings', 'uses'=>'FrontController@getSetting'] );
    Route::get('/account_all_recipes', ['as'=>'account_all_recipes', 'uses'=>'FrontController@getAll'] );
    Route::get('/account_favorites', ['as'=>'account_favorites', 'uses'=>'FrontController@getFav'] );
    Route::get('/recipe_view/{id}', ['as'=>'recipe_view', 'uses'=>'FrontController@getRecipe'] );
    Route::get('/insert', ['as'=>'insert', 'uses'=>'FrontController@getInsert'] );
    Route::get('/edit/{id}', ['as'=>'edit', 'uses'=>'FrontController@getEdit'] );
    Route::get('/delete/{id}', ['as'=>'delete', 'uses'=>'FrontController@getDelete'] );

    Route::get('/search',['as' => 'search', 'uses'=>'FrontController@getSearch']);
    Route::get('/search/{n}',['as' => 'searchType', 'uses'=>'RecipeController@getSearchType']);
    Route::get('/search_advanced/{array}',['as' => 'search_advanced_get', 'uses'=>'FrontController@getSearchResult']);

    Route::get('/approved',['as' => 'approved', 'uses'=>'FrontController@getApproved']);

    Route::get('/credits',['as' => 'credits', 'uses'=>'FrontController@getCredits']);
    Route::get('/review',['as' => 'review', 'uses'=>'FrontController@getReview']);
    Route::get('/account_management',['as' => 'account_management', 'uses'=>'FrontController@getManagement']);

    Route::get('/forgot',['as'=>'forgot', 'uses'=>'FrontController@getForgotScreen']);
    Route::post('/forgot',['as'=>'forgot', 'uses'=>'WebUserController@forgotPassword']);


    Route::get('/register', ['as' => 'register', 'uses' => 'FrontController@error']);
    Route::post('/register', ['as' => 'register', 'uses' => 'AuthController@registration']);

    Route::get('/login', ['as' => 'login', 'uses' => 'FrontController@error']);
    Route::post('/login', ['as' => 'login', 'uses' => 'AuthController@login']);

    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    Route::get('/logout_home', ['as' => 'logout_home', 'uses' => 'AuthController@logoutHome']);

    Route::get('/change_password/{id}', ['as' => 'change_password', 'uses' => 'FrontController@error']);
    Route::post('/change_password/{id}', ['as' => 'change_password', 'uses' => 'WebUserController@changePassword']);

    Route::get('/change_information/{id}', ['as' => 'change_information', 'uses' => 'FrontController@error']);
    Route::post('/change_information/{id}', ['as' => 'change_information', 'uses' => 'WebUserController@changeInformation']);

    Route::get('/change_role', ['as' => 'change_role', 'uses' => 'FrontController@error']);
    Route::post('/change_role', ['as' => 'change_role', 'uses' => 'WebUserController@changeRole']);

    Route::get('/unban', ['as' => 'unban', 'uses' => 'FrontController@error']);
    Route::post('/unban', ['as' => 'unban', 'uses' => 'WebUserController@unbanUser']);

    Route::get('/ban', ['as' => 'ban', 'uses' => 'FrontController@error']);
    Route::post('/ban', ['as' => 'ban', 'uses' => 'WebUserController@banUser']);

    Route::get('/changeImageUser', ['as' => 'changeImageUser', 'uses' => 'FrontController@error']);
    Route::post('/changeImageUser', ['as' => 'changeImageUser', 'uses' => 'WebUserController@changeImageUser']);

    Route::get('/insert_recipe', ['as' => 'insert_recipe', 'uses' => 'FrontController@error']);
    Route::post('/insert_recipe', ['as' => 'insert_recipe', 'uses' => 'RecipeController@addRecipe']);

    Route::get('/edit_recipe/{id}', ['as' => 'edit_recipe', 'uses' => 'FrontController@error']);
    Route::post('/edit_recipe/{id}', ['as' => 'edit_recipe', 'uses' => 'RecipeController@editRecipe']);

    Route::get('/delete_recipe/{id}', ['as'=>'delete_recipe', 'uses'=>'RecipeController@deleteRecipe'] );

    Route::get('/favoriteAdd', ['as'=>'favoriteAdd','uses'=>'FrontController@error']);
    Route::post('/favoriteAdd', ['as'=>'favoriteAdd','uses'=>'RecipeController@addFavorite']);

    Route::get('/favoriteRemove', ['as'=>'favoriteRemove','uses'=>'FrontController@error']);
    Route::post('/favoriteRemove', ['as'=>'favoriteRemove','uses'=>'RecipeController@removeFavorite']);

    Route::get('/search_advanced',['as' => 'search_advanced', 'uses'=>'FrontController@error']);
    Route::post('/search_advanced',['as' => 'search_advanced', 'uses'=>'RecipeController@getSearchResult']);

    Route::get('/search_simple',['as' => 'search_simple', 'uses'=>'FrontController@error']);
    Route::post('/search_simple',['as' => 'search_simple', 'uses'=>'RecipeController@getSimpleSearchResult']);

    Route::get('/acceptRecipe', ['as'=>'acceptRecipe','uses'=>'FrontController@error']);
    Route::post('/acceptRecipe', ['as'=>'acceptRecipe','uses'=>'RecipeController@acceptRecipe']);

    Route::get('/declineRecipe', ['as'=>'declineRecipe','uses'=>'FrontController@error']);
    Route::post('/declineRecipe', ['as'=>'declineRecipe','uses'=>'RecipeController@declineRecipe']);

    Route::get('/correctRecipe', ['as'=>'correctRecipe','uses'=>'FrontController@error']);
    Route::post('/correctRecipe', ['as'=>'correctRecipe','uses'=>'RecipeController@correctRecipe']);

    Route::get('/reviewRecipe', ['as'=>'reviewRecipe','uses'=>'FrontController@error']);
    Route::post('/reviewRecipe', ['as'=>'reviewRecipe','uses'=>'RecipeController@reviewRecipe']);

    Route::get('/insert_comment/{id}', ['as' => 'insert_comment', 'uses' => 'FrontController@error']);
    Route::post('/insert_comment/{id}', ['as' => 'insert_comment', 'uses' => 'CommentController@insertComment']);

    Route::post('/thereIs',['as'=>'thereIs','uses'=>'AuthController@thereIsThatUser']);

    Route::post('/auth',['as'=>'auth','uses'=>'AuthController@auhtenticateUser']);
});


