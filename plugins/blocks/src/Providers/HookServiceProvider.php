<?php namespace WebEd\Plugins\Blocks\Providers;

use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (modules_management()->isActivated('webed-custom-fields')) {
            $this->registerCustomFields();
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    protected function registerCustomFields()
    {
        add_action(
            'meta_boxes',
            [\WebEd\Plugins\Blocks\Hook\CustomFields\Render\Blocks::class, 'handle'],
            99
        );

        add_action(
            'footer_js',
            [\WebEd\Plugins\Blocks\Hook\CustomFields\AssetsInjection::class, 'renderJs'],
            99
        );

        /**
         * Register custom fields actions
         */
        add_action(
            'blocks.after-edit.post',
            [\WebEd\Plugins\Blocks\Hook\CustomFields\Store\Blocks::class, 'afterSaveContent'],
            99
        );
    }
}
