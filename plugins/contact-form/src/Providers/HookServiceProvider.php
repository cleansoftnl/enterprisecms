<?php namespace WebEd\Plugins\ContactForm\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\ContactForm\Hook\AddHeaderMenuItem;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        add_action(BASE_ACTION_HEADER_MENU, [AddHeaderMenuItem::class, 'handle'], 21);
    }
}
