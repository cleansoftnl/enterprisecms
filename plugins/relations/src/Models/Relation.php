<?php namespace WebEd\Modules\Relations\Models;

use WebEd\Base\Users\Models\User;
use WebEd\Modules\Relations\Models\Contracts\RelationModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Relation extends BaseModel implements RelationModelContract
{
    protected $table = 'relations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'relationname',
        'slug',
        //'status',
        //'category_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    /*public function categories()
    {
        return $this->belongsToMany(Category::class, 'relations_categories', 'relation_id', 'category_id');
    }*/

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tags', 'relation_id', 'tag_id');
    }

    /*public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }*/


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function modifier()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }*/

    /*public function modifier()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function relationmanager()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }*/



    /**
     * @param $value
     * @return string
     */
    /*public function getContentAttribute($value)
    {
        if (!is_admin_panel()) {
            return do_shortcode($value);
        }
        return $value;
    }*/
}
