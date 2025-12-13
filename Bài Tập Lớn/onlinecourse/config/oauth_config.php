<?php
// OAuth Configuration
class OAuthConfig {
    // Google OAuth Configuration - Test credentials
    const GOOGLE_CLIENT_ID = 'test-client-id.apps.googleusercontent.com';
    const GOOGLE_CLIENT_SECRET = 'test-client-secret';
    const GOOGLE_REDIRECT_URI = 'http://localhost/onlinecourse/onlinecourse/index.php?controller=Auth&action=googleCallback';
    
    // Facebook OAuth Configuration - Test credentials
    const FACEBOOK_APP_ID = 'test-app-id';
    const FACEBOOK_APP_SECRET = 'test-app-secret';
    const FACEBOOK_REDIRECT_URI = 'http://localhost/onlinecourse/onlinecourse/index.php?controller=Auth&action=facebookCallback';
    
    // OAuth URLs
    const GOOGLE_AUTH_URL = 'https://accounts.google.com/o/oauth2/auth';
    const FACEBOOK_AUTH_URL = 'https://www.facebook.com/v18.0/dialog/oauth';
    
    // Scopes
    const GOOGLE_SCOPES = 'openid email profile';
    const FACEBOOK_SCOPES = 'email';
    
    public static function getGoogleAuthUrl() {
        $params = [
            'client_id' => self::GOOGLE_CLIENT_ID,
            'redirect_uri' => self::GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope' => self::GOOGLE_SCOPES,
            'access_type' => 'offline',
            'prompt' => 'consent'
        ];
        
        return self::GOOGLE_AUTH_URL . '?' . http_build_query($params);
    }
    
    public static function getFacebookAuthUrl() {
        $params = [
            'client_id' => self::FACEBOOK_APP_ID,
            'redirect_uri' => self::FACEBOOK_REDIRECT_URI,
            'response_type' => 'code',
            'scope' => self::FACEBOOK_SCOPES
        ];
        
        return self::FACEBOOK_AUTH_URL . '?' . http_build_query($params);
    }
    
    // Test method để simulate OAuth flow
    public static function simulateOAuth($provider) {
        if ($provider === 'facebook') {
            // Sử dụng Facebook OAuth thật
            return self::getFacebookAuthUrl();
        } elseif ($provider === 'google') {
            // Sử dụng Google OAuth thật
            return self::getGoogleAuthUrl();
        } else {
            // Mock cho các provider khác
            return "/onlinecourse/onlinecourse/index.php?controller=Auth&action={$provider}Callback&mock=1";
        }
    }
}
?>
