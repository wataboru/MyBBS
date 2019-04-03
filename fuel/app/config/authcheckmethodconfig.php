<?php

/*
  authcheckmethodconfig.php

  概要:
    コントローラ内のどのアクションに対し
    ログインチェックを行うか設定する。

  記載例:
    'auth' => array(
      'controller_name' => array(
        'action_name1',
        'action_name2',
        'action_name3',
        'action_name4',
      ),
    ...

*/
return array(
  'auth' => array(
    'thread' => array(
      'create',
      'edit',
      'delete',
    ),
    'response' => array(
      'create',
      'edit',
      'delete',
    ),
    'user' => array(
      'edit',
      'delete',
    ),
    'error' => array(
    ),
  ),
);
