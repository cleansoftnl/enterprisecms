<?php namespace WebEd\Plugins\Blog\Models;

use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Blog\Models\Contracts\PostModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Post extends BaseModel implements PostModelContract
{
    protected $table = 'relations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'page_template',
        'slug',
        'description',
        'content',
        'thumbnail',
        'keywords',
        'status',
        'order',
        'is_featured',
        'category_id',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'posts_categories', 'post_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'posts_tags', 'post_id', 'tag_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function modifier()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @param $value
     * @return string
     */
    public function getContentAttribute($value)
    {
        if (!is_admin_panel()) {
            return do_shortcode($value);
        }
        return $value;
    }
}
