<?php

/**
 * Class LatenessController
 */
class LatenessController extends ControllerBase
{
    /**
     * List of users
     */
    public function indexAction()
    {
        $users = Users::find();
        $this->view->users = $users;
    }

    /**
     * Create start time for the day
     */
    public function createStartDayTimeAction()
    {
        $form = new StartDayTimeForm();
        if($this->request->isPost()){
            $startDayTime = new StartDayTime();
            $startDayTime->setTime($this->request->getPost('time'));
            if(!$startDayTime->save()){
                $this->flash->error($startDayTime->getMessage());
            } else{
                $this->flash->success("Start day time was created successfully");
                $form->clear();
            }
        }
        $this->view->form = $form;
    }

    /**
     * Get list of users lateness
     * @param int $id
     */
    public function listAction($id)
    {
        $userLateness = WorkTime::getUserLateness($id);
        $this->view->setVars(
            [
                'id' => $id,
                'userLateness'    => $userLateness
            ]
        );
    }

    /**
     * Delete user lateness
     * @param int $id
     */
    public function deleteAction($id)
    {
        $lateness = WorkTime::findFirstById($id);
        $lateness->setLateness(0);
        if(!$lateness->save()){
            $this->dispatcher->forward([
                'action'     => 'index',
            ]);
        }
        $this->flash->success('Lateness id'.' '.$lateness->getId() .' '.'was deleted');
        $this->dispatcher->forward([
            'action'     => 'index',
        ]);
    }
}