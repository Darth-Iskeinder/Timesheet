<?php


class TimeController extends ControllerBase
{
    public function indexAction($id)
    {
        $getMonth = $this->request->get('month');
        $getYear = $this->request->get('year');
        $months = [1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July ', 8=>'August',
            9=>'September', 10=>'October', 11=>'November', 12=>'December',];
        $years = [2015=>'2015', 2016=>'2016', 2017=>'2017', 2018=>'2018', 2019=>'2019', 2020=>'2020', 2021=>'2021'];

        $userTimes = WorkTime::find([
            "conditions" => "user_id = ?0 AND month = ?1 AND year = ?2",
            "bind" => [
                $id,
                $getMonth,
                $getYear
            ]
        ]);
        $this->view->getMonth = $getMonth;
        $this->view->getYear = $getYear;
        $this->view->years = $years;
        $this->view->months = $months;
        $this->view->userId = $id;
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