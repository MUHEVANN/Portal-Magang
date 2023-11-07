<?php

namespace App\Providers;

use App\Models\MailSetting;
use Illuminate\Support\ServiceProvider;
use Config;
use Illuminate\Support\Facades\Schema;

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
        if (Schema::hasTable('mail_settings')) {
            $mailsetting = MailSetting::first();
            if ($mailsetting) {
                $data = [
                    'host' => $mailsetting->host,
                    'port' => $mailsetting->port,
                    'username' => $mailsetting->username,
                    'password' => $mailsetting->password,
                    'driver' => $mailsetting->transport,
                    'encryption' => 'tls',
                    'from'  => [
                        'address' => $mailsetting->email,
                        'name' => 'jetorbit',
                    ],
                ];

                Config::set('mail', $data);
            }
        }

        // dd(config('mail'));
    }
}
