<?php

/**
 * Class TimesheetController
 */
class TimesheetController extends ControllerBase
{
    /**
     * Main user timesheet panel
     */
    public function indexAction()
    {
        $getMonthUsers = $this->request->get('monthUsers') ?? $this->getCurrentDateTime()->format('m');
        $getYearUsers = $this->request->get('yearUsers') ?? $this->getCurrentDateTime()->format('Y');
        $users = Users::find();
        $workTime = WorkTime::getTimesByMonthAndYear($getMonthUsers, $getYearUsers);
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
                'currentTime'    => $this->getCurrentDateTime()->format('Y-m-d'),
                'holidaysDate'    => $holidaysDate,
                'workTime'    => $workTime,
                'months'    => $this->getMonths(),
                'years'    => $this->getYears(),
                'days'    => $this->getAmountOfDays($getMonthUsers, $getYearUsers)
            ]
        );
    }

    /**
     * Create start time
     * @return json data
     */
    public function createStartAction()
    {
        $startTime = new WorkTime();
        $startDayTime = StartDayTime::findFirst();
        $startTime->setUserId($this->session->auth["id"]);
        $startTime->setStartTime($this->getCurrentDateTime()->format('H:i'));
        $startTime->setYear($this->getCurrentDateTime()->format('Y'));
        $startTime->setMonth($this->getCurrentDateTime()->format('m'));
        if($this->getCurrentDateTime()->format('H:i') > $startDayTime->getTime()){
            $startTime->setLateness(true);
        } else{
            $startTime->setLateness(false);
        }
        $startTime->setDay($this->getCurrentDateTime()->format('d'));
        if (!$startTime->save()) {
            $this->flash->error('Start Time was not save');
        }
        $userTimeId = $startTime->getId();
        $time = $this->getCurrentDateTime()->format('H:i');
        $data = [
            'time' => $time,
            'userTimeId' => $userTimeId
        ];

        return json_encode($data);
    }

    /**
     * Create end of working time
     * @return json data
     */
    public function createEndAction()
    {
        $startId = $this->request->getPost('startId');
        $userTime = WorkTime::findFirstById($startId);
        $endTime = $this->getCurrentDateTime()->format('H:i');
        $userTime->setEndTime($this->getCurrentDateTime()->format('H:i'));
        $totalTime = strtotime($endTime) - strtotime($userTime->getStartTime());
        $userTime->setTotal($totalTime);
        if($userTime->update() === false){
            $this->flash->error($userTime->getMessage());
        }

        return json_encode($endTime);
    }

    /**
     * Get amount of days in month
     * @param $month
     * @param $year
     * @return array
     */
    protected function getAmountOfDays($month, $year)
    {
        $last = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $monthDay = [];
        for ($day = 1; $day <= $last; $day++) {
            $this->getCurrentDateTime()->setDate($year, $month, $day);
            $monthDay[$day] = $this->getCurrentDateTime()->format("Y-m-d");
        }

        return $monthDay;
    }

    /**
     * Logic for change user password
     */
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