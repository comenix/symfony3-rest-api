<?php

namespace Hip\AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Hip\AppBundle\Provider\BaseProvider;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Hip\AppBundle\Dispatcher\DispatcherInterface;
use Hip\AppBundle\Provider\ProviderInterface;

/**
 * Class BaseController
 *
 * By using "implements ClassResourceInterface" we can omit the Class name from the action methods
 * "class ContentController extends FOSRestController implements ClassResourceInterface"
 * For example, "getAction" instead of "getContentAction" and "cgetAction" instead of "getContentsAction"
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#implicit-resource-name-definition
 *
 * Using this controller as the routing.yml resource, will tell Symfony2 to automatically generate proper REST routes
 * from this controller action names.
 * Notice "type: rest" option (in routing.yml) is required so that the RestBundle can find which routes are supported.
 * see: http://symfony.com/doc/master/bundles/FOSRestBundle/5-automatic-route-generation_single-restful-controller.html#single-restful-controller-routes
 *
 *
 * @package Hip\AppBundle\Controller
 */
class BaseController extends FOSRestController
{

    /**
     * @var ContainerInterface
     *
     * @api
     */
    protected $container;

    /**
     * @var DispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var ProviderInterface
     */
    protected $provider;

    /**
     * @param $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    protected function fetchResponse($id)
    {
        $response = $this->provider->get($id);

        if ($response === null) {
            throw new NotFoundHttpException();
        }

        return $response;
    }
}
