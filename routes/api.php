<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\EmailController;
use App\Http\Controllers\Auth\ForgetResetPasswordController;
use App\Http\Controllers\Auth\LoginLogoutController;
use App\Http\Controllers\Auth\RegisterAndUserController;
use App\Http\Controllers\Auth\TwoFactorAuthenticatonController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\FollowPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostHistoryTypesController;
use App\Http\Controllers\PostsListsController;
use App\Http\Controllers\PostTypesController;
use App\Http\Controllers\SavePostController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserBadgesController;
use App\Http\Controllers\VoteTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix'=>'user', 'middleware' => 'api'], function(){
    Route::post('register', [RegisterAndUserController::class, 'register']);
    Route::post('email-login', [LoginLogoutController::class, 'loginByEmail']);
    Route::post('username-login', [LoginLogoutController::class, 'loginByUserName']);
    Route::post('multi-login', [LoginLogoutController::class, 'loginByIdOrUserNameOrEmail']);
    Route::post('logout', [LoginLogoutController::class, 'logout']);
    Route::post('get-user', [RegisterAndUserController::class, 'getUser']);
    Route::get('current-user', [RegisterAndUserController::class, 'getCurrentUser']);
    Route::put('update-account', [AccountController::class, 'updateAccount']);
    Route::put('update-displayname', [AccountController::class, 'updateDisplayName']);
    Route::put('update-username', [AccountController::class, 'updateUserName']);
    Route::get('verify-email/{id}', [EmailController::class, 'verify'])->name('verification.verify'); 
    Route::post('resend-email', [EmailController::class, 'resend'])->name('verification.resend');
    Route::post('enable-2fa', [TwoFactorAuthenticatonController::class, 'enable2FA']);
    Route::post('un-enable-2fa', [TwoFactorAuthenticatonController::class, 'diable2FA']);
    Route::post('login-2fa', [LoginLogoutController::class, 'loginWith2fa']);
    Route::post('forgetpassword', [ForgetResetPasswordController::class, 'forgetPassword']);
    Route::post('forget-password-by-email', [ForgetResetPasswordController::class, 'forgetPasswordByEmail']);
    Route::post('reset-password', [ForgetResetPasswordController::class, 'resetPassword']);
});

Route::group(['prefix'=> 'badge'], function () {
    Route::post('', [BadgeController::class,'create']);
    Route::put('', [BadgeController::class,'update']);
    Route::get('{id}', [BadgeController::class,'findById']);
    Route::delete('{id}', [BadgeController::class,'deleteById']);
    Route::get('', [BadgeController::class,'all']);
});

Route::group(['prefix'=> 'user-badge'], function () {
    Route::post('add-badge-to-user', [UserBadgesController::class,'addBadgeToUser']);
    Route::post('get-user-badge', [UserBadgesController::class,'isUserHasBadge']);
    Route::post('delete-user-badge', [UserBadgesController::class,'removeBadgeFromUser']);
    Route::get('{user_id}', [UserBadgesController::class,'getUserBadges']);
});

Route::group(['prefix'=> 'vote-type'], function () {
    Route::post('', [VoteTypeController::class,'addVoteType']);
    Route::put('', [VoteTypeController::class,'updateVoteType']);
    Route::get('{id}', [VoteTypeController::class,'findById']);
    Route::get('', [VoteTypeController::class,'all']);
    Route::delete('{id}', [VoteTypeController::class,'deleteById']);
});

Route::group(['prefix'=> 'post-types'], function () {
    Route::post('', [PostTypesController::class,'addPostType']);
    Route::put('', [PostTypesController::class,'updatePostType']);
    Route::get('{id}', [PostTypesController::class,'findById']);
    Route::get('', [PostTypesController::class,'all']);
    Route::delete('{id}', [PostTypesController::class,'deleteById']);
});

Route::group(['prefix'=> 'post'], function () {
    Route::post('', [PostController::class,'addPost']);
    Route::put('update-post', [PostController::class,'updatePost']);
    Route::put('update-post-title', [PostController::class,'updatePostTitle']);
    Route::put('update-post-body', [PostController::class,'updatePostBody']);
    Route::put('update-post-type', [PostController::class,'updatePostType']);
    Route::put('update-post-tile-body', [PostController::class,'updatePostTitleAndBody']);
    Route::get('{id}', [PostController::class,'findPostById']);
    Route::delete('{id}', [PostController::class,'deletePostById']);
    Route::get('', [PostController::class,'allPosts']);
    Route::get('user/{id_user_name_email}', [PostController::class,'userPosts']);
    //
    Route::post('follow/{post_id}', [FollowPostController::class,'followPost']);
    Route::delete('unfollow/{post_id}', [FollowPostController::class,'unFollowPost']);
    Route::get('is-followed/{post_id}', [FollowPostController::class,'isUserFollowingPost']);
});


Route::group(['prefix'=> 'follow-post'], function () {
    Route::get('', [FollowPostController::class,'findUserFollowingPosts']);
    Route::get('post/{id}', [FollowPostController::class,'findPostFollowingUsers']);
});

Route::group(['prefix'=> 'posts-lists'], function () {
    Route::post('', [PostsListsController::class,'create']);
    Route::put('', [PostsListsController::class,'update']);
    Route::get('{id}', [PostsListsController::class,'findById']);
    Route::delete('{id}', [PostsListsController::class,'deleteById']);
    Route::get('', [PostsListsController::class,'userLists']);
});

Route::group(['prefix'=> 'saved-posts'], function () {
    Route::post('', [SavePostController::class,'savePost']);
    Route::get('{id}', [SavePostController::class,'findSavedPostById']);
    Route::delete('{id}', [SavePostController::class,'unSavePost']);
    Route::get('', [SavePostController::class,'findUserSavedPosts']);
    Route::get('list/{id}', [SavePostController::class,'findUserSavedPostsByListId']);
});

Route::group(['prefix'=> 'tags'], function () {
    Route::post('', [TagsController::class,'create']);
    Route::put('', [TagsController::class,'update']);
    Route::get('{id}', [TagsController::class,'findById']);
    Route::delete('{id}', [TagsController::class,'deleteById']);
    Route::get('', [TagsController::class,'all']);
});

Route::group(['prefix'=> 'post-history-types'], function () {
    Route::post('', [PostHistoryTypesController::class,'create']);
    Route::put('', [PostHistoryTypesController::class,'update']);
    Route::get('{id}', [PostHistoryTypesController::class,'findById']);
    Route::delete('{id}', [PostHistoryTypesController::class,'deleteById']);
    Route::get('', [PostHistoryTypesController::class,'all']);
});