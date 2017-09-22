<?php

$notifs = $current_user->get_notifications();

if (count($notifs) > 0) {
  foreach($notifs as $notif) {
    $second_class = $notif->clicked == 1 ? "read" : "unread";
    echo  "<div class='notification $second_class'>"
           . "<a data-id='$notif->notification_id' data-href='$notif->url' href=''>$notif->message</a>" .
          "</div>";
  }
} else {
  echo "<em>You have no notifications... at all</em>";
}

?>
