<?php


class TimesheetController extends ControllerBase
{
    public function indexAction()
    {
        $currentTime = new DateTime();
        if($this->request->get('monthUsers') && $this->request->get('yearUsers')){
            $getMonthUsers = $this->request->get('monthUsers');
            $getYearUsers = $this->request->get('yearUsers');
        } else {
            $getMonthUsers = $currentTime->format('m');
            $getYearUsers = $currentTime->format('Y');
        }
        $users = Users::find();
        $this->view->users = $users;
        //Get all workTime
        $workTime = WorkTime::find([
            "conditions" => "month = ?0 AND year = ?1",
            "bind" => [
                $getMonthUsers,
                $getYearUsers
            ]
        ]);

        //Generate days for table
        $holidays = Holidays::find();
        $holidaysArray = $holidays->toArray();
        $holidaysDate = [];
        foreach ($holidaysArray as $holiday){
            $holidaysDate[] = $holiday['date'];
        }
        $startDayTime = StartDayTime::findFirst();
        $startDay = $startDayTime->getTime();
        $this->view->startDay = $startDay;
        $this->view->getMonthUsers = $getMonthUsers;
        $this->view->getYearUsers = $getYearUsers;
        $this->view->currentTime = $currentTime->format('Y-m-d');
        $this->view->holidaysDate = $holidaysDate;
        $this->view->workTime = $workTime;
        $this->view->months = $this->getMonths();
        $this->view->years = $this->getYears();
        $this->view->days = $this->getAmountOfDays($getMonthUsers, $getYearUsers);
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
}