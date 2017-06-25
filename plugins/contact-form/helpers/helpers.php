<?php

if (!function_exists('contact_form_url')) {
    /**
     * @return string
     */
    function contact_form_url()
    {
        return route('front::contact-forms.create.post');
    }
}

if (!function_exists('contact_form_alias')) {
    /**
     * @param $formAlias
     * @return \Illuminate\Support\HtmlString
     */
    function contact_form_alias($formAlias = 'default_form')
    {
        return form()->hidden('form_alias', $formAlias);
    }
}