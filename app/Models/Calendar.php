<?php

namespace App\Models;

use App\Helpers;
use Carbon\Carbon;

class Calendar
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->naviHref = config('app.url') . "/wcalendar";
    }

    /********************* PROPERTY ********************/
    private $dayLabels = array("Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim");
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;
    private $naviHref = null;

    /********************* PUBLIC **********************/


    public function getNaviHref()
    {
        return $this->naviHref;
    }

    public function getOutDays()
    {
        Helpers::$days['out'] = [
            Carbon::parse(($_GET['year'] ?? Carbon::now('Europe/Paris')->year) . '-01-01', 'Europe/Paris')->toDateString(),
            Carbon::parse(($_GET['year'] ?? Carbon::now('Europe/Paris')->year) . '-05-01', 'Europe/Paris')->toDateString(),
            Carbon::parse(($_GET['year'] ?? Carbon::now('Europe/Paris')->year) . '-05-08', 'Europe/Paris')->toDateString(),
            Carbon::parse(($_GET['year'] ?? Carbon::now('Europe/Paris')->year) . '-07-14', 'Europe/Paris')->toDateString(),
            Carbon::parse(($_GET['year'] ?? Carbon::now('Europe/Paris')->year) . '-08-15', 'Europe/Paris')->toDateString(),
            Carbon::parse(($_GET['year'] ?? Carbon::now('Europe/Paris')->year) . '-11-01', 'Europe/Paris')->toDateString(),
            Carbon::parse(($_GET['year'] ?? Carbon::now('Europe/Paris')->year) . '-11-11', 'Europe/Paris')->toDateString(),
            Carbon::parse(($_GET['year'] ?? Carbon::now('Europe/Paris')->year) . '-12-25', 'Europe/Paris')->toDateString(),

            // Lundi de pâques
            Carbon::parse('2018-04-02', 'Europe/Paris')->toDateString(),
            Carbon::parse('2019-04-22', 'Europe/Paris')->toDateString(),
            Carbon::parse('2020-04-13', 'Europe/Paris')->toDateString(),
            Carbon::parse('2021-04-05', 'Europe/Paris')->toDateString(),
            Carbon::parse('2022-04-18', 'Europe/Paris')->toDateString(),

            // Jeudi de l'ascencion
            Carbon::parse('2018-05-10', 'Europe/Paris')->toDateString(),
            Carbon::parse('2019-05-30', 'Europe/Paris')->toDateString(),
            Carbon::parse('2020-05-21', 'Europe/Paris')->toDateString(),
            Carbon::parse('2021-05-13', 'Europe/Paris')->toDateString(),
            Carbon::parse('2022-05-26', 'Europe/Paris')->toDateString(),

            // Lundi de pentecôte
            Carbon::parse('2018-05-21', 'Europe/Paris')->toDateString(),
            Carbon::parse('2019-06-10', 'Europe/Paris')->toDateString(),
            Carbon::parse('2020-06-01', 'Europe/Paris')->toDateString(),
            Carbon::parse('2021-05-24', 'Europe/Paris')->toDateString(),
            Carbon::parse('2022-06-06', 'Europe/Paris')->toDateString(),
        ];
        session(['out' => Helpers::$days['out']]);
    }

    /**
     * print out the calendar
     */
    public function show()
    {
        $year = $_GET['year'] ?? Carbon::now('Europe/Paris')->year;
        $month = $_GET['month'] ?? Carbon::now('Europe/Paris')->month;

//        $day = Carbon::parse($year . '-' . $month . '-01');
//        $weeksInMonth = (new Carbon('last day of ' . Carbon::parse($year . '-' . $month . '-01')->format('F') . " $year"))->weekOfMonth + 1;

        $this->currentYear = $year;
        $this->currentMonth = $month;
        $this->daysInMonth = Carbon::parse($year . '-' . $month . '-01')->daysInMonth;

        $content = ' <div id="calendar"> ' .
            '<div class="box-content"> ' .
            '<ul class="label row pl-0 mb-0 mt-1"> ' . $this->_createLabels() . '</ul> ';
        $content .= '<div class="clear"></div> ';
        $content .= '<ul class="dates row pl-0"> ';

        $weeksInMonth = $this->_weeksInMonth($month, $year) + 1;

        // Create weeks in a month
        for ($i = 0; $i < $weeksInMonth; $i++)
            //Create days in a week
            for ($j = 1; $j <= 7; $j++)
                $content .= $this->_showDay(($i * 7 + $j));

        $content .= '</ul> ';
        $content .= '<div class="clear"></div> ';
        $content .= '</div>';
        $content .= '</div>';
        return $content;
    }

    public function navigation()
    {
        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');

        $this->currentYear = $_GET['year'] ?? Carbon::now('Europe/Paris')->year;
        $this->currentMonth = $_GET['month'] ?? Carbon::now('Europe/Paris')->month;

        $nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth) + 1;
        $nextYear = $this->currentMonth == 12 ? intval($this->currentYear) + 1 : $this->currentYear;

        $preMonth = $this->currentMonth == 1 ? 12 : intval($this->currentMonth) - 1;
        $preYear = $this->currentMonth == 1 ? intval($this->currentYear) - 1 : $this->currentYear;

        return [
            "prev"  => "$this->naviHref?month=" . sprintf('%02d', $preMonth) . "&year=" . sprintf('%02d', $preYear),
            "next"  => "$this->naviHref?month=" . sprintf('%02d', $nextMonth) . "&year=" . sprintf('%02d', $nextYear),
            "today" => "$this->naviHref?month=" . sprintf('%02d', Carbon::now('Europe/Paris')->month) . "&year=" . sprintf('%02d', Carbon::now('Europe/Paris')->year),
            "month" => $this->currentMonth,
            "year"  => $this->currentYear,
            "date"  => Carbon::createFromFormat('Y-m', "$this->currentYear-$this->currentMonth", 'Europe/Paris')->formatLocalized('%B %Y'),
        ];
    }

    /********************* PRIVATE **********************/
    /**
     * create the li element for ul
     */
    private function _showDay($cellNumber)
    {
//        $cellContent = null;
        if ($this->currentDay == 0) {
            $firstDayOfTheWeek = date('N', strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));
            if (intval($cellNumber) == intval($firstDayOfTheWeek))
                $this->currentDay = 1;
        }
