<?php namespace WebEd\Modules\Relations\Repositories\Contracts;

use Illuminate\Support\Collection;
use WebEd\Modules\Relations\Models\Contracts\RelationModelContract;

interface RelationsRepositoryContract
{
    /**
     * @param array $data
     * @param array|null $categories
     * @param array|null $tags
     * @return int|null
     */
    public function createRelation(array $data, array $categories = null, array $tags = null);

    /**
     * @param int|null|RelationModelContract $id
     * @param array $data
     * @param array|null $categories
     * @param array|null $tags
     * @return int|null
     */
    public function createOrUpdateRelation($id, array $data, array $categories = null, array $tags = null);

    /**
     * @param int|null|RelationModelContract $id
     * @param array $data
     * @return int
     */
    public function updateRelation($id, array $data, array $categories = null, array $tags = null);

    /**
     * @param int|RelationModelContract|array $id
     * @return bool
     */
    public function deleteRelation($id);

    /**
     * @param RelationModelContract|int $model
     * @param array $categories
     * @return bool|null
     */
    public function syncCategories($model, array $categories);

    /**
     * @param RelationModelContract|int $model
     * @return array
     */
    public function getRelatedCategoryIds($model);

    /**
     * @param RelationModelContract|int $model
     * @param array $tags
     * @return bool|null
     */
    public function syncTags($model, array $tags);

    /**
     * @param RelationModelContract|int $model
     * @return array
     */
    public function getRelatedTagIds($model);

    /**
     * @param array|int $categoryId
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getRelationsByCategory($categoryId, array $params = []);

    /**
     * @param array|int $tagId
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getRelationsByTag($tagId, array $params = []);

    /**
     * @param array $params
     * @return mixed
     */
    public function getRelations(array $params);

    /**
     * @param RelationModelContract|int $model
     * @param array $params
     * @return mixed
     */
    public function getRelatedTags($model, array $params = []);

    /**
     * @param RelationModelContract|int $model
     * @param array $params
     * @return mixed
     */
    public function getRelatedCategories($model, array $params = []);
}
