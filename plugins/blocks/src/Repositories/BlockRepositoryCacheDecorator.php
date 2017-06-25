<?php namespace WebEd\Plugins\Blocks\Repositories;

use WebEd\Base\Caching\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;
use WebEd\Plugins\Blocks\Repositories\Contracts\BlockRepositoryContract;

class BlockRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator  implements BlockRepositoryContract
{

}
