<?php

namespace Hip\AppBundle\Provider;

use Hip\AppBundle\Exception\InvalidFormException;
use Symfony\Component\Form\Exception\AlreadySubmittedException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

use Doctrine\ORM\EntityRepository;
use Hip\AppBundle\Entity\BaseEntity;
use Hip\AppBundle\Form\Handler\FormHandler;

/**
 * Class BaseProvider
 * @package Hip\AppBundle\Provider
 */
class BaseProvider implements ProviderInterface
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var FormHandler
     */
    protected $formHandler;

    /**
     * @var BaseEntity
     */
    protected $object;

    /**
     * @param $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param $limit
     * @param $offset
     *
     * @return array
     */
    public function all($limit, $offset)
    {
        return $this->repository->findBy([], [], $limit, $offset);
    }
}
