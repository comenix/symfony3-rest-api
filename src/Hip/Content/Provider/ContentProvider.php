<?php

namespace Hip\Content\Provider;

use Hip\AppBundle\Provider\BaseProvider;
use Hip\AppBundle\Form\Handler\FormHandler;
use Hip\AppBundle\Entity\Content;
use Hip\Content\Repository\ContentRepository;

/**
 * Class ContentProvider
 * @package Hip\Content\Provider
 */
class ContentProvider extends BaseProvider
{
    /**
     * ContentProvider constructor.
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
