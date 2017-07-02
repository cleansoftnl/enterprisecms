<?php namespace WebEd\Plugins\Blog\Http\Middleware;

use \Closure;
use WebEd\Base\CustomFields\Facades\CustomFieldSupportFacade;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

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
        admin_bar()->registerLink('Relation', route('admin::blog.posts.create.get'), 'add-new');
        admin_bar()->registerLink('Category', route('admin::blog.categories.create.get'), 'add-new');

        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'webed-blog-posts',
            'panelType' => 'cmscp',
            'priority' => 2,
            'parent_id' => null,
            'heading' => 'Blog',
            'title' => trans('webed-blog::base.admin_menu.posts'),
            'font_icon' => 'icon-book-open',
            'link' => route('admin::blog.posts.index.get'),
            'css_class' => null,
            'permissions' => ['view-posts'],
        ])->registerItem([
            'id' => 'webed-blog-categories',
            'panelType' => 'crmcp',
            'priority' => 2.1,
            'parent_id' => null,
            'heading' => 'Tags & Cats',
            'title' => trans('webed-blog::base.admin_menu.categories'),
            'font_icon' => 'fa fa-sitemap',
            'link' => route('admin::blog.categories.index.get'),
            'css_class' => null,
            'permissions' => ['view-categories'],
        ])->registerItem([
            'id' => 'webed-blog-tags',
            'panelType' => 'crmcp',
            'priority' => 2.2,
            'parent_id' => null,
            'heading' => 'Tags & Cats',
            'title' => trans('webed-blog::base.admin_menu.tags'),
            'font_icon' => 'icon-tag',
            'link' => route('admin::blog.tags.index.get'),
            'css_class' => null,
            'permissions' => ['view-tags'],
        ]);

        /**
         * Register menu widget
         */
        menus_management()->registerWidget(trans('webed-blog::base.categories.page_title'), 'category', function () {
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

        $this->registerBlogFields();

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

    protected function registerBlogFields()
    {
        /**
         * Map the translations
         */
        lang()->addLines([
            'rules.groups.blog' => trans('webed-blog::custom-fields.groups.blog'),
        ], app()->getLocale(), 'webed-custom-fields');

        if (webed_plugins()->isActivated('webed-blog') && webed_plugins()->isInstalled('webed-blog')) {
            CustomFieldSupportFacade::registerRuleGroup('blog')
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.post_template'), WEBED_BLOG_POSTS . '.post_template', function () {
                    return get_templates('blog_post');
                })
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.category_template'), WEBED_BLOG_CATEGORIES . '.category_template', function () {
                    return get_templates('blog_category');
                })
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.category'), WEBED_BLOG_CATEGORIES, function () {
                    $categories = get_categories();

                    $categoriesArr = [];
                    foreach ($categories as $row) {
                        $categoriesArr[$row->id] = $row->indent_text . $row->title;
                    }
                    return $categoriesArr;
                })
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.post_with_related_category'), WEBED_BLOG_POSTS . '.post_with_related_category', function () {
                    $categories = get_categories();

                    $categoriesArr = [];
                    foreach ($categories as $row) {
                        $categoriesArr[$row->id] = $row->indent_text . $row->title;
                    }
                    return $categoriesArr;
                })
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.post_with_related_category_template'), WEBED_BLOG_POSTS . '.post_with_related_category_template', get_templates('blog_category'))
                ->registerRule('other', trans('webed-custom-fields::rules.model_name'), 'model_name', function () {
                    return [
                        WEBED_BLOG_POSTS => trans('webed-blog::custom-fields.rules.model_name_post'),
                        WEBED_BLOG_CATEGORIES => trans('webed-blog::custom-fields.rules.model_name_category'),
                    ];
                });
        }
    }
}
