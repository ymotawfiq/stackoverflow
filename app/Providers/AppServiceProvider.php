<?php

namespace App\Providers;

use App\Repositories\BadgeRepository\BadgeRepository;
use App\Repositories\BadgeRepository\BadgeRepositoryInterface;
use App\Repositories\FollwPostRepository\FollowPostRepository;
use App\Repositories\FollwPostRepository\FollowPostRepositoryInterface;
use App\Repositories\PostRepository\PostRepository;
use App\Repositories\PostRepository\PostRepositoryInterface;
use App\Repositories\PostsListsRepository\PostListRepository;
use App\Repositories\PostsListsRepository\PostListRepositoryInterface;
use App\Repositories\PostTypeRepository\PostTypeRepository;
use App\Repositories\PostTypeRepository\PostTypeRepositoryInterface;
use App\Repositories\SavePostRepository\SavePostRepository;
use App\Repositories\SavePostRepository\SavePostRepositoryInterface;
use App\Repositories\TagsRepository\TagsRepository;
use App\Repositories\TagsRepository\TagsRepositoryInterface;
use App\Repositories\UserBadgeRepository\UserBadgeRepository;
use App\Repositories\UserBadgeRepository\UserBadgeRepositoryInterface;
use App\Repositories\VoteTypeRepository\VoteTypeRepository;
use App\Repositories\VoteTypeRepository\VoteTypeRepositoryInterface;
use App\Services\AuthService\AccountService\AccountService;
use App\Services\AuthService\AccountService\AccountServiceInterface;
use App\Services\AuthService\EmailService\EmailService;
use App\Services\AuthService\EmailService\EmailServiceInterface;
use App\Services\AuthService\ForgetResetPasswordService\ForgetResetPasswordService;
use App\Services\AuthService\ForgetResetPasswordService\ForgetResetPasswordServiceInterface;
use App\Services\AuthService\LoginLogoutService\LoginLogoutService;
use App\Services\AuthService\LoginLogoutService\LoginLogoutServiceInterface;
use App\Services\AuthService\RegisterUserService\RegisterUserService;
use App\Services\AuthService\RegisterUserService\RegisterUserServiceInterface;
use App\Services\AuthService\RolesService\RolesService;
use App\Services\AuthService\RolesService\RolesServiceInterface;
use App\Services\AuthService\TokenService\TokenService;
use App\Services\AuthService\TokenService\TokenServiceInterface;
use App\Services\AuthService\TwoFactorAuthenticationService\TwoFactorAuthenticationService;
use App\Services\AuthService\TwoFactorAuthenticationService\TwoFactorAuthenticationServiceInterface;
use App\Services\BadgeService\BadgeService;
use App\Services\BadgeService\BadgeServiceInterface;
use App\Services\FollwPostService\FollowPostService;
use App\Services\FollwPostService\FollowPostServiceInterface;
use App\Services\PostService\PostService;
use App\Services\PostService\PostServiceInterface;
use App\Services\PostsListsService\PostListService;
use App\Services\PostsListsService\PostListServiceInterface;
use App\Services\PostTypeService\PostTypeService;
use App\Services\PostTypeService\PostTypeServiceInterface;
use App\Services\SavePostService\SavePostService;
use App\Services\SavePostService\SavePostServiceInterface;
use App\Services\TagsService\TagsService;
use App\Services\TagsService\TagsServiceInterface;
use App\Services\UserBadgeService\UserBadgeService;
use App\Services\UserBadgeService\UserBadgeServiceInterface;
use App\Services\VoteTypeService\VoteTypeService;
use App\Services\VoteTypeService\VoteTypeServiceInterface;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // services
        $this->app->bind(EmailServiceInterface::class, EmailService::class);
        $this->app->bind(RolesServiceInterface::class, RolesService::class);
        $this->app->bind(LoginLogoutServiceInterface::class, LoginLogoutService::class);
        $this->app->bind(RegisterUserServiceInterface::class, RegisterUserService::class);
        $this->app->bind(TwoFactorAuthenticationServiceInterface::class, TwoFactorAuthenticationService::class);
        $this->app->bind(ForgetResetPasswordServiceInterface::class, ForgetResetPasswordService::class);
        $this->app->bind(TokenServiceInterface::class, TokenService::class);
        $this->app->bind(AccountServiceInterface::class, AccountService::class);
        $this->app->bind(BadgeServiceInterface::class, BadgeService::class);
        $this->app->bind(UserBadgeServiceInterface::class, UserBadgeService::class);
        $this->app->bind(PostTypeServiceInterface::class, PostTypeService::class);
        $this->app->bind(VoteTypeServiceInterface::class, VoteTypeService::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(FollowPostServiceInterface::class, FollowPostService::class);
        $this->app->bind(PostListServiceInterface::class, PostListService::class);
        $this->app->bind(SavePostServiceInterface::class, SavePostService::class);
        $this->app->bind(TagsServiceInterface::class, TagsService::class);
        // repositories
        $this->app->bind(BadgeRepositoryInterface::class, BadgeRepository::class);
        $this->app->bind(UserBadgeRepositoryInterface::class, UserBadgeRepository::class);
        $this->app->bind(VoteTypeRepositoryInterface::class, VoteTypeRepository::class);
        $this->app->bind(PostTypeRepositoryInterface::class, PostTypeRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(FollowPostRepositoryInterface::class, FollowPostRepository::class);
        $this->app->bind(PostListRepositoryInterface::class, PostListRepository::class);
        $this->app->bind(SavePostRepositoryInterface::class, SavePostRepository::class);
        $this->app->bind(TagsRepositoryInterface::class, TagsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
