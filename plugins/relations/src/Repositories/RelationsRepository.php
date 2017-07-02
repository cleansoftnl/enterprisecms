<?php
namespace WebEd\Modules\Relations\Repositories;

use Illuminate\Support\Collection;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Modules\Relations\Models\Relation;
use WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;

class RelationsRepository extends EloquentBaseRepository implements RelationsRepositoryContract
{
    /**
     * @param array $data
     * @param array|null $categories
     * @param array|null $tags
     * @return int|null
     */
    public function createRelation(array $data, array $categories = null, array $tags = null)
    {
        $result = $this->create($data);
        if ($result) {
            if ($categories !== null) {
                $this->syncCategories($result, $categories);
            }
            if ($tags !== null) {
                $this->syncTags($result, $tags);
            }
        }
        return $result;
    }

    /**
     * @param int|null|Relation $id
     * @param array $data
     * @param array|null $categories
     * @param array|null $tags
     * @return int|null
     */
    public function createOrUpdateRelation($id, array $data, array $categories = null, array $tags = null)
    {
        $result = $this->createOrUpdate($id, $data);
        if ($result) {
            if ($categories !== null) {
                $this->syncCategories($result, $categories);
            }
            if ($tags !== null) {
                $this->syncTags($result, $tags);
            }
        }
        return $result;
    }

    /**
     * @param int|null|Relation $id
     * @param array $data
     * @return int
     */
    public function updateRelation($id, array $data, array $categories = null, array $tags = null)
    {
        $result = $this->update($id, $data);
        if ($result) {
            if ($categories !== null) {
                $this->syncCategories($result, $categories);
            }
            if ($tags !== null) {
                $this->syncTags($result, $tags);
            }
        }
        return $result;
    }

    /**
     * @param int|Relation|array $id
     * @return bool
     */
    public function deleteRelation($id)
    {
        return $this->delete($id);
    }

