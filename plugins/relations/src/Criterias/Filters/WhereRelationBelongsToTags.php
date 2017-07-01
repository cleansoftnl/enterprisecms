<?php
namespace WebEd\Modules\Relations\Criterias\Filters;

use Illuminate\Database\Eloquent\Builder;
use WebEd\Base\Criterias\AbstractCriteria;
use WebEd\Base\Repositories\AbstractBaseRepository;
use WebEd\Base\Repositories\Contracts\AbstractRepositoryContract;
use WebEd\Modules\Relations\Models\Relation;

class WhereRelationBelongsToTags extends AbstractCriteria
{
    protected $tagIds;

    protected $groupBy;

    public function __construct(array $tagIds, array $groupBy)
    {
        $this->tagIds = $tagIds;

        $this->groupBy = $groupBy;
    }

     /**
      * @param Relation|Builder $model
      * @param AbstractBaseRepository $repository
      * @return mixed
      */
    public function apply($model, AbstractRepositoryContract $repository)
    {
        //$table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
        return $model->join('tags', 'relations.id', '=', 'tags.relation_id')
            ->join('tags', 'tags.id', '=', 'tags.tag_id')
            ->whereIn('tags.id', $this->tagIds)
            ->distinct()
            ->groupBy($this->groupBy);
    }
}
