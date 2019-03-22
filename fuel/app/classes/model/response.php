<?php
use Orm\Model;

class Model_Response extends Model
{
  protected static $user = null;

  protected static $_properties = array(
    "id",
    "threadid",
    "body",
    "deleteflag",
    "createuserid",
    "created_at",
    "updated_at",
  );

  protected static $_defaults = array(
    'deleteflag' => 0,
  );

  protected static $_observers = array(
    'Orm\Observer_CreatedAt' => array(
      'events'          => array('before_insert'),
      'mysql_timestamp' => false,
    ),
    'Orm\Observer_UpdatedAt' => array(
      'events'          => array('before_save'),
      'mysql_timestamp' => false,
    ),
  );

  public static function findWithDate($responses)
  {
    foreach ($responses as $response) {
      $update_at_fmt = date("Y/m/d H:i:s", $response->updated_at);
      $response->updated_at = $update_at_fmt;
    }
  }

  public static function logicalDeleteByUser($createuserid)
  {
    $responseQuery = DB::update('Responses')
      ->value('deleteflag', 1)
      ->where('createuserid', '=', $createuserid)
      ->execute();
  }

  public static function logicalDeleteByThread($threadid)
  {
    $responseQuery = DB::update('Responses')
      ->value('deleteflag', 1)
      ->where('threadid', '=', $threadid)
      ->execute();
  }

  public static function findByWithUser($column, $value) {
    $responses = Model_Response::find_by($column, $value);
    
    foreach ($responses as $response) {
      $response->user = Model_User::findById($response->createuserid);
    }
    return $responses;
  }

}
