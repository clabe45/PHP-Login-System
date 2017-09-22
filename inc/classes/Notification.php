<?php
if (!defined('__CONFIG__'))
  exit($authentication_err_msg);

class Notification {

  private $con;

  public $notification_id;
  public $sender_id;
  public $recipient_id;
  public $action_command;
  public $additional_data;
  public $url;
  public $clicked;
  public $create_time;

  public $sender; // User object
  public $recipient;  // User object
  public $message;  // string formed from given data

  private function __construct($sender, $recipient, $notification_id, $action_command, $additional_data, $clicked, $create_time, $url) {
    $this->con = DB::get_connection();
    $this->sender = $sender;
    $this->recipient = $recipient;

    $this->notification_id = $notification_id;
    $this->action_command = $action_command;
    $this->clicked = $clicked;
    $this->create_time = strtotime($create_time);
    $this->url = $url ? $url : $this->get_url();

    $this->message = $this->get_message();
  }

  /**
   * Creates a url from the instance data
   */
  private function get_url() {
    $parts = explode(".", strtoupper($this->action_command));
    $command = $parts[0];
    $sub_command = $parts[1];
    switch($command) {
      case "FRIEND": {
        return "profile.php?user_id=" . $this->sender->user_id;  // sender, in this case, is the one sending the NOTIFICATION, not the request
      }
    }
  }

  /**
   * Createas a message from the instance data
   */
  private function get_message() {
    $parts = explode(".", strtoupper($this->action_command));
    $command = $parts[0];
    $sub_command = $parts[1];
    switch($command) {
      case "FRIEND": {
        switch($sub_command) {
          case "REQUEST": {
            return $this->sender->username . " sent you a friend request";
          }
          case "ACCEPT": {
            return $this->sender->username . " accepted your friend request";
          }
        }
        break;
      }
    }
  }

  /**
   * Updates this notification's row in the database, setting |clicked| to |1| (true),
   * and sets |$this->clicked| to |true|.
   */
  public function click() {
    $update_notif = $this->con->prepare("UPDATE notifications SET clicked = 1 WHERE notification_id = :notification_id");
    $update_notif->bindParam(":notification_id", $this->notification_id);
    $update_notif->execute();
    $this->clicked = true;
  }

  /**
   * Creates a notification (which means insertting it into the database `notifications` table)
   * and returns a new Notification instance representing that row in the table
   * @return Notification
   */
  public static function create($con, $sender, $recipient, $action_command, $additional_data, $url) {
    $insert_notif = $con->prepare(
      "INSERT INTO notifications (recipient_id, sender_id, action_command, additional_data, url)
       VALUES (:recipient_id, :sender_id, :action_command, :additional_data, :url)"
     );
    $insert_notif->bindParam(":sender_id", $sender->user_id, PDO::PARAM_STR);
    $insert_notif->bindParam(":recipient_id", $recipient->user_id, PDO::PARAM_INT);
    $insert_notif->bindParam(":action_command", $action_command, PDO::PARAM_LOB);
    $insert_notif->bindParam(":additional_data", $additional_data, PDO::PARAM_LOB);
    $insert_notif->bindParam(":url", $url, PDO::PARAM_STR);
    $insert_notif->execute();

    // see https://stackoverflow.com/a/7604926/3783155
    $select_notif = $con->query(
      "SELECT notification_id, create_time FROM notifications ORDER BY notification_id DESC LIMIT 1"      // last insert in table
    );
    $notif = $select_notif->fetch(PDO::FETCH_OBJ);
    $notification_id = $notif->notification_id;
    $clicked = false;    // a newly-created notification will always be unread at the instant of creation
    $create_time = $notif->create_time;

    return new self($sender, $recipient, $notification_id, $action_command, $additional_data, $clicked, $create_time, $url);
  }

  /**
   * @param row the return of something like PDO#fetch(PDO::FETCH_OBJ)
   */
  public static function from_row ($row) {
    return new self(
      new User((int) $row->sender_id),
      new User((int) $row->recipient_id),
      (int) $row->notification_id,
      (string) $row->action_command,
      $row->additional_data,      // no se  what type this is
      (bool) $row->clicked,
      $row->create_time,          // no se  what type this is
      (string) $row->url
    );
  }

    /**
     * @param con
     * @param id the notification_id of the existing notification
     */
   public static function from_id ($con, $id) {
     $get_notif = $con->prepare("SELECT * FROM notifications WHERE notification_id = :notification_id LIMIT 1");
     $get_notif->bindParam(":notification_id", $id);
     $get_notif->execute();
     $row = $get_notif->fetch(PDO::FETCH_OBJ);
     if (! $row) return null;
     return new self(
        new User((int) $row->sender_id),
        new User((int) $row->recipient_id),
        (int) $row->notification_id,
        (string) $row->action_command,
        $row->additional_data,
        (bool) $row->clicked,    // 0 => false, 1 => true (as far as I know)
        $row->create_time,
        (string) $row->url
     );
   }
}

?>
