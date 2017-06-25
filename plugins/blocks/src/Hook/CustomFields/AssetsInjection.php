<?php namespace WebEd\Plugins\Blocks\Hook\CustomFields;

class AssetsInjection extends \WebEd\Plugins\CustomFields\Hook\Actions\AssetsInjection
{
    protected $allowedRoute = [
        /**
         * Blocks
         */
        'admin::blocks.create.get',
        'admin::blocks.edit.get',
    ];
}
