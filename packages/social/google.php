<?php

use App\Models\User;

class Google
{
    public $instance;

    public function __construct()
    {
        if (! class_exists('Google_Client')) {
            exec('composer require google/apiclient');
        }
    }

    public static function init()
    {
        $class = new static;

        $google_client = new Google_Client();

        $google_client->setClientId(config('google')->client_id);
        $google_client->setClientSecret(config('google')->client_secret);

        $google_client->addScope('email');
        $google_client->addScope('profile');

        $class->instance = $google_client;

        return $class;
    }

    public function url()
    {
        $this->instance->setRedirectUri("http://{$_SERVER['HTTP_HOST']}/login?google=1");
        echo $this->instance->createAuthUrl();
    }

    public function login()
    {
        $client = $this->instance;

        $client->setRedirectUri("http://{$_SERVER['HTTP_HOST']}/login?google=1");

        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);

        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $email = $google_account_info->email;
        $name = $google_account_info->name;

        $user = User::firstOrCreate(
            [
                'email' => $email,
                'oauth' => 'Google',
            ],
            ['name' => $name]
        );

        session('id', $user->id);

        redirect(config('google')->redirect);

        return $this;
    }
}
