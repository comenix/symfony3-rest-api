<?php

namespace Hip\AppBundle\Exception;

use \Symfony\Component\Form\FormInterface;

class InvalidFormException extends \RuntimeException
{
    const DEFAULT_ERROR_MESSAGE = 'The data submitted to the form was invalid.';

    protected $form;

    /**
     * InvalidFormException constructor.
     * @param FormInterface|null $form
     * @param string $message
     */
    public function __construct(FormInterface $form = null, $message = self::DEFAULT_ERROR_MESSAGE)
    {
        //$message .= $form->getErrors();
        parent::__construct($message);

        $this->form = $form;
    }

    /**
     * @return null
     */
    public function getForm()
    {
        return $this->form;
    }
}
