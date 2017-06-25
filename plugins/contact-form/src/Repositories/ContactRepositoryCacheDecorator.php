<?php namespace WebEd\Plugins\ContactForm\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Plugins\ContactForm\Repositories\Contracts\ContactRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class ContactRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements ContactRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createContact(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateContact($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateContact($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteContact($id)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
