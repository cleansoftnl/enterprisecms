<?php namespace WebEd\Themes\Sedna\Http\Controllers;

use WebEd\Base\Caching\Services\CacheService;
use WebEd\Base\Caching\Services\Contracts\CacheableContract;
use WebEd\Base\Caching\Services\Traits\Cacheable;
use WebEd\Base\Http\Controllers\BaseFrontController;

abstract class AbstractController extends BaseFrontController
{
    use Cacheable;

    /**
     * @var CacheService
     */
    protected $cacheService;

    public function __construct()
    {
        parent::__construct();



        $this->getFooterMenu();
    }

    /**
     * Override some menu attributes
     *
     * @param $type
     * @param $relatedId
     * @return null|string|mixed
     */
    protected function getMenu($type, $relatedId)
    {
        $menuHtml = webed_render_menu(get_setting('main_menu', 'main-menu'), [

            'id' => '',
            'class' => 'primary-nav',
            'container_class' => '',
            'has_sub_class' => 'dropdown',
            'container_tag' => 'nav',
            'container_id' => '',
            'group_tag' => 'ul',
            'child_tag' => 'li',
            'submenu_class' => 'sub-menu',
                    'item_class' => '',
            'active_class' => 'active current-menu-item',
            'menu_active' => [
                'type' => $type,
                'related_id' => $relatedId,
            ]
        ]);
        view()->share([
            'cmsMenuHtml' => $menuHtml
        ]);
        return $menuHtml;
    }

    protected function getFooterMenu()
    {
        $menuHtml = webed_render_menu('footer-menu', [
            'class' => 'footer-group',
            'container_class' => '',
            'has_sub_class' => 'dropdown',
            'container_tag' => null,
            'container_id' => '',
            'group_tag' => 'ul',
            'child_tag' => 'li',
            'submenu_class' => 'sub-menu',
            'active_class' => 'active current-menu-item',
        ]);
        view()->share([
            'cmsFooterMenuHtml' => $menuHtml
        ]);
        return $menuHtml;
    }
}
