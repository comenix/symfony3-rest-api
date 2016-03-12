<?php

namespace Hip\AppBundle\Provider;

/**
 * Interface ProviderInterface
 * @package Hip\AppBundle\Provider
 */
interface ProviderInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param $limit
     * @param $offset
     * @return mixed
     */
    public function all($limit, $offset);
}
