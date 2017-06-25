<?php namespace WebEd\Plugins\Blocks\Repositories;

use WebEd\Base\Caching\Services\Traits\Cacheable;
use WebEd\Base\Core\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Caching\Services\Contracts\CacheableContract;
use WebEd\Plugins\Blocks\Repositories\Contracts\BlockRepositoryContract;

class BlockRepository extends EloquentBaseRepository implements BlockRepositoryContract, CacheableContract
{
    use Cacheable;

    protected $rules = [
        'title' => 'string|max:255|required',
        'page_template' => 'string|max:255|nullable',
        'content' => 'string|nullable',
        'status' => 'string|in:activated,disabled|required',
        'created_by' => 'integer|min:0|required',
        'updated_by' => 'integer|min:0|required',
    ];

    protected $editableFields = [
        'title',
        'page_template',
        'content',
        'status',
        'created_by',
        'updated_by',
    ];
}
