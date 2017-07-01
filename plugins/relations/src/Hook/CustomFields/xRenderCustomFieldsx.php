<?php
namespace WebEd\Modules\Relations\Hook\CustomFields;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Models\EloquentBase;
use WebEd\Modules\Relations\Models\Relation;
//use WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;
use WebEd\Modules\Relations\Repositories\RelationsRepository;

class aRenderCustomFieldsb extends \WebEd\Base\CustomFields\Hook\RenderCustomFields
{
    /**
     * @var RelationRepository
     */
    protected $relationRepository;

    //protected $categoryRepository;

    public function __construct(RelationRepositoryContract $relationRepository)
    {
        parent::__construct();

        $this->relationRepository = $relationRepository;
    }

    /**
     * @param string $location
     * @param string $screenName
     * @param BaseModelContract|EloquentBase|Relation $object
     */
    public function handle($location, $screenName, $object = null)
    {
        if ($location != 'main') {
            return;
        }

        switch ($screenName) {
            case WEBED_RELATIONS_CATEGORIES:
                add_custom_fields_rules_to_check([
                    WEBED_RELATIONS_CATEGORIES . '.category_template' => isset($object->page_template) ? $object->page_template : '',
                    WEBED_RELATIONS_CATEGORIES => isset($object->id) ? $object->id : null,
                    'model_name' => WEBED_RELATIONS_CATEGORIES,
                ]);
                break;
            case WEBED_RELATIONS_POSTS:
                add_custom_fields_rules_to_check([
                    WEBED_RELATIONS_POSTS . '.relation_template' => isset($object->page_template) ? $object->page_template : '',
                    'model_name' => WEBED_RELATIONS_POSTS,
                ]);
                if ($object) {
                    $relatedCategoryIds = $this->relationRepository->getRelatedCategoryIds($object);
                    $relatedCategoryTemplates = $this->relationRepository->getRelatedCategories($object, [
                        'select' => ['page_template'],
                        'condition' => [
                            ['page_template', '<>', ''],
                        ],
                    ])->pluck('page_template')->toArray();
                    add_custom_fields_rules_to_check([
                        WEBED_RELATIONS_POSTS . '.relation_with_related_category' => $relatedCategoryIds,
                        WEBED_RELATIONS_POSTS . '.relation_with_related_category_template' => $relatedCategoryTemplates,
                    ]);
                }
                break;
            default:
                return;
        }

        $this->render($screenName, isset($object->id) ? $object->id : null);
    }
}