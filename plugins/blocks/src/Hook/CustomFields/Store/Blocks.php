<?php namespace WebEd\Plugins\Blocks\Hook\CustomFields\Store;

use WebEd\Plugins\Blocks\Repositories\Contracts\BlockRepositoryContract;
use WebEd\Plugins\CustomFields\Hook\Actions\Store\AbstractStore;

class Blocks extends AbstractStore
{
    /**
     * @var string
     */
    protected $repositoryInterface = BlockRepositoryContract::class;
}
