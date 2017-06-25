<?php namespace WebEd\Plugins\Blocks\Http\Requests;

use WebEd\Base\Core\Http\Requests\Request;

class CreateBlockRequest extends Request
{
    public $rules = [

    ];

    public function authorize()
    {
        //return $this->user()->hasPermission('edit-page');
        return true;
    }
}
