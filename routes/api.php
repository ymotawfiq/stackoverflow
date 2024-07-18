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
use App\Http\Controllers\PostTypesController;
use App\Http\Controllers\UserBadgesController;
use App\Http\Controllers\VoteTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix'=>'user', 'middleware' => 'api'], function(){
    Route::post('register', [RegisterAndUserController::class, 'register']);
    Route::post('email_login', [LoginLogoutController::class, 'login_by_email']);
    Route::post('user_name_login', [LoginLogoutController::class, 'login_by_user_name']);
    Route::post('multi_login', [LoginLogoutController::class, 'login_by_id_user_name_or_email']);
    Route::post('logout', [LoginLogoutController::class, 'logout']);
    Route::post('get_user', [RegisterAndUserController::class, 'get_user']);
    Route::get('current_user', [RegisterAndUserController::class, 'get_current_user']);
    Route::put('update_account', [AccountController::class, 'update_account']);
    Route::put('update_display_name', [AccountController::class, 'update_display_name']);
    Route::put('update_user_name', [AccountController::class, 'update_user_name']);
    Route::get('verify_email/{id}', [EmailController::class, 'verify'])->name('verification.verify'); 
    Route::post('resend_email', [EmailController::class, 'resend'])->name('verification.resend');
    Route::post('enable_2fa', [TwoFactorAuthenticatonController::class, 'enable_two_factor_authentication']);
    Route::post('un_enable_2fa', [TwoFactorAuthenticatonController::class, 'un_enable_two_factor_authentication']);
    Route::post('login_2fa', [LoginLogoutController::class, 'login_with_2fa']);
    Route::post('forget_password', [ForgetResetPasswordController::class, 'forget_password']);
    Route::post('forget_password_by_email', [ForgetResetPasswordController::class, 'forget_password_by_email']);
    Route::post('reset_password', [ForgetResetPasswordController::class, 'reset_password']);
});

Route::group(['prefix'=> 'badge'], function () {
    Route::post('', [BadgeController::class,'create']);
    Route::put('', [BadgeController::class,'update']);
    Route::get('{id}', [BadgeController::class,'find_by_id']);
    Route::delete('{id}', [BadgeController::class,'delete_by_id']);
    Route::get('', [BadgeController::class,'all']);
});

Route::group(['prefix'=> 'user_badge'], function () {
    Route::post('add_badge_to_user', [UserBadgesController::class,'add_badge_to_user']);
    Route::post('get_user_badge', [UserBadgesController::class,'is_user_has_badge']);
    Route::post('delete_user_badge', [UserBadgesController::class,'remove_badge_from_user']);
    Route::get('user_padges/{user_id}', [UserBadgesController::class,'get_user_badges']);
});

Route::group(['prefix'=> 'vote_type'], function () {
    Route::post('', [VoteTypeController::class,'add_vote_type']);
    Route::put('', [VoteTypeController::class,'update_vote_type']);
    Route::get('{id}', [VoteTypeController::class,'find_vote_type_by_id']);
    Route::get('', [VoteTypeController::class,'all']);
    Route::delete('{id}', [VoteTypeController::class,'delete_vote_type_by_id']);
});

Route::group(['prefix'=> 'post_types'], function () {
    Route::post('', [PostTypesController::class,'add_post_type']);
    Route::put('', [PostTypesController::class,'update_post_type']);
    Route::get('{id}', [PostTypesController::class,'find_post_type_by_id']);
    Route::get('', [PostTypesController::class,'all']);
    Route::delete('{id}', [PostTypesController::class,'delete_post_type_by_id']);
});

Route::group(['prefix'=> 'post'], function () {
    Route::post('', [PostController::class,'add_post']);
    Route::put('update_post', [PostController::class,'update_post']);
    Route::put('update_post_title', [PostController::class,'update_post_title']);
    Route::put('update_post_body', [PostController::class,'update_post_body']);
    Route::put('update_post_type', [PostController::class,'update_post_type']);
    Route::put('update_post_tile_body', [PostController::class,'update_post_title_body']);
    Route::get('{id}', [PostController::class,'find_post_by_id']);
    Route::delete('{id}', [PostController::class,'delete_post_by_id']);
    Route::get('', [PostController::class,'all_posts']);
    Route::get('user/{id_user_name_email}', [PostController::class,'user_posts']);
    //
    Route::post('follow/{post_id}', [FollowPostController::class,'follow_post']);
    Route::delete('unfollow/{post_id}', [FollowPostController::class,'un_follow_post']);
    Route::get('isfollowed/{post_id}', [FollowPostController::class,'is_user_following_post']);
});


Route::group(['prefix'=> 'follow_post'], function () {
    Route::get('', [FollowPostController::class,'find_user_following_posts']);
    Route::get('post/{id}', [FollowPostController::class,'find_post_following_users']);
});

