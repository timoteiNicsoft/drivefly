<?php
namespace App\Helpers;

/**
 * Return a relative representation of $time
 *
 * Adapted from https://stackoverflow.com/a/7487809
 */
class HelperFunctions
{
  function relativeTime($time)
  {
    $intervals = array(
//    array(1,'a second', 'seconds', true),
      array(60,'a minute', 'minutes', true),
      array(3600,'an hour', 'hours', true),
      array(86400,'a day', 'days', true),
      array(604800,'a week', 'weeks', true),
      array(2592000,'a month', 'months', true),
      array(31104000,'a year', 'years', true)
    );

    $relativeTime = '';

    $secondsLeft = time() - $time;
    for ($i = count($intervals) - 1; $i > -1; $i--) {
      $tmp0 = intval($secondsLeft/$intervals[$i][0]);

      if ($tmp0 != 0) {
        $relativeTime .= (abs($tmp0) > 1 ? (abs($tmp0) . ' ' . $intervals[$i][2]) : $intervals[$i][1]) . ' ';

        if ($intervals[$i][3]) {
          break;
        }
      }

      $secondsLeft -= $tmp0*$intervals[$i][0];
    }

    if ($relativeTime == '') {
      return 'just now';
    }

    return $relativeTime . (time() - $time > 0 ? 'ago' : 'left');
  }
}