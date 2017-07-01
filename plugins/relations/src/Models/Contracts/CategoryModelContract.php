<?php namespace WebEd\Modules\Relations\Models\Contracts;

interface CategoryModelContract
{
    /**
     * @return mixed
     */
    public function posts();

    /**
     * @return mixed
     */
    public function parent();

    /**
     * @return mixed
     */
    public function children();
}
