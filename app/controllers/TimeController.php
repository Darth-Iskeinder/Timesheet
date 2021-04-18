<?php


class TimeController extends ControllerBase
{
    public function indexAction($id)
    {
        $userTimes = WorkTime::find([
            "conditions" => "user_id = ?0",
            "bind" => [
                0 => $id
            ]
        ]);

        $this->view->userTimes = $userTimes;
    }

    public function sortUserDataAction()
    {
        $test = 'Hello, i am sorter';
        try {
            var_dump($this->request->getPost('month'));
        } catch(Exception $e){
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
        }
        return json_encode($test);
    }

    public function createAction()
    {
        $form = new TimeForm();
        if($this->request->isPost()){
            if($form->isValid($this->request->getPost()) == false){
                foreach ($form->getMessage() as $message){
                    $this->flash->error($message);
                }
            } else {
                $workTime = new WorkTime();

                $workTime->setUserId($this->request->getPost('userId'));
                $workTime->setYear($this->request->getPost('year'));
                $workTime->setMonth($this->request->getPost('month'));
                $workTime->setDay($this->request->getPost('day'));
                $workTime->setStartTime($this->request->getPost('startTime'));
                $workTime->setEndTime($this->request->getPost('endTime'));
                $workTime->setTotal($this->request->getPost('total'));

                if(!$workTime->save()){
                    $this->flash->error($workTime->getMessage());
                } else{
                    $this->flash->success("WorkTime was created successfully");
                    $form->clear();
                }

            }
        }
        $this->view->form = $form;
    }

    public function updateAction($id)
    {
        $workTime = WorkTime::findFirstById($id);
        $userArray = $workTime->toArray();
        $userId = $userArray["user_id"];

        if(!$workTime){
            $this->flash->error('Work time was not found');

            $this->dispatcher->forward([
                'controller' => 'time',
                'action'     => 'index',
            ]);
            return;
        }
        $this->view->userId = $userId;
        $this->view->form = new TimeForm($workTime, ['edit' => true]);

    }

    public function saveAction()
    {
        if(!$this->request->isPost()){
            $this->response->redirect('user/index');
        }
        $workTimeId = $this->request->getPost('id');
        $workTime = WorkTime::findFirstById($workTimeId);
        $userId = $workTime->getUserId();
        if(!$workTime){
            $this->flash->error('WorkTime was not found');
            $this->dispatcher->forward([
                'controller' => 'time',
                'action'     => 'index',
                'params'     => [$userId],
            ]);
            return;
        }
        $form = new TimeForm();
        $this->view->form = $form;
        $data = $this->request->getPost();
        if(!$form->isValid($data, $workTime)){
            foreach ($form->getMessages() as $message){
                $this->flash->error($message);
            }
            $this->dispatcher->forward([
                'controller' => 'time',
                'action'     => 'update',
                'params'     => [$workTimeId],
            ]);
            return;
        }
        if(!$workTime->save()){
            foreach ($workTime->getMessages() as $message){
                $this->flash->error($message);
            }
            $this->dispatcher->forward([
                'controller' => 'time',
                'action'     => 'update',
                'params'     => [$workTimeId],
            ]);
            return;
        }
        $form->clear();
        $this->flash->success('WorkTime was updated successfully');

        $this->dispatcher->forward([
            'controller' => 'time',
            'action'     => 'index',
            'params'     => [$userId],
        ]);
    }

}