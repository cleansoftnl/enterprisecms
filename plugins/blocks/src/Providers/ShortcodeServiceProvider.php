<?php namespace WebEd\Plugins\Blocks\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Blocks\Shortcode\BlockShortcodeRenderer;

class ShortcodeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        add_shortcode('block', [BlockShortcodeRenderer::class, 'handle']);
    }
}
