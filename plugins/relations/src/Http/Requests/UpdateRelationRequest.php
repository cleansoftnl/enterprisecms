<?php
namespace WebEd\Modules\Relations\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class UpdateRelationRequest extends Request
{
    public function rules()
    {
        return [
            'relation.relationname' => 'string|max:100|required',
            'relation.slug' => 'nullable|string|max:100|unique:posts,slug,' . request()->route()->parameter('id'),
        ];
    }
}
