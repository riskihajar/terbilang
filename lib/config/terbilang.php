<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Date Output Format
    |--------------------------------------------------------------------------
    |
    | This value is output format for function Terbilang::date()
    | default date format is '{DAY} {MONTH} {YEAR}'
    | default time format is '{HOUR} {SEPARATOR} {MINUTE} {MINUTE_LABEL} {SECOND} {SECOND_LABEL}'
    | you can mondify for example 'day {DAY} month {MONTH} year {YEAR}'
    */
   'output' => [
       'date' => '{DAY} {MONTH} {YEAR}',
       'time' => '{HOUR} {SEPARATOR} {MINUTE} {MINUTE_LABEL} {SECOND} {SECOND_LABEL}'
   ],
];
