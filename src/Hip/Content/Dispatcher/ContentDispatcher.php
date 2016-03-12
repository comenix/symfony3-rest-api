<?php

namespace Hip\Content\Dispatcher;

use Hip\AppBundle\Dispatcher\BaseDispatcher;
use Hip\AppBundle\Form\Handler\FormHandler;
use Hip\AppBundle\Entity\Content;
use Hip\Content\Repository\ContentRepository;

/**
 * Class ContentDispatcher
 * @package Hip\Content\Dispatcher
 */
class ContentDispatcher extends BaseDispatcher
{
    /**
     * ContentDispatcher constructor.
     * @param ContentRepository $contentRepository
     * @param FormHandler $formHandler
     */
    public function __construct(ContentRepository $contentRepository, FormHandler $formHandler)
    {
        $this->repository = $contentRepository;
        $this->formHandler = $formHandler;
        $this->object = new Content();
    }
}
