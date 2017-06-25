<?php namespace WebEd\Plugins\Blocks\Models;

use WebEd\Plugins\Blocks\Models\Contracts\BlockModelContract;
use WebEd\Base\Core\Models\EloquentBase as BaseModel;

class Block extends BaseModel implements BlockModelContract
{
    protected $table = 'blocks';

    protected $primaryKey = 'id';

    protected $fillable = [];

    public $timestamps = true;

    public function getShortcodeAttribute()
    {
        if ($this->id) {
            return generate_shortcode('block', ['id' => $this->id]);
        }
        return null;
    }
}
