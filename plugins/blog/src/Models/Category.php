<?php namespace WebEd\Plugins\Blog\Models;

use WebEd\Base\Users\Models\User;
use WebEd\Plugins\Blog\Models\Contracts\CategoryModelContract;
use WebEd\Base\Models\EloquentBase as BaseModel;

class Category extends BaseModel implements CategoryModelContract
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'slug', 'status', 'parent_id', 'page_template',
        'description', 'content', 'thumbnail', 'keywords', 'order',
        'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'posts_categories', 'category_id', 'post_id');
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
