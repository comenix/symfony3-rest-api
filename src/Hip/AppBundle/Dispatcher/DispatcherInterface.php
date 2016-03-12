<?php

namespace Hip\AppBundle\Dispatcher;

use Hip\AppBundle\Entity\BaseEntity;
use Hip\Content\Model\ContentInterface;

/**
 * Interface DispatcherInterface
 * @package Hip\AppBundle\Dispatcher
 */
interface DispatcherInterface
{
    /**
     * @param array $parameters
     * @return mixed
     */
    public function post(array $parameters);

    /**
     * @param BaseEntity $baseEntity
     * @param array $parameters
     * @return mixed
     */
    public function put(BaseEntity $baseEntity, array $parameters);

    /**
     * @param BaseEntity $baseEntity
     * @param array $parameters
     * @return mixed
     */
    public function patch(BaseEntity $baseEntity, array $parameters);

    /**
     * @param BaseEntity $baseEntity
     * @return mixed
     */
    public function delete(BaseEntity $baseEntity);
}
