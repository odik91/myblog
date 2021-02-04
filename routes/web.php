<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('article.index');
});

Auth::routes();


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'isAdmin']], function() {
    Route::get('/home', 'HomeController@index')->name('home');

    // Category
    Route::resource('categories', 'CategoriesController');
    Route::get('/trash/categories', 'CategoriesController@trash')->name('categories.trash');
    Route::get('/restore/categories/{id}', 'CategoriesController@trashRestore')->name('categories.restore');
    Route::delete('/remove/categories/{id}', 'CategoriesController@destroyItem')->name('categories.remove');

    // Subcategories
    Route::resource('subcategories', 'SubcategoryController');
    Route::get('/trash/subcategories', 'SubcategoryController@trash')->name('subcategories.trash');
    Route::get('/restore/subcategories/{id}', 'SubcategoryController@trashRestore')->name('subcategories.restore');
    Route::delete('/remove/subcategories/{id}', 'SubcategoryController@destroyItem')->name('subcategories.remove');

    // Post
    Route::resource('posts', 'PostController');
    Route::get('/ajax-subcategories/{id}', 'PostController@loadSubcategory');
    Route::post('/ajax-test/{id}', 'PostController@ajaxTest');
    Route::get('/trash/posts', 'PostController@trash')->name('posts.trash');
    Route::get('/restore/posts/{id}', 'PostController@trashRestore')->name('posts.restore');
    Route::delete('/remove/posts/{id}', 'PostController@destroyItem')->name('posts.remove');
    Route::post('/ajaxUploadImage', 'PostController@ajaxUploadImage')->name('ajax.upload');
    Route::post('/ajaxDeleteImage', 'PostController@ajaxDeleteImage')->name('ajax.delete');
    Route::post('/uploadImage', 'PostController@uploadImage')->name('upload.image');

    // Role
    Route::resource('role', 'RoleController');
    Route::get('roles/trash', 'RoleController@trash')->name('role.trash');
    Route::get('roles/trash/restore/{id}', 'RoleController@trashRestore')->name('role.restore');
    Route::delete('roles/{id}', 'RoleController@trashRemove')->name('role.remove');

    // Users
    Route::resource('users', 'UsersController');
    Route::get('user/trash', 'UsersController@userTrash')->name('users.trash');
    Route::get('user/restore/{id}', 'UsersController@trashRestore')->name('users.restore');
    Route::delete('user/trash/{id}', 'UsersController@destroyItem')->name('users.remove');

    // Message
    Route::get('message', 'MessageController@index')->name('message.index');
    Route::get('message/{id}/read', 'MessageController@read')->name('message.read');
    Route::post('message/next-message-page', 'MessageController@nextPage')->name('message.nextPage');
    Route::delete('message/{id}/delete', 'MessageController@delete')->name('message.deleteing');

    // message trash
    Route::get('message/trash', 'MessageController@trash')->name('message.trash');    
    Route::post('message/trash/restore', 'MessageController@restoreMessage')->name('message.restoreMessage');
    Route::post('message/next-trash-page', 'MessageController@nextTrashPage')->name('message.nextTrashPage');

    Route::post('message/next-page-inbox', 'MessageController@nextPageInbox')->name('message.nextPageInbox');
    Route::post('message/delete', 'MessageController@deleteMessage')->name('message.delete');
    Route::post('message/reply', 'MessageController@replyMessage')->name('message.reply');
    Route::post('message/send-multy', 'MessageController@sendMulty')->name('message.sendMulty');
    Route::post('message/sending-multy', 'MessageController@sendingMulty')->name('message.sendingMulty');
    Route::get('message/compose', 'MessageController@compose')->name('message.compose');
    Route::post('message/send-mail', 'MessageController@send')->name('message.send');
    Route::post('message/drafts-mail', 'MessageController@toDrafts')->name('message.drafts');
    Route::get('message/forward/{id}', 'MessageController@forward')->name('message.forward');
    Route::get('message/{id}/star', 'MessageController@star')->name('message.star');
    Route::post('message/mark-as-read', 'MessageController@markRead')->name('message.markRead');
    Route::post('message/count', 'MessageController@checkInboxCount')->name('message.inboxCount');
    Route::get('message/sent', 'MessageController@sent')->name('message.sent');
    Route::post('message/next-sent-page', 'MessageController@nextSentPage')->name('message.nextSentPage');
    Route::get('message/{id}/edit', 'MessageController@editMessage')->name('message.editMessage');
    Route::get('message/drafts', 'MessageController@drafts')->name('message.drafts');
    Route::post('message/next-drafts-page', 'MessageController@nextDraftsPage')->name('message.nextDraftsPage');

    // menu route
    Route::resource('menu', 'MenuController');
    Route::get('menus/trash', 'MenuController@trash')->name('menu.trash');
    Route::get('menus/{id}/restore', 'MenuController@restoreMenu')->name('menu.restore');
    Route::delete('menus/{id}/delete', 'MenuController@delete')->name('menu.delete');

    // submenu route
    Route::resource('submenu', 'SubmenuController');
    Route::get('/submenus/trash', 'SubmenuController@trash')->name('submenu.trash');
    Route::get('/submenus/{id}/restore', 'SubmenuController@restoreSubmenu')->name('submenu.restore');
    Route::delete('/submenus/{id}/delete', 'SubmenuController@deleteSubmenu')->name('submenu.delete');
    
    // permission
    Route::resource('permission', 'PermissionController');

    // comments
    Route::get('/comment', 'CommentController@index')->name('comment.index');
    Route::get('/comment/reply/{id}', 'CommentController@getReply')->name('comment.getreply');
    Route::delete('/comment/destroy/{id}', 'CommentController@destroy')->name('comment.destroy');
});

// public pages
Route::prefix('blog')->group(function () {
    Route::resource('article', 'BlogingController');
    Route::get('article/{slug}/view', 'BlogingController@singlePage')->name('article.view');
    Route::get('article/category/{slug}', 'BlogingController@postByCategory')->name('article.category');
    Route::get('article/subcategory/{id}', 'BlogingController@postBySubategory')->name('article.subcategory');
    Route::post('articles/test/ajax', 'BlogingController@loadArticleData')->name('article.loadData');
    Route::post('articles/test/ajax', 'BlogingController@loadArticleData')->name('article.loadData');
    Route::post('articles/category/post', 'BlogingController@loadArticleCategory')->name('article.loadDataCategory');
    Route::get('articles/{year}/{month}/archive', 'BlogingController@postArchive')->name('article.archive');
    Route::post('articles/archive/post', 'BlogingController@loadPostArchive')->name('article.loadArchive');
    Route::post('articles/comment/reply', 'BlogingController@postReplay')->name('article.replay');
    Route::get('articles/search/', 'BlogingController@searchQuery')->name('article.search');
    Route::get('articles/about', 'BlogingController@about')->name('article.about');
    Route::get('articles/contact', 'BlogingController@contact')->name('article.contact');
    Route::post('articles/contact', 'BlogingController@sendMessage')->name('article.sendMessage');
});