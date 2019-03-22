<?php
use Orm\Model;

class Model_Thread extends Model
{

  protected static $user = null;

  protected static $_properties = array(
    'id',
    'subject',
    'body',
    'createduserid',
    'deleteflag',
    'created_at',
    'updated_at',
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

  public static function findWithDate($thread)
  {
    $update_at_fmt = date("Y/m/d H:i:s", $thread->updated_at);
    $thread->updated_at = $update_at_fmt;
  }

  public static function logicalDeleteByUser($createduserid)
  {
    $threadQuery = DB::update('Threads')
      ->value('deleteflag', 1)
      ->where('createduserid','=', $createduserid)
      ->execute();    
  }

  public static function logicalDeleteById($threadid)
  {
    $threadQuery = DB::update('Threads')
      ->value('deleteflag', 1)
      ->where('id','=', $threadid)
      ->execute();
  }

  public static function findWithUser($id) {
    if ($thread = parent::find($id)) {
      $thread->user = Model_User::findById($thread->createduserid);
    } else {
      return false;
    }
    return $thread;
  }


}
