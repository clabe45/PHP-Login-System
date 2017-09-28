<?php
if (!defined('__CONFIG__'))
  exit('<pre>You don\'t belong here. You will leave this site *force use*.</pre>');

class User {

  private $con;

  public $user_id;
  public $username;
  public $name, $first_name, $last_name;
  public $email;
  public $reg_time;
  public $last_time_viewed_notifications;

  public function __construct($user_id, $me=false) {
    if (!is_int($user_id)) {
      throw new Exception("Non-integer value provided in User::__construct: " . gettype($user_id));
    }

    $this->con = DB::get_connection();

    $user = self::get($user_id);
    if (!$user) {
      throw new Exception("User " . $user_id . " doesn't exist");
      if ($me) Page::log_out();
    } else {

      $this->user_id  = (int) $user->user_id;
      $this->username = (string) $user->username;
      $this->name =  (string) $user->name;
      $name_parts = explode(" ", $user->name);
      $this->first_name = $name_parts[0];
      $this->last_name =  $name_parts[1];
      $this->email = (string) $user->email;
      $this->reg_time = strtotime((string) $user->reg_time);
      $this->last_time_viewed_notifications = strtotime((string) $user->last_time_viewed_notifications);
    }
  }

  /**
   * @return array associative array of all types of notifications, each being another array (representing lists)
   */
  public function get_notifications() {
    $get_notifs = $this->con->prepare("SELECT * FROM notifications WHERE recipient_id = :recipient_id ORDER BY notification_id DESC");
    $get_notifs->bindParam(":recipient_id", $this->user_id, PDO::PARAM_INT);
    $get_notifs->execute();

    $ret = array();
    foreach($get_notifs->fetchAll(PDO::FETCH_OBJ) as $row) {
      // make it an instance of the class (that's the only reason we're doing this)
      array_push($ret, Notification::from_row($row));
    }
    return $ret;
  }

  public function view_all_notifications() {
    $update_user = $this->con->prepare(
      "UPDATE users SET last_time_viewed_notifications = CURRENT_TIMESTAMP WHERE user_id = :user_id LIMIT 1"
    );
    $update_user->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
    $update_user->execute();
  }


  function get_friendship_status($friend_id) {
    $select_request = $this->con->prepare(
      "SELECT accept_time, sender_id FROM friendships
       WHERE (sender_id = :user_id    AND recipient_id = :friend_id)
          OR (sender_id = :friend_id  AND recipient_id = :user_id)"   // this function is "commutable"
    );
    $select_request->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
    $select_request->bindParam(":friend_id", $friend_id, PDO::PARAM_INT);
    $select_request->execute();
    if ($select_request->rowCount() == 0) return FriendshipStatus::NO_FRIENDSHIP; // no data in table
    $friendship = $select_request->fetch();
    if (!$friendship['accept_time']) {
      if ($friendship['sender_id'] == $this->user_id) return FriendshipStatus::USER_SENT_REQUEST;
      if ($friendship['sender_id'] == $friend_id) return FriendshipStatus::FRIEND_SENT_REQUEST;
      return FriendshipStatus::ERROR;
    }
    return FriendshipStatus::FRIENDS; // data in table AND accept_time is truthy (not null) (should work)
  }

  /**
   * Gets the user with the specified user_id
   * @param $force_exists if TRUE, redirects user to logout.php if he/she doesn't exist
   * @return fetched database PDO result in PDO::FETCH_ASSOC style
   */
  private static function get($user_id, $fetch_mode=PDO::FETCH_OBJ) {
    $con = DB::get_connection();

    $get_user = $con->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $get_user->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $get_user->execute();

    return $get_user->rowCount() == 1 ? $get_user->fetch($fetch_mode) : null;
  }
}

?>
