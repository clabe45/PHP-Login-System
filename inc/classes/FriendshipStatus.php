<?php

/**
 * enum
 */
abstract class FriendshipStatus {
  const ERROR = -1;
  const NO_FRIENDSHIP = 0;
  const USER_SENT_REQUEST = 1;
  const FRIEND_SENT_REQUEST = 2;
  const FRIENDS = 3;
}

?>
