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


        $this->view->getMonthUsers = $getMonthUsers;
        $this->view->getYearUsers = $getYearUsers;

        //Get current time

        $this->view->currentTime = $currentTime->format('Y-m-d');

        //Get all users
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
        $this->view->workTime = $workTime;

        //Array of months and years
        $months = [1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July ', 8=>'August',
            9=>'September', 10=>'October', 11=>'November', 12=>'December',];
        $years = [2015=>'2015', 2016=>'2016', 2017=>'2017', 2018=>'2018', 2019=>'2019', 2020=>'2020', 2021=>'2021'];
        $this->view->months = $months;
        $this->view->years = $years;

        //Generate days for table
        $holidays = Holidays::find();
        $holidaysArray = $holidays->toArray();
        $holidaysDate = [];
        foreach ($holidaysArray as $holiday){
            $holidaysDate[] = $holiday['date'];
        }

        $this->view->holidaysDate = $holidaysDate;
        $this->view->days = $this->getAmountOfDays($getMonthUsers, $getYearUsers);
    }

    public function createStartAction()
    {
        $dateTime = new DateTime();
        $startTime = new WorkTime();

        $startTime->setUserId($this->session->auth["id"]);
        $startTime->setStartTime($dateTime->format('H:i'));
        $startTime->setYear($dateTime->format('Y'));
        $startTime->setMonth($dateTime->format('m'));
        $startTime->setDay($dateTime->format('d'));

        if ($startTime->save() === false) {
            echo "Мы не можем сохранить: \n";

            $messages = $startTime->getMessages();

            foreach ($messages as $message) {
                echo $message, "\n";
            }
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
            $messages = $userTime->getMessages();
            foreach ($messages as $message){
                echo $message, "\n";
            }
        }

        return json_encode($endTime);
    }

    protected function getAmountOfDays($month, $year)
    {
//        $year = date('Y');
//        $month = date('m');

        $last = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $date = new DateTime();
        $monthDay = [];

        for ($day=1;$day<=$last;$day++) {
            $date->setDate($year, $month, $day);

            $monthDay[$day]=$date->format("Y-m-d");
        }
        return $monthDay;
    }
}