<?php namespace WebEd\Modules\Relations\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class CreateCategoryRequest extends Request
{
    public function rules()
    {
        return [
            'category.parent_id' => 'integer|min:0|nullable',
            'category.page_template' => 'string|max:255|nullable',
            'category.title' => 'string|max:255|required',
            'category.slug' => 'string|max:255|unique:categories,slug|nullable',
            'category.description' => 'string|max:1000|nullable',
            'category.content' => 'string|nullable',
            'category.thumbnail' => 'string|max:255|nullable',
            'category.keywords' => 'string|max:255|nullable',
            'category.status' => 'string|required|in:activated,disabled',
            'category.order' => 'integer|min:0',
        ];
    }
}
