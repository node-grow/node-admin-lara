<?php

namespace NodeAdmin\Lib;

use Illuminate\Routing\ResourceRegistrar;
use Illuminate\Routing\Router;

class NodeResourceRegistrar extends ResourceRegistrar
{

    public function __construct(Router $router)
    {
        $this->resourceDefaults[]='forbid';
        $this->resourceDefaults[]='resume';

        static::verbs([
            'forbid'=>'forbid',
            'resume'=>'resume'
        ]);

        parent::__construct($router);
    }

    /**
     * Add the forbid method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceForbid($name, $base, $controller, $options)
    {

        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}/'.static::$verbs['forbid'];

        $action = $this->getResourceAction($name, $controller, 'forbid', $options);

        return $this->router->match(['PUT','PATCH'],$uri, $action);
    }

    /**
     * Add the resume method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceResume($name, $base, $controller, $options)
    {

        $name = $this->getShallowName($name, $options);

        $uri = $this->getResourceUri($name).'/{'.$base.'}/'.static::$verbs['resume'];

        $action = $this->getResourceAction($name, $controller, 'resume', $options);

        return $this->router->match(['PUT','PATCH'],$uri, $action);
    }
}
