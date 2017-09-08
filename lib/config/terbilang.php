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

   /*
   |--------------------------------------------------------------------------
   | Short Output
   |--------------------------------------------------------------------------
   |
   | This value is short config
   | default value is million
   | available value 'kilo, million, billion, trillion'
   */
   'short' => 'million',


   /*
   |--------------------------------------------------------------------------
   | Period Output Format
   |--------------------------------------------------------------------------
   |
   | This value is output format for function Terbilang::period()
   | default format FULL, available format FULL, YEAR, MONTH, DAY, HOUR, MINUTE, SECOND
   */
   'period' => [
       'type' => 'DAY',
       'format' => '{YEAR} {MONTH} {DAY} {HOUR} {MINUTE} {SECOND}',
       'hide_zero_value' => true,
       'separator' => ' ',
       'terbilang' => false,
       'show' => [
           'year' => true,
           'month' => true,
           'day' => true,
           'hour' => true,
           'minute' => true,
           'second' => true,
       ]
   ],
];