    /**
     * @param Relation|int $model
     * @param array $categories
     * @return bool|null
     */
    public function syncCategories($model, array $categories)
    {
        $model = $model instanceof Relation ? $model : $this->find($model);

        try {
            $model->categories()->sync($categories);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param Relation|int $model
     * @return array
     */
    public function getRelatedCategoryIds($model)
    {
        $model = $model instanceof Relation ? $model : $this->find($model);

        try {
            return $model->categories()->allRelatedIds()->toArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param Relation|int $model
     * @param array $params
     * @return mixed
     */
    public function getRelatedCategories($model, array $params = [])
    {
        $model = $model instanceof Relation ? $model : $this->find($model);

        $params = array_merge([
            'condition' => [
                'status' => 'activated',
            ],
            'order_by' => [
                'order' => 'ASC',
                'created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => ['*'],
        ], $params);

        $model = $model->categories()
            ->where($params['condition']);

        $model = $model->select($params['select']);

        foreach ($params['order_by'] as $column => $direction) {
            $model = $model->orderBy($column, $direction);
        }

        if ($params['take'] == 1) {
            return $model->first();
        }

        if ($params['take']) {
            return $model->take($params['take'])->get();
        }

        if ($params['paginate']['per_page']) {
            return $model->paginate($params['paginate']['per_page'], ['*'], 'page', $params['paginate']['current_paged']);
        }

        return $model->get();
    }

    /**
     * @param Relation|int $model
     * @param array $tags
     * @return bool|null
     */
    public function syncTags($model, array $tags)
    {
        $model = $model instanceof Relation ? $model : $this->find($model);

        try {
            $model->tags()->sync($tags);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param Relation|int $model
     * @return array
     */
    public function getRelatedTagIds($model)
    {
        $model = $model instanceof Relation ? $model : $this->find($model);

        try {
            return $model->tags()->allRelatedIds()->toArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param Relation|int $model
     * @param array $params
     * @return mixed
     */
    public function getRelatedTags($model, array $params = [])
    {
        $model = $model instanceof Relation ? $model : $this->find($model);

        $params = array_merge([
            'condition' => [
                'status' => 'activated',
            ],
            'order_by' => [
                'order' => 'ASC',
                'created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => ['*'],
        ], $params);

        $model = $model->tags()
            ->where($params['condition']);

        $model = $model->select($params['select']);

        foreach ($params['order_by'] as $column => $direction) {
            $model = $model->orderBy($column, $direction);
        }

        if ($params['take'] == 1) {
            return $model->first();
        }

        if ($params['take']) {
            return $model->take($params['take'])->get();
        }

        if ($params['paginate']['per_page']) {
            return $model->paginate($params['paginate']['per_page'], ['*'], 'page', $params['paginate']['current_paged']);
        }

        return $model->get();
    }

    /**
     * @param array|int $categoryId
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getRelationsByCategory($categoryId, array $params = [])
    {
        $params = array_merge([
            'condition' => [
                'posts.status' => 'activated',
            ],
            'order_by' => [
                'posts.order' => 'ASC',
                'posts.created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => [
                'posts.id', 'posts.title', 'posts.slug', 'posts.created_at', 'posts.updated_at',
                'posts.content', 'posts.description', 'posts.keywords', 'posts.order', 'posts.thumbnail',
            ],
            'group_by' => [
                'posts.id', 'posts.title', 'posts.slug', 'posts.created_at', 'posts.updated_at',
                'posts.content', 'posts.description', 'posts.keywords', 'posts.order', 'posts.thumbnail'
            ],
            'with' => [

            ],
        ], $params);

        $model = $this->model
            ->join('posts_categories', 'posts.id', '=', 'posts_categories.post_id')
            ->join('categories', 'categories.id', '=', 'posts_categories.category_id')
            ->select($params['select'])
            ->whereIn('categories.id', (array)$categoryId)
            ->where($params['condition'])
            ->distinct()
            ->groupBy($params['group_by']);

        foreach ($params['with'] as $with) {
            $model = $model->with($with);
        }

        foreach ($params['order_by'] as $column => $direction) {
            $model = $model->orderBy($column, $direction);
        }

        if ($params['take'] == 1) {
            return $model->first();
        }

        if ($params['take']) {
            return $model->take($params['take'])->get();
        }

        if ($params['paginate']['per_page']) {
            return $model->paginate($params['paginate']['per_page'], ['*'], 'page', $params['paginate']['current_paged']);
        }

        return $model->get();
    }

    /**
     * @param array|int $tagId
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getRelationsByTag($tagId, array $params = [])
    {
        $params = array_merge([
            'condition' => [
                'posts.status' => 'activated',
            ],
            'order_by' => [
                'posts.order' => 'ASC',
                'posts.created_at' => 'DESC',
            ],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => [
                'posts.id', 'posts.title', 'posts.slug', 'posts.created_at', 'posts.updated_at',
                'posts.content', 'posts.description', 'posts.keywords', 'posts.order', 'posts.thumbnail',
            ],
            'group_by' => [
                'posts.id', 'posts.title', 'posts.slug', 'posts.created_at', 'posts.updated_at',
                'posts.content', 'posts.description', 'posts.keywords', 'posts.order', 'posts.thumbnail'
            ],
            'with' => [

            ],
        ], $params);

        $model = $this->model
            ->join('posts_tags', 'posts.id', '=', 'posts_tags.post_id')
            ->join('blog_tags', 'blog_tags.id', '=', 'posts_tags.tag_id')
            ->select($params['select'])
            ->whereIn('blog_tags.id', (array)$tagId)
            ->where($params['condition'])
            ->distinct()
            ->groupBy($params['group_by']);

        foreach ($params['with'] as $with) {
            $model = $model->with($with);
        }

        foreach ($params['order_by'] as $column => $direction) {
            $model = $model->orderBy($column, $direction);
        }

        if ($params['take'] == 1) {
            return $model->first();
        }

        if ($params['take']) {
            return $model->take($params['take'])->get();
        }

        if ($params['paginate']['per_page']) {
            return $model->paginate($params['paginate']['per_page'], ['*'], 'page', $params['paginate']['current_paged']);
        }

        return $model->get();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getRelations(array $params)
    {
        return $this->advancedGet($params);
    }
}
