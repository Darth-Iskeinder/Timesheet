<?php

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Resource as AclResource;
use Phalcon\Acl\Adapter\Memory as AclMemory;

class Acl extends Component
{
    /**
     * The ACL Object
     *
     * @var \Phalcon\Acl\Adapter\Memory
     */
    private $acl;

    private $privateResources = array();

    public function isAllowed($role, $controller, $action)
    {
        return $this->getAcl()->isAllowed($role, $controller, $action);
    }

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

    public function rebuild()
    {

        $acl = new AclMemory();

        $acl->setDefaultAction(\Phalcon\Acl::DENY);

        $acl->addRole('guest');
        $acl->addRole('user');
        $acl->addRole('admin');

        foreach ($this->privateResources as $resource => $actions) {
            $acl->addResource(new AclResource($resource), $actions);
        }

       // $acl->allow('guest', 'SessionController', ['login']);
       // $acl->allow('user', 'SessionController', '*');
       // $acl->allow('user', 'timesheet', '*');
        $acl->allow('admin', '*', '*');
       // $acl->allow('admin', 'SessionController', '*');
      //  print_arr($acl);

      //print_die($acl);

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