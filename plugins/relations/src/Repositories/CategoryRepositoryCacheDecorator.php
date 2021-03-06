<?php namespace WebEd\Modules\Relations\Repositories;

use Illuminate\Support\Collection;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Modules\Relations\Models\Category;
use WebEd\Modules\Relations\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class CategoryRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements CategoryRepositoryContract
{
    /**
     * @param $id
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param bool $justId
     * @return array
     */
    public function getChildren($id, $justId = true)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @return Category
     */
    public function getParent($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $data
     * @return int
     */
    public function createCategory(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateCategory($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateCategory($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteCategory($id)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $select
     * @param array $orderBy
     * @return Collection
     */
    public function getCategories(array $select, array $orderBy)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
