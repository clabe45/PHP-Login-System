<?php

// private (used in above function)
function friend_request_accepted($friendship) {
  return $friendship['accept_time'] != null;
}

// returns a string as "3 years 5 months ago" or "20 seconds ago", from the given time stirng
// from http://www.mdj.us/web-development/php-programming/another-variation-on-the-time-ago-php-function-use-mysqls-datetime-field-type/
function time_ago($date, $granularity=2) {
  $date = strtotime($date);
  $diff = time() - $date; // time delta from now
  $periods = array(         // each time unit in seconds
    'decade' => 315360000,
    'year' => 31536000,
    'week' => 604800,
    'day' => 86400,
    'hour' => 3600,
    'minute' => 60,
    'second' => 1
  );
  if ($diff < 5) {
    $retval = "just now";
    return "just now";
  }
  $retval = "";
  foreach($periods as $key => $value) {
    if ($diff >= $value) {
      $time = floor($diff / $value);
      $diff %= $value;
      $retval .= ($retval ? ' ':'') . $time . ' ';
      $retval .= ($time > 1) ? $key.'s' : $key;     // plural/singular
      $granularity--;
    }
    if ($granularity == 0) break;
  }
  $retval .= ' ago';
  return $retval;
}

?>
