<?php

namespace App\Http\Helpers;

use App\Models\ActivityPrice;

trait ActivityListingCalenderTrait
{
    public function generateForActivity($activity_id = '', $year = '', $month = '')
    {
        if ($year == '') {
            $year  = date('Y');
        }

        if ($month == '') {
            $month = date('m');
        }

        $activityPrice = ActivityPrice::where('activity_id', $activity_id)->first();

        $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $startDays = array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
        $startDay  = (!isset($startDays[$this->startDay])) ? 0 : $startDays[$this->startDay];

        $localDate = mktime(12, 0, 0, $month, 1, $year);
        $date       = getdate($localDate);
        $day        = $startDay + 1 - $date["wday"];

        $prvTime  = mktime(12, 0, 0, $month - 1, 1, $year);
        $nxtTime  = mktime(12, 0, 0, $month + 1, 1, $year);


        $prvMonth = date('m', $prvTime);
        $nxtMonth = date('m', $nxtTime);

        $prvYear  = date('Y', $prvTime);
        $nxtYear  = date('Y', $nxtTime);


        $curDay    = date('j');
        $curYear   = date('Y');
        $curMonth  = date('m');
        $currentDate =  new \DateTime($curDay . "-" . $curMonth . "-" . $curYear);

        $prevTotalDays = date('t', $prvTime);

        while ($day > 1) {
            $day -= 7;
        }

        $monthSelect = '<select name="year_month" id="calendar_dropdown">';
        $yearMonth   = $this->year_month();
        foreach ($yearMonth as $key => $value) {
            $selected = date('Y-m', $localDate) == $key ? 'selected' : '';
            $monthSelect .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }
        $monthSelect .= '</select>';

        $out = '';
        $out .= '<div class="host-calendar-container"><div class="calendar-month">';

        $out .= '<div class="row-space-2 deselect-on-click">
                    <a href="' . url('admin/manage-listing/' . $activity_id . '/calendar') . '" class="month-nav month-nav-previous panel text-center" data-year="' . $prvYear . '" data-month="' . $prvMonth . '"> <i class="fa fa-chevron-left fa-lg calendar-icon-style"></i> </a>
                    <a href="' . url('admin/manage-listing/' . $activity_id . '/calendar') . '" class="month-nav month-nav-next panel text-center" data-year="' . $nxtYear . '" data-month="' . $nxtMonth . '"> <i class="fa fa-chevron-right fa-lg calendar-icon-style"></i> </a>
                    <div class="current-month-selection"> <h2> <span>' . date('F Y', $localDate) . '</span> <span> &nbsp;</span> <span class="current-month-arrow">▾</span> </h2>' . $monthSelect . '<div class="spinner-next-to-month-nav">Just a moment...</div></div>
                </div>';

        $out .= '<div class="col-md-12 col-sm-12 col-xs-12"><div class="calenBox">';
        $out .= '<div class="margin-top10">
                    <div class="col-md-02"><div class="wkText">Mon</div></div>
                    <div class="col-md-02"><div class="wkText">Tue</div></div>
                    <div class="col-md-02"><div class="wkText">Wed</div></div>
                    <div class="col-md-02"><div class="wkText">Thu</div></div>
                    <div class="col-md-02"><div class="wkText">Fri</div></div>
                    <div class="col-md-02"><div class="wkText">Sat</div></div>
                    <div class="col-md-02"><div class="wkText">Sun</div></div>
                </div>';

        while ($day <= $totalDays) {
            for ($i = 0; $i < 7; $i++) {
                $class = '';
                if ($day < $curDay && $year <= $curYear && $month <= $curMonth) {
                    $class = 'dt-not-available';
                } elseif ($year < $curYear || $month < $curMonth) {
                    $class = 'dt-not-available';
                } elseif ($day == $curDay && $year == $curYear && $month == $curMonth) {
                    $class = 'dt-today';
                }


                if ($year > $curYear) {
                    $class = '';
                }

                $today = '';
                if ($day == $curDay && $year == $curYear && $month == $curMonth) {
                    $today = 'Today';
                }


                if ($day > 0 && $day <= $totalDays) {
                    $date      = $year . '-' . $month . '-' . $this->zeroDigit($day);

                    $finalDay = $day;
                } else {
                    if ($day <= 0) {
                        $dayPrev  = $prevTotalDays + $day;

                        $date      = $prvYear . '-' . $prvMonth . '-' . $this->zeroDigit($dayPrev);

                        $finalDay = $dayPrev;
                    } elseif ($day > $totalDays) {
                        $dayNext  = $day - $totalDays;

                        $date      = $nxtYear . '-' . $nxtMonth . '-' . $this->zeroDigit($dayNext);

                        $finalDay = $dayNext;
                    }
                }

                $dateGreaterThanToday = (new \DateTime($date)) > $currentDate;
                //Price Tyoe Calendar
                if ($dateGreaterThanToday && ($activityPrice->available($date) == 'Not available') && ($activityPrice->type($date) == 'calendar') && (($activityPrice->color($date)) != null)) {
                    $class = 'dt-available-with-events';
                    $out .= '<div class="col-md-02" style="cursor:pointer">
                                <div class="calender_box date-package-modal-admin ' . $class . '" style="background-color:' . $activityPrice->color($date) . ' !important " id="' . $date . '" data-day="' . $day . '" data-month="' . $month . '" data-year="' . $year . '" data-price="' . $activityPrice->original_price($date) . '"data-status="' . $activityPrice->available($date) . '" data-minday="' . $activityPrice->min_day($date) . '" data-minday="' . $activityPrice->min_day($date) . '">
                                    <div class="wkText final_day">' . $finalDay . ' ' . $today . '</div>
                                    <div class="dTfont wkText">' . $activityPrice->currency->org_symbol . $activityPrice->original_price($date) . '</div>
                                </div>
                            </div>';
                } elseif (($year >= $curYear && $month >= $curMonth) && ($activityPrice->available($date) == 'Not available') && ($activityPrice->type($date) == 'calendar') && (($activityPrice->color($date)) != null)) {
                    if (!$dateGreaterThanToday) {
                        $class = 'dt-not-available';
                        $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal-admin ' . $class . '" id="' . $date . '" data-day="' . $day . '" data-month="' . $month . '" data-year="' . $year . '" data-price="' . $activityPrice->original_price($date) . '"data-status="' . $activityPrice->available($date) . '" data-minday="' . $activityPrice->min_day($date) . '">
                                        <div class="wkText final_day">' . $finalDay . ' ' . $today . '</div>
                                        <div class="dTfont wkText">' . $activityPrice->currency->org_symbol . $activityPrice->original_price($date) . '</div>
                                    </div>
                                </div>';
                    } else {
                        $out .= '<div class="col-md-02">
                                <div class="calender_box date-package-modal-admin"  style="background-color:' . $activityPrice->color($date) . ' !important " id="' . $date . '" data-day="' . $day . '" data-month="' . $month . '" data-year="' . $year . '" data-price="' . $activityPrice->original_price($date) . '"data-status="' . $activityPrice->available($date) . '" data-minday="' . $activityPrice->min_day($date) . '">
                                    <div class="wkText final_day">' . $finalDay . ' ' . $today . '</div>
                                    <div class="dTfont wkText">' . $activityPrice->currency->org_symbol . $activityPrice->original_price($date) . '</div>
                                </div>
                            </div>';
                    }
                } elseif ($dateGreaterThanToday && ($activityPrice->available($date) == 'Not available') && ($activityPrice->type($date) == 'normal')) {
                    $class = 'dt-available-with-events';
                    $out .= '<div class="col-md-02" style="cursor:pointer">
                            <div class="calender_box date-package-modal-admin ' . $class . '" id="' . $date . '" data-day="' . $day . '" data-month="' . $month . '" data-year="' . $year . '" data-price="' . $activityPrice->original_price($date) . '"data-status="' . $activityPrice->available($date) . '" data-minday="' . $activityPrice->min_day($date) . '">
                                <div class="wkText final_day">' . $finalDay . ' ' . $today . '</div>
                                <div class="dTfont wkText">' . $activityPrice->currency->org_symbol . $activityPrice->original_price($date) . '</div>
                            </div>
                        </div>';
                } elseif (($year >= $curYear && $month >= $curMonth) && ($activityPrice->available($date) == 'Not available') && ($activityPrice->type($date) == 'normal')) {
                    if (!$dateGreaterThanToday) {
                        $class = 'dt-not-available';
                    } else {
                        $class = 'dt-available-with-events';
                    }

                    $out .= '<div class="col-md-02">
                                    <div class="calender_box date-package-modal-admin ' . $class . '" id="' . $date . '" data-day="' . $day . '" data-month="' . $month . '" data-year="' . $year . '" data-price="' . $activityPrice->original_price($date) . '"data-status="' . $activityPrice->available($date) . '" data-minday="' . $activityPrice->min_day($date) . '">
                                        <div class="wkText final_day">' . $finalDay . ' ' . $today . '</div>
                                        <div class="dTfont wkText">' . $activityPrice->currency->org_symbol . $activityPrice->original_price($date) . '</div>
                                    </div>
                                </div>';
                } else {
                    $out .= '<div class="col-md-02" style="cursor:pointer">
                            <div class="calender_box date-package-modal-admin ' . $class . '" id="' . $date . '" data-day="' . $day . '" data-month="' . $month . '" data-year="' . $year . '" data-price="' . $activityPrice->original_price($date) . '"data-status="' . $activityPrice->available($date) . '" data-minday="' . $activityPrice->min_day($date) . '">
                                <div class="wkText final_day">' . $finalDay . ' ' . $today . '</div>
                                <div class="dTfont wkText">' . $activityPrice->currency->org_symbol . $activityPrice->original_price($date) . '</div>
                            </div>
                        </div>';
                }

                $day++;
            }
        }


        $out .= '</div></div></div></div>';

        return $out;
    }
}
