<?php

namespace App\Providers;

use App\Models\MailSetting;
use Illuminate\Support\ServiceProvider;
use Config;

class AppServiceProvider extends ServiceProvider
{
    // private function setEnv($key, $value)
    // {
    //     file_put_contents(app()->environmentFilePath(), str_replace(
    //         $key . '=' . env($key),
    //         $key . '=' . $value,
    //         file_get_contents(app()->environmentFilePath())
    //     ));
    // }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $mailsetting = MailSetting::first();
        if ($mailsetting) {
            $data = [
                'host' => $mailsetting->host,
                'port' => $mailsetting->port,
                'username' => $mailsetting->username,
                'password' => $mailsetting->password,
                'driver' => $mailsetting->transport,
                'from'  => [
                    'address' => $mailsetting->email,
                    'name' => 'jetorbit',
                ],
            ];

            Config::set('mail', $data);
        }
    }
}