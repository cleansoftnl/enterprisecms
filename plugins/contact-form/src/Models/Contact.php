<?php namespace WebEd\Plugins\ContactForm\Models;

use WebEd\Plugins\ContactForm\Models\Contracts\ContactModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Contact extends BaseModel implements ContactModelContract
{
    protected $table = 'contacts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'name',
        'email',
        'phone',
        'address',
        'content',
        'options',
        'status',
        'updated_by',
    ];

    public $timestamps = true;

    /**
     * @param $value
     * @return array
     */
    public function getOptionsAttribute($value)
    {
        if (!$value) {
            return [];
        }
        try {
            return json_decode($value) ?: [];
        } catch (\Exception $exception) {
            return [];
        }
    }
}
