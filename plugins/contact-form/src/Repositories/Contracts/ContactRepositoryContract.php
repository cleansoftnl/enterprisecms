<?php namespace WebEd\Plugins\ContactForm\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface ContactRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createContact(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateContact($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateContact($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteContact($id);
}
