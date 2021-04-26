<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {

        $controllerName = $dispatcher->getControllerName();
        if($this->acl->isPrivate($controllerName)){
            $role = $this->session->auth['role'];

            if(!$role){
                $this->flash->notice('You don\'t have access to this module: private');
                $dispatcher->forward([
                    'controller' => 'index',
                    'action' => 'index'
                ]);
                return false;
            }
            $actionName = $dispatcher->getActionName();

            if(!$this->acl->isAllowed($role, $controllerName, $actionName)){
                echo 'Here';
                $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

                if ($this->acl->isAllowed($role, $controllerName, $actionName)) {
                    $dispatcher->forward([
                        'controller' => $controllerName,
                        'action' => $actionName
                    ]);
                } else {
                    $dispatcher->forward([
                        'controller' => 'index',
                        'action' => 'index'
                    ]);
                }
                return false;
            }

        }

    }

    public function getMonths()
    {
        $months = [];
        for ($i = 1; $i < 13; $i++) {
            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
            $months[date('n', $timestamp)] = date('F', $timestamp);
        }
        return $months;
    }

    public function getYears()
    {
        $years = [];
        $workTimes = WorkTime::find()->toArray();
        foreach ($workTimes as $workTime){
            $years[$workTime['year']] = $workTime['year'];
        }
        return array_unique($years);
    }

}
