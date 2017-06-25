<?php namespace WebEd\Plugins\ContactForm\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class UpdateContactRequest extends Request
{
    public function rules()
    {
        return [
            'contact_form.status' => 'required|in:unread,read'
        ];
    }
}