//
        if (($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)) {
            $this->currentDate = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));
            $cellContent = $this->currentDay;
            $this->currentDay++;
        } else {
            $this->currentDate = null;
            $cellContent = null;
        }

        $tmp = $this->currentDate;

        if (($cellNumber % 7 === 0 || $cellNumber % 7 === 6) && !in_array($tmp, Helpers::$days['we']))
            Helpers::$days['we'][] = $tmp;
        elseif (!in_array($tmp, Helpers::$days['week']))
            Helpers::$days['week'][] = $tmp;

        session(['we' => Helpers::$days['we']]);

        $cat = $tmp !== null ? Helpers::isActive($tmp) : '';

        return ' <li data-cat="' . $cat . '" id="li-' . $this->currentDate . '" class="mcol-7 ' . $cat . ($cellNumber % 7 === 1 ? ' start ' : ($cellNumber % 7 === 0 || $cellNumber % 7 === 6 ? ' end active we' : '')) .
            ($cellContent == null ? ' mask ' : '') . '"><span class="data-cell d-flex justify-content-center align-items-center cursor-pointer">' . $cellContent . '</span></li> ';
    }

    /**
     * create navigation
     */
    private function _createNavi()
    {

        $nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth) + 1;
        $nextYear = $this->currentMonth == 12 ? intval($this->currentYear) + 1 : $this->currentYear;
        $preMonth = $this->currentMonth == 1 ? 12 : intval($this->currentMonth) - 1;
        $preYear = $this->currentMonth == 1 ? intval($this->currentYear) - 1 : $this->currentYear;

        return
            '<div class="header"> ' .
            '<a class="prev" href="' . $this->naviHref . '?month=' . sprintf('%02d', $preMonth) . '&year=' . $preYear . '"><i class="fa fa-chevron-left"></i></a> ' .
            '<span class="title">&nbsp;' . date('Y M', strtotime($this->currentYear . '-' . $this->currentMonth . '-1')) . '&nbsp;</span> ' .
            '<a class="next" href="' . $this->naviHref . '?month=' . sprintf(" % 02d", $nextMonth) . '&year=' . $nextYear . '"><i class="fa fa-chevron-right"></i></a>' .
            '</div> ';
    }

    /**
     * create calendar week labels
     */
    private function _createLabels()
    {

        $content = '';
        foreach ($this->dayLabels as $index => $label)
            $content .= ' <li class="mcol-7 text-center' . ($label == 6 ? ' end ' : ' start ') . 'title"><span> ' . $label . '</span></li> ';

        return $content;
    }


    /**
     * calculate number of weeks in a particular month
     */
    private function _weeksInMonth($month = null, $year = null)
    {

        if (null == ($year))
            $year = date("Y", time());

        if (null == ($month))
            $month = date("m", time());

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month, $year);
        $numOfweeks = ($daysInMonths % 7 == 0 ? 0 : 1) + intval($daysInMonths / 7);
        $monthEndingDay = date('N', strtotime($year . '-' . $month . '-' . $daysInMonths));
        $monthStartDay = date('N', strtotime($year . '-' . $month . '-01'));

        if ($monthEndingDay < $monthStartDay)
            $numOfweeks++;

        return $numOfweeks;
    }

    /**
     * calculate number of days in a particular month
     */
    private function _daysInMonth($month = null, $year = null)
    {

        if (null == ($year))
            $year = date("Y", time());

        if (null == ($month))
            $month = date("m", time());

        return date('t', strtotime($year . '-' . $month . '-01'));
    }

}