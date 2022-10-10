<?php

return [
    'oauthconf' => [ // See http://oauth2-client.thephpleague.com/usage/#authorization-code-flow
        'clientId' => '8e3bb0bc-e5a8-49c7-a34e-cf386a86d1a6', // The client ID assigned to you by the provider
        'clientSecret' => 'demopass', // The client password assigned to you by the provider
        'redirectUri' => 'http://example.com/your-redirect-url/',
        'urlAuthorize' => 'http://account.accurate.id/oauth/authorize',
        'urlAccessToken' => 'http://account.accurate.id/oauth/token',
        'urlResourceOwnerDetails' => 'http://account.accurate.id/oauth/resource',
    ],
    'provider' => \Kronthto\LaravelOAuth2Login\OAuthProvider::class,

    'oauth_redirect_path' => '/oauth2/callback',

    'session_key' => 'oauth2_session',
    'session_key_state' => 'oauth2_auth_state',

    'resource_owner_attribute' => 'oauth2_user',
    'auth_driver_key' => 'oauth2',
    'authWrapperFactory' => null, // Can be used to specify a factory with an __invoke (ResourceOwnerInterface passed as arg1) method to build a custom User object
    'authWrapper' => \Kronthto\LaravelOAuth2Login\OAuthUserWrapper::class, // Ignored if authWrapperFactory is not null

    'cacheUserDetailsFor' => 30, // minutes
    'cacheUserPrefix' => 'oauth_user_',
];
