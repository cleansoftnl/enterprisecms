<?php namespace WebEd\Plugins\ContactForm\Http\Middleware;

use \Closure;

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
        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'webed-contact-form',
            'priority' => 999.1,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-contact-form::base.admin_menu.title'),
            'font_icon' => 'icon-envelope-open',
            'link' => route('admin::contact-forms.index.get'),
            'css_class' => null,
            'permissions' => ['view-contact-forms'],
        ]);

        return $next($request);
    }
}
