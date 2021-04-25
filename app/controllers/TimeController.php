<?php


class TimeController extends ControllerBase
{
    public function indexAction($id)
    {
        $currentDate = new DateTime();
        if($this->request->get('month') && $this->request->get('year')){
            $getMonth = $this->request->get('month');
            $getYear = $this->request->get('year');
        } else{
            $getMonth = $currentDate->format('m');
            $getYear = $currentDate->format('Y');
        }

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
        $this->view->years = $this->getYears();
        $this->view->months = $this->getMonths();
        $this->view->userId = $id;
        $this->view->userTimes = $userTimes;
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
                $workTime->setEndTime($this->request->getPost('end_time'));
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