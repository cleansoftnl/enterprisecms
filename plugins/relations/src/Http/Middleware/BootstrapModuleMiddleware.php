<?php namespace WebEd\Modules\Relations\Http\Middleware;

use \Closure;
use WebEd\Base\CustomFields\Facades\CustomFieldSupportFacade;
use WebEd\Modules\Relations\Repositories\Contracts\CategoryRepositoryContract;

class BootstrapModuleMiddleware
{
    public function __construct()
    {

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        admin_bar()->registerLink('Relation', route('admin::relations.relations.create.get'), 'add-new');

        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'webed-relations',
            'priority' => 2.0,
            'parent_id' => null,
            'heading' => 'CRM',
            'title' => trans('relations::base.admin_menu.relations'),
            'font_icon' => 'icon-book-open',
            'link' => route('admin::relations.relations.index.get'),
            'css_class' => null,
            'permissions' => ['view-relations'],
        ])->registerItem([
            'id' => 'webed-suspects',
            'priority' => 2.1,
            'parent_id' => null,

            'title' => trans('relations::base.admin_menu.suspects'),
            'font_icon' => 'fa fa-sitemap',
            'link' => route('admin::relations.relations.index.get'),
            'css_class' => null,
            'permissions' => ['view-suspects'],
        ])->registerItem([
            'id' => 'webed-prospects',
            'priority' => 2.2,
            'parent_id' => null,

            'title' => trans('relations::base.admin_menu.prospects'),
            'font_icon' => 'icon-tag',
            'link' => route('admin::relations.relations.index.get'),
            'css_class' => null,
            'permissions' => ['view-prospects'],
        ])->registerItem([
            'id' => 'webed-leads',
            'priority' => 2.3,
            'parent_id' => null,

            'title' => trans('relations::base.admin_menu.leads'),
            'font_icon' => 'icon-tag',
            'link' => route('admin::relations.relations.index.get'),
            'css_class' => null,
            'permissions' => ['view-leads'],
        ])->registerItem([
            'id' => 'webed-customers',
            'priority' => 2.4,
            'parent_id' => null,

            'title' => trans('relations::base.admin_menu.customers'),
            'font_icon' => 'icon-tag',
            'link' => route('admin::relations.relations.index.get'),
            'css_class' => null,
            'permissions' => ['view-customers'],
        ]);

        /**
         * Register menu widget
         */
        menus_management()->registerWidget(trans('relations::base.categories.page_title'), 'category', function () {
            $categories = get_categories_with_children();
            return $this->parseMenuWidgetData($categories);
        });

        /**
         * Register menu link type
         */
        menus_management()->registerLinkType('category', function ($id) {
            $category = app(CategoryRepositoryContract::class)
                ->find($id);
            if (!$category) {
                return null;
            }
            return [
                'model_title' => $category->title,
                'url' => get_category_link($category),
            ];
        });

        $this->registerRelationsFields();

        return $next($request);
    }


    protected function parseMenuWidgetData($categories)
    {
        $result = [];
        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'title' => $category->title,
                'children' => $this->parseMenuWidgetData($category->child_cats)
            ];
        }
        return $result;
    }

    protected function registerRelationsFields()
    {
        /**
         * Map the translations
         */
        lang()->addLines([
            'rules.groups.relations' => trans('relations::custom-fields.groups.relations'),
        ], app()->getLocale(), 'webed-custom-fields');

        if (webed_plugins()->isActivated('webed-relations') && webed_plugins()->isInstalled('webed-relations')) {
            CustomFieldSupportFacade::registerRuleGroup('relations')
                ->registerRule('relations', trans('relations::custom-fields.rules.post_template'), WEBED_RELATIONS_POSTS . '.post_template', function () {
                    return get_templates('relations_post');
                })
                ->registerRule('relations', trans('relations::custom-fields.rules.category_template'), WEBED_RELATIONS_CATEGORIES . '.category_template', function () {
                    return get_templates('relations_category');
                })
                ->registerRule('relations', trans('relations::custom-fields.rules.category'), WEBED_RELATIONS_CATEGORIES, function () {
                    $categories = get_categories();

                    $categoriesArr = [];
                    foreach ($categories as $row) {
                        $categoriesArr[$row->id] = $row->indent_text . $row->title;
                    }
                    return $categoriesArr;
                })
                ->registerRule('relations', trans('relations::custom-fields.rules.post_with_related_category'), WEBED_RELATIONS_POSTS . '.post_with_related_category', function () {
                    $categories = get_categories();

                    $categoriesArr = [];
                    foreach ($categories as $row) {
                        $categoriesArr[$row->id] = $row->indent_text . $row->title;
                    }
                    return $categoriesArr;
                })
                ->registerRule('relations', trans('relations::custom-fields.rules.post_with_related_category_template'), WEBED_RELATIONS_POSTS . '.post_with_related_category_template', get_templates('relations_category'))
                ->registerRule('other', trans('webed-custom-fields::rules.model_name'), 'model_name', function () {
                    return [
                        WEBED_RELATIONS_POSTS => trans('relations::custom-fields.rules.model_name_post'),
                        WEBED_RELATIONS_CATEGORIES => trans('relations::custom-fields.rules.model_name_category'),
                    ];
                });
        }
    }


}
