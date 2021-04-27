<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Resource as AclResource;
use Phalcon\Acl\Adapter\Memory as AclList;

class Acl extends Component
{
    /**
     * The ACL Object
     */
    private $acl;

    /**
     * @var array
     */
    private $privateResources = [];

    /**
     * Check allow permissions
     * @param $role
     * @param $controller
     * @param $action
     * @return mixed
     */
    public function isAllowed($role, $controller, $action)
    {
        return $this->getAcl()->isAllowed($role, $controller, $action);
    }

    /**
     * @return AclList
     */
    public function getAcl()
    {
        // Check if the ACL is already created
        if (is_object($this->acl)) {
            return $this->acl;
        } else{
          //  print_die($this->rebuild());
            return $this->acl = $this->rebuild();
        }
    }

    /**
     * Build ACL
     * @return AclList
     */
    public function rebuild()
    {
        $acl = new AclList();

        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        $acl->addRole('user');
        $acl->addRole('admin');

        foreach ($this->privateResources as $resource => $actions) {
            $acl->addResource(new AclResource($resource), $actions);
        }

        $acl->allow('admin', '*', '*');
        $acl->allow('user', 'timesheet', '*');

        return $acl;
    }

    /**
     * Checks if a controller is private or not
     *
     * @param string $controllerName
     * @return boolean
     */
    public function isPrivate($controllerName)
    {
        $controllerName = strtolower($controllerName);
        return isset($this->privateResources[$controllerName]);
    }

    /**
     * Add private resource
     * @param array $resources
     */
    public function addPrivateResources(array $resources)
    {
        if (count($resources) > 0) {
            $this->privateResources = array_merge($this->privateResources, $resources);
            if (is_object($this->acl)) {
                $this->acl = $this->rebuild();
            }
        }
    }
}