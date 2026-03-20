
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordRecoveryController;
use App\Http\Controllers\Api\UserProfileController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Password reset
    Route::post('/forget- assword', [PasswordRecoveryController::class,'sendResetLinkEmail']);
    Route::post('/forget-password/verify/{token}/mail/{email}', [PasswordRecoveryController::class,'showResetPasswordForm']);
    Route::post('/password-reset', [PasswordRecoveryController::class,'submitResetPasswordForm']);

    // Social login
    // Route::get('login/{provider}', [SocialController::class, 'redirect']);
    // Route::get('login/callback/{provider}', [SocialController::class, 'callback']);

    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::get('detail/{email}', [AuthController::class, 'FindByEmail']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);

        Route::get('/profile', [UserProfileController::class, 'userProfile']);
        Route::get('/profile-image', [UserProfileController::class, 'ProfileImg']);
        Route::post('/profile-image/update', [UserProfileController::class, 'ProfileImgUpdate']);
        Route::post('/chanage-password', [UserProfileController::class, 'ChangePassword']);
        Route::post('/profile/update', [UserProfileController::class, 'ProfileUpdate']);
        Route::post('/fileupload', [UserProfileController::class, 'fileupload']);

        // Two-factor-authentication
        // Route::post('/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store']);
        // Route::post('/two-factor-authentication-destroy', [TwoFactorAuthenticationController::class, 'destroy']);
        // Route::post('/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show']);
        // Route::post('/two-factor-confirm', [ConfirmedTwoFactorAuthenticationController::class, 'store']);
    });
});
