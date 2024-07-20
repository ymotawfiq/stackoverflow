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
    Route::post('email-login', [LoginLogoutController::class, 'login_by_email']);
    Route::post('username-login', [LoginLogoutController::class, 'login_by_user_name']);
    Route::post('multi-login', [LoginLogoutController::class, 'login_by_id_user_name_or_email']);
    Route::post('logout', [LoginLogoutController::class, 'logout']);
    Route::post('get-user', [RegisterAndUserController::class, 'get_user']);
    Route::get('current-user', [RegisterAndUserController::class, 'get_current_user']);
    Route::put('update-account', [AccountController::class, 'update_account']);
    Route::put('update-displayname', [AccountController::class, 'update_display_name']);
    Route::put('update-username', [AccountController::class, 'update_user_name']);
    Route::get('verify-email/{id}', [EmailController::class, 'verify'])->name('verification.verify'); 
    Route::post('resend-email', [EmailController::class, 'resend'])->name('verification.resend');
    Route::post('enable-2fa', [TwoFactorAuthenticatonController::class, 'enable_two_factor_authentication']);
    Route::post('un-enable-2fa', [TwoFactorAuthenticatonController::class, 'un_enable_two_factor_authentication']);
    Route::post('login-2fa', [LoginLogoutController::class, 'login_with_2fa']);
    Route::post('forgetpassword', [ForgetResetPasswordController::class, 'forget_password']);
    Route::post('forget-password-by-email', [ForgetResetPasswordController::class, 'forget_password_by_email']);
    Route::post('reset-password', [ForgetResetPasswordController::class, 'reset_password']);
});

Route::group(['prefix'=> 'badge'], function () {
    Route::post('', [BadgeController::class,'create']);
    Route::put('', [BadgeController::class,'update']);
    Route::get('{id}', [BadgeController::class,'find_by_id']);
    Route::delete('{id}', [BadgeController::class,'delete_by_id']);
    Route::get('', [BadgeController::class,'all']);
});

Route::group(['prefix'=> 'user-badge'], function () {
    Route::post('add-badge-to-user', [UserBadgesController::class,'add_badge_to_user']);
    Route::post('get-user-badge', [UserBadgesController::class,'is_user_has_badge']);
    Route::post('delete-user-badge', [UserBadgesController::class,'remove_badge_from_user']);
    Route::get('user-padges/{user_id}', [UserBadgesController::class,'get_user_badges']);
});

Route::group(['prefix'=> 'vote-type'], function () {
    Route::post('', [VoteTypeController::class,'add_vote_type']);
    Route::put('', [VoteTypeController::class,'update_vote_type']);
    Route::get('{id}', [VoteTypeController::class,'find_vote_type_by_id']);
    Route::get('', [VoteTypeController::class,'all']);
    Route::delete('{id}', [VoteTypeController::class,'delete_vote_type_by_id']);
});

Route::group(['prefix'=> 'post-types'], function () {
    Route::post('', [PostTypesController::class,'add_post_type']);
    Route::put('', [PostTypesController::class,'update_post_type']);
    Route::get('{id}', [PostTypesController::class,'find_post_type_by_id']);
    Route::get('', [PostTypesController::class,'all']);
    Route::delete('{id}', [PostTypesController::class,'delete_post_type_by_id']);
});

Route::group(['prefix'=> 'post'], function () {
    Route::post('', [PostController::class,'add_post']);
    Route::put('update-post', [PostController::class,'update_post']);
    Route::put('update-post-title', [PostController::class,'update_post_title']);
    Route::put('update-post-body', [PostController::class,'update_post_body']);
    Route::put('update-post-type', [PostController::class,'update_post_type']);
    Route::put('update-post-tile-body', [PostController::class,'update_post_title_body']);
    Route::get('{id}', [PostController::class,'find_post_by_id']);
    Route::delete('{id}', [PostController::class,'delete_post_by_id']);
    Route::get('', [PostController::class,'all_posts']);
    Route::get('user/{id_user_name_email}', [PostController::class,'user_posts']);
    //
    Route::post('follow/{post_id}', [FollowPostController::class,'follow_post']);
    Route::delete('unfollow/{post_id}', [FollowPostController::class,'un_follow_post']);
    Route::get('is-followed/{post_id}', [FollowPostController::class,'is_user_following_post']);
});


Route::group(['prefix'=> 'follow-post'], function () {
    Route::get('', [FollowPostController::class,'find_user_following_posts']);
    Route::get('post/{id}', [FollowPostController::class,'find_post_following_users']);
});

Route::group(['prefix'=> 'posts-lists'], function () {
    Route::post('', [PostsListsController::class,'create']);
    Route::put('', [PostsListsController::class,'update']);
    Route::get('{id}', [PostsListsController::class,'find_by_id']);
    Route::delete('{id}', [PostsListsController::class,'delete_by_id']);
    Route::get('', [PostsListsController::class,'user_lists']);
});

Route::group(['prefix'=> 'saved-posts'], function () {
    Route::post('', [SavePostController::class,'save_post']);
    Route::get('{id}', [SavePostController::class,'find_saved_post_by_id']);
    Route::delete('{id}', [SavePostController::class,'us_save_post']);
    Route::get('', [SavePostController::class,'find_user_saved_posts']);
    Route::get('list/{id}', [SavePostController::class,'find_user_saved_posts_by_list_id']);
});

Route::group(['prefix'=> 'tags'], function () {
    Route::post('', [TagsController::class,'create']);
    Route::put('', [TagsController::class,'update']);
    Route::get('{id}', [TagsController::class,'find_by_id']);
    Route::delete('{id}', [TagsController::class,'delete_by_id']);
    Route::get('', [TagsController::class,'all']);
});

Route::group(['prefix'=> 'history-types'], function () {
    Route::post('', [PostHistoryTypesController::class,'create']);
    Route::put('', [PostHistoryTypesController::class,'update']);
    Route::get('{id}', [PostHistoryTypesController::class,'find_by_id']);
    Route::delete('{id}', [PostHistoryTypesController::class,'delete_by_id']);
    Route::get('', [PostHistoryTypesController::class,'all']);
});