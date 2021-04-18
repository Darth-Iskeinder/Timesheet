<?php


class TimesheetController extends ControllerBase
{
    public function indexAction()
    {
        $currentTime = new DateTime();
        $this->view->currentTime = $currentTime->format('Y-m-d');
        $users = Users::find();
        $this->view->users = $users;
        $days = $this->getAmountOfDaysAction();
        $this->view->days = $days;
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
        $time = new DateTime();
        $endTime = $time->format('H:i');
        $startId = $this->request->getPost('startId');
        $userTime = WorkTime::findFirstById($startId);
        $userTime->setEndTime($time->format('H:i'));

        $totalTime = strtotime($endTime) - strtotime($userTime->getStartTime());

        $userTime->setTotal($totalTime);
        if($userTime->update() === false){
            $messages = $userTime->getMessages();
            foreach ($messages as $message){
                echo $message, "\n";
            }
        };
        return json_encode($endTime);
    }

    public function getAmountOfDaysAction()
    {
        $year = date('Y');
        $month = date('m');

        $last = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $date = new DateTime();
        $monthDay = [];

        for ($day=1;$day<=$last;$day++) {
            $date->setDate($year, $month, $day);

            $monthDay[$day]=$date->format("l");
        }
        return $monthDay;
    }
}