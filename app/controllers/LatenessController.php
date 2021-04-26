<?php


class LatenessController extends ControllerBase
{
    public function indexAction()
    {
        $users = Users::find();
        $this->view->users = $users;

    }

    public function createStartDayTimeAction()
    {
        $form = new StartDayTimeForm();
        if($this->request->isPost()){
            if($form->isValid($this->request->getPost()) == false){
                foreach ($form->getMessage() as $message){
                    $this->flash->error($message);
                }
            } else {
                $startDayTime = new StartDayTime();

                $startDayTime->setTime($this->request->getPost('time'));

                if(!$startDayTime->save()){
                    $this->flash->error($startDayTime->getMessage());
                } else{
                    $this->flash->success("Start day time was created successfully");
                    $form->clear();
                }
            }
        }
        $this->view->form = $form;
    }

    public function listAction($id)
    {
        $userLateness = WorkTime::find([
            "conditions" => "user_id = ?0 AND lateness = 1",
            "bind" => [
                $id
            ]
        ]);
        $this->view->setVars(
            [
                'id' => $id,
                'userLateness'    => $userLateness,
            ]
        );
    }

    public function deleteAction($id)
    {
        $lateness = WorkTime::findFirstById($id);
        $lateness->setLateness(0);
        if(!$lateness->save()){
            foreach ($lateness->getMessages() as $message){
                $this->flash->error($message);
            }
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