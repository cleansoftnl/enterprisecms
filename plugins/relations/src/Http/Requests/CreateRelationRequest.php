<?php
namespace WebEd\Modules\Relations\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class CreateRelationRequest extends Request
{
    public function rules()
    {
        return [
            'relation.relationname' => 'string|max:100|required',
            'relation.slug' => 'string|max:100|unique:relations,slug|nullable',
        ];
    }
}
