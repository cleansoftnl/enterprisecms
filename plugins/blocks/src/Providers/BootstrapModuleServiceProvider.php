<?php namespace WebEd\Plugins\Blocks\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Blocks\Repositories\BlockRepository;
use WebEd\Plugins\Blocks\Repositories\Contracts\BlockRepositoryContract;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Blocks';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'webed-blocks',
            'priority' => 1.1,
            'parent_id' => null,
            'heading' => null,
            'title' => 'CMS blocks',
            'font_icon' => 'fa fa-server',
            'link' => route('admin::blocks.index.get'),
            'css_class' => null,
            'permissions' => ['view-blocks'],
        ]);

        \AdminBar::registerLink('Block', route('admin::blocks.create.get'), 'add-new');

        $this->registerCustomFields();
    }

    protected function registerCustomFields()
    {
        if (modules_management()->isActivated('webed-custom-fields') && modules_management()->isInstalled('webed-custom-fields')) {
            custom_field_rules()
                ->registerRule('Basic', 'Block template', 'block_template', get_templates('Block'))
                ->registerRule('Basic', 'Block', 'block', function () {
                    /**
                     * @var BlockRepository $blockRepo
                     */
                    $blockRepo = app(BlockRepositoryContract::class);

                    /**
                     * @var Collection $blocks
                     */
                    $blocks = $blockRepo->select(['title', 'id'])->get();
                    return $blocks->pluck('title', 'id')->toArray();
                })
                ->registerRule('Other', 'Model name', 'model_name', [
                    'block' => '(CMS blocks) Block',
                ]);
        }
    }
}
