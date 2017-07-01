<?php
namespace WebEd\Modules\Relations\Criterias\Filters;

use Illuminate\Database\Eloquent\Builder;
use WebEd\Base\Criterias\AbstractCriteria;
use WebEd\Base\Repositories\AbstractBaseRepository;
use WebEd\Base\Repositories\Contracts\AbstractRepositoryContract;
use WebEd\Modules\Relations\Models\Relation;

class WhereRelationBelongsToCategories extends AbstractCriteria
{
    /**
     * @var array
     */
    protected $categoryIds;

    /**
     * @var array
     */
    protected $groupBy;

    public function __construct(array $categoryIds, array $groupBy)
    {
        $this->categoryIds = $categoryIds;

        $this->groupBy = $groupBy;
    }

     /**
      * @param Relation|Builder $model
      * @param AbstractBaseRepository $repository
      * @return mixed
      */
    public function apply($model, AbstractRepositoryContract $repository)
    {
        return $model->join('posts_categories', 'posts.id', '=', 'posts_categories.post_id')
            ->join('categories', 'categories.id', '=', 'posts_categories.category_id')
            ->whereIn('categories.id', $this->categoryIds)
            ->distinct()
            ->groupBy($this->groupBy);
    }
}
