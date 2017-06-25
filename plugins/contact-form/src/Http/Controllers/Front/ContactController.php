<?php namespace WebEd\Plugins\ContactForm\Http\Controllers\Front;

use WebEd\Base\Http\Controllers\BaseController;
use WebEd\Base\Services\Validator;
use WebEd\Plugins\ContactForm\Repositories\ContactRepository;
use WebEd\Plugins\ContactForm\Repositories\Contracts\ContactRepositoryContract;

class ContactController extends BaseController
{
    protected $module = 'webed-contact-form';

    /**
     * @var array
     */
    protected $normalFields;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $except;

    /**
     * @var ContactRepository
     */
    protected $repository;

    public function __construct(ContactRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->normalFields = $this->getNormalFieldData();
        $this->options = $this->getOptionsData();
    }

    /**
     * @return array
     */
    protected function getNormalFieldData()
    {
        $fields = $this->request->only(config('webed-contact-form.normal_fields'));
        if (isset($fields['content'])) {
            $fields['content'] = custom_strip_tags($fields['content']);
        }
        return $fields;
    }

    /**
     * @return array
     */
    protected function getOptionsData()
    {
        return $this->request->only(config('webed-contact-form.forms.' . $this->request->get('form_alias') . '.option_fields', []));
    }

    public function postCreate(Validator $validator)
    {
        $result = $validator->make($this->request->all(), config('webed-contact-form.forms.' . $this->request->get('form_alias', 'default_form') . '.validation'));

        if (!$result) {
            if ($this->request->ajax()) {
                return response()->json(response_with_messages($validator->getOnlyMessages(), true, \Constants::ERROR_CODE));
            }
            flash_messages()
                ->addMessages($validator->getOnlyMessages(), 'danger')
                ->showMessagesOnSession();
            return redirect()->back()->withInput();
        }

        $result = $this->repository
            ->create(array_merge($this->normalFields, [
                'options' => json_encode($this->options)
            ]));

        if ($this->request->ajax()) {
            if (!$result) {
                return response()->json(response_with_messages(trans('webed-contact-form::messages.failed'), true, \Constants::ERROR_CODE));
            }
            return response()->json(response_with_messages(trans('webed-contact-form::messages.success'), true, \Constants::SUCCESS_NO_CONTENT_CODE));
        }

        if (!$result) {
            flash_messages()
                ->addMessages(trans('webed-contact-form::messages.failed'), 'danger');
        } else {
            flash_messages()
                ->addMessages(trans('webed-contact-form::messages.success'), 'success');
        }

        flash_messages()->showMessagesOnSession();

        return redirect()->back();
    }
}
