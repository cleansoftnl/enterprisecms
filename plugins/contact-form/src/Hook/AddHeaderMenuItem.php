<?php namespace WebEd\Plugins\ContactForm\Hook;

use WebEd\Plugins\ContactForm\Repositories\ContactRepository;
use WebEd\Plugins\ContactForm\Repositories\Contracts\ContactRepositoryContract;

class AddHeaderMenuItem
{
    /**
     * @var ContactRepository
     */
    protected $repository;

    public function __construct(ContactRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $count = $this->repository
            ->getWhere([
                'status' => 'unread',
            ])
            ->count();
        if ($count) {
            echo view('webed-contact-form::admin._partials.header-custom-menu', ['count' => $count]);
        }
    }
}