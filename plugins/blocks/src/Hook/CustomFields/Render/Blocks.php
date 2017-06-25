<?php namespace WebEd\Plugins\Blocks\Hook\CustomFields\Render;

use WebEd\Base\Core\Models\Contracts\BaseModelContract;
use WebEd\Plugins\Blocks\Models\Block;

class Blocks
{
    /**
     * @param string $location: type of the current object. Currently support the type in $this->mapping
     * @param string $type
     * @param Block $item
     */
    public function handle($location, $type, BaseModelContract $item = null)
    {
        /**
         * Just render custom fields for main meta box
         */
        if ($location !== 'main' || !$item) {
            return;
        }

        if ($type !== 'blocks.create' && $type !== 'blocks.edit') {
            return;
        }

        add_custom_field_rules([
            'block_template' => isset($item->page_template) ? $item->page_template : '',
            'model_name' => 'block',
        ]);

        $customFieldBoxes = get_custom_field_boxes($item, $item->id);

        if (!$customFieldBoxes) {
            return;
        }

        $view = view('webed-custom-fields::admin.custom-fields-boxes-renderer', [
            'customFieldBoxes' => json_encode($customFieldBoxes),
        ])->render();

        echo $view;
    }
}
