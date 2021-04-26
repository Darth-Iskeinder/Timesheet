<?php

use Phalcon\Mvc\Model;

class WorkTime extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $start_time;

    /**
     *
     * @var string
     */
    public $year;

    /**
     *
     * @var string
     */
    public $month;

    /**
     *
     * @var string
     */
    public $day;

    /**
     *
     * @var integer
     */
    public $end_time;

    /**
     *
     * @var boolean
     */
    public $lateness;

    /**
     * @return bool
     */
    public function isLateness(): bool
    {
        return $this->lateness;
    }

    /**
     * @param bool $lateness
     */
    public function setLateness(bool $lateness): void
    {
        $this->lateness = $lateness;
    }

    /**
     *
     * @var integer
     */
    public $total;

    public static function getTimesByMonthAndYear($getMonthUsers, $getYearUsers)
    {
        return self::find([
            "conditions" => "month = ?0 AND year = ?1",
            "bind" => [
                $getMonthUsers,
                $getYearUsers
            ]
        ]);
    }

    public static function getUserLateness($id)
    {
        return self::find([
            "conditions" => "user_id = ?0 AND lateness = 1",
            "bind" => [
                $id
            ]
        ]);
    }

    public static function getUserByMothYear($id, $getMonth, $getYear)
    {
        return self::find([
            "conditions" => "user_id = ?0 AND month = ?1 AND year = ?2",
            "bind" => [
                $id,
                $getMonth,
                $getYear
            ]
        ]);
    }
    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'user_id' => 'user_id',
            'year' => 'year',
            'month' => 'month',
            'day' => 'day',
            'start_time' => 'start_time', 
            'end_time' => 'end_time',
            'lateness' => 'lateness',
            'total' => 'total'
        );
    }

    public function initialize()
    {
        $this->belongsTo("user_id",  __NAMESPACE__ . "\Users", "id", array(
            'alias' => 'users',
            'reusable' => true
        ));
    }



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param int $start_time
     */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }

    /**
     * @return int
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param int $end_time
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     */
    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getMonth(): string
    {
        return $this->month;
    }

    /**
     * @param string $month
     */
    public function setMonth(string $month): void
    {
        $this->month = $month;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @param string $day
     */
    public function setDay(string $day): void
    {
        $this->day = $day;
    }

}
