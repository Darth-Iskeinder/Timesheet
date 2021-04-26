<?php
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
class TimesheetController extends ControllerBase
{
    public function indexAction()
    {
        $this->getYears();
        $currentTime = new DateTime();
        if($this->request->get('monthUsers') && $this->request->get('yearUsers')){
            $getMonthUsers = $this->request->get('monthUsers');
            $getYearUsers = $this->request->get('yearUsers');
        } else {
            $getMonthUsers = $currentTime->format('m');
            $getYearUsers = $currentTime->format('Y');
        }
        $users = Users::find();

        //Get all workTime
        $workTime = WorkTime::getTimesByMonthAndYear($getMonthUsers, $getYearUsers);
        //Generate days for table
        $holidays = Holidays::find()->toArray();
        $holidaysDate = [];
        foreach ($holidays as $holiday){
            $holidaysDate[] = $holiday['date'];
        }
        $startDayTime = StartDayTime::findFirst();
        $startDay = $startDayTime->getTime();
        $this->view->setVars(
            [
                'users' => $users,
                'startDay'    => $startDay,
                'getMonthUsers'    => $getMonthUsers,
                'getYearUsers'    => $getYearUsers,
                'currentTime'    => $currentTime->format('Y-m-d'),
                'holidaysDate'    => $holidaysDate,
                'workTime'    => $workTime,
                'months'    => $this->getMonths(),
                'years'    => $this->getYears(),
                'days'    => $this->getAmountOfDays($getMonthUsers, $getYearUsers)
            ]
        );
    }

    public function createStartAction()
    {
        $dateTime = new DateTime();
        $startTime = new WorkTime();
        $startDayTime = StartDayTime::findFirst();

        $startTime->setUserId($this->session->auth["id"]);
        $startTime->setStartTime($dateTime->format('H:i'));
        $startTime->setYear($dateTime->format('Y'));
        $startTime->setMonth($dateTime->format('m'));
        if($dateTime->format('H:i') > $startDayTime->getTime()){
            $startTime->setLateness(true);
        } else{
            $startTime->setLateness(false);
        }

        $startTime->setDay($dateTime->format('d'));

        if (!$startTime->save()) {
            $this->flash->error('Start Time was not save');
        }

        $userTimeId = $startTime->getId();
        $time = $dateTime->format('H:i');
        $data = [
            'time' => $time,
            'userTimeId' => $userTimeId
        ];

        return json_encode($data);
    }

    public function createEndAction()
    {
        $startId = $this->request->getPost('startId');
        $userTime = WorkTime::findFirstById($startId);
        $time = new DateTime();
        $endTime = $time->format('H:i');
        $userTime->setEndTime($time->format('H:i'));
        $totalTime = strtotime($endTime) - strtotime($userTime->getStartTime());

        $userTime->setTotal($totalTime);
        if($userTime->update() === false){
            $this->flash->error($userTime->getMessage());
        }

        return json_encode($endTime);
    }

    protected function getAmountOfDays($month, $year)
    {
        $last = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $date = new DateTime();
        $monthDay = [];

        for ($day = 1; $day <= $last; $day++) {
            $date->setDate($year, $month, $day);
            $monthDay[$day]=$date->format("Y-m-d");
        }
        return $monthDay;
    }

    public function changePasswordAction()
    {
        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {
            $auth = $this->session->get('auth');
            $user = Users::findFirstById($auth['id']);
            if(sha1($this->request->getPost('oldPassword')) === $user->getPassword()){
                $user->setPassword(sha1($this->request->getPost('password')));
                if (!$user->save()) {
                    $this->flash->error('Password doesnt saved');
                } else {
                    $this->flash->success('Your password was successfully changed');

                    $form->clear();
                }
            } else{
                $form->clear();
                $this->flash->error('Old password is not correct!');
            }
        }

        $this->view->form = $form;
    }
}