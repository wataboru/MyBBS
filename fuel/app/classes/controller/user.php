<?php

class Controller_User extends Controller_Base
{
  public function before()
  {
    parent::before();
  }

  // ログイン画面遷移時
  public function action_login()
  {
    $user = null;
    $this->template->title = 'ユーザログイン';

    // ログインボタン押下時
    if ($posts = Input::post()) {
      $val = Validate_User::validate_login();

      if ($val->run()) {
        $auth = Auth::instance();
        if ($auth->login(Input::post('email'), Input::post('password'))) {
          // ログイン成功時
          Response::redirect('thread/index');
        } else {
          // ログイン失敗時
          Session::set_flash('login_error', 'メールアドレスとパスワードの組み合わせが誤っています。', false);
        }
      } else {
        Validate_Util::validateErrorCheck($val, $this->template);
        $user = new Model();
        $user->email = Input::post('email');
        $user->password = Input::post('password');
        $this->template->set_global('user', $user, false);
      }
    }
    // ログイン画面生成
    $this->template->content = View::forge('user/login');
  }

  // ログアウトボタン押下時
  public function action_logout()
  {
    Auth::check() and Auth::logout();
    Response::redirect('thread/index');
  }

  // サインアップ画面遷移時
  public function action_signup()
  {
    // 失敗時のメッセージ
    $error = null;

    // ユーザ登録画面生成
    $this->template->content = View::forge('user/signup');
    $this->template->title = 'ユーザ登録';

    // 登録ボタン押下時
    if ($posts = Input::post()) {
      $val = Validate_User::validate_create();

      if ($val->run()) {
        // ファイルアップロードを実施
        $file = $this->fileUpload();

        $auth = Auth::instance();
        if ($auth->create_user(Input::post('username'), Input::post('password'),Input::post('email'),1,Array( 
          'age'          => Input::post('age'),
          'gender'       => Input::post('gender'),
          'selfprofile'  => Input::post('selfprofile'),
          'iconfilepath' => isset($file) ? $file['saved_as'] : 'default.jpg',
        ))) {
          // ユーザ登録成功時
          Auth::login(Input::post('email'), Input::post('password'));
          Response::redirect('thread/index');
        } else {
          // ユーザ登録失敗時
          Response::redirect('error/unknownError');
        }
      } else {
        Validate_Util::validateErrorCheck($val, $this->template);
        $user = new Model();
        $user->email = Input::post('email');
        $user->password = Input::post('password');
        $this->template->set_global('user', $user, false);
      }
    }
  }

  // ユーザ詳細画面遷移時
  public function action_view($id = null)
  {
    if($id != null) {
      $data['User'] = Model_User::findById($id);
      ! isset($data['User']) and Response::redirect('error/404');
    } elseif(Auth::check()) {
      $data['User'] = Model_User::findById(Auth::get('id'));
    } else {
      Response::redirect('user/login');
    }

    // ユーザ詳細画面生成
    $this->template->title = 'ユーザーページ';
    $this->template->content = View::forge('user/view', $data);
  }

  // ユーザ編集画面遷移時
  public function action_edit()
  {
    if(Auth::check()) {
      $User = Model_User::findById(Auth::get('id'));
    } else {
      Response::redirect('user/login');
    }

    // 許可する遷移元リスト
    $referrerCheckArray = array(
      '/user/view',
      '/user/view/'.$User->id,
      '/user/edit',
    );
    
    // 遷移元のチェック
    Presenter_CommonUtil::isNotReferrerInForgiveLists($referrerCheckArray);

    // ユーザ更新画面生成
    $this->template->content = View::forge('user/edit');
    $this->template->title = 'ユーザ更新';
    $this->template->set_global('User', $User, false);

    // 更新ボタン押下時
    if (Input::post()) {

      $val = Validate_User::validate_update();

      if ($val->run()) {
        // ファイルアップロードを実施
        $file = $this->fileUpload($User); 

        // 認証処理
        $auth = Auth::instance();
        if ($auth->update_user(Array(
          'email'        => Input::post('email'),
          'password'     => Input::post('password'),
           'old_password' => Input::post('old_password'),
          'age'          => Input::post('age'),
           'gender'       => Input::post('gender'),
          'selfprofile'  => Input::post('selfprofile'),
          'iconfilepath' => isset($file) ? $file['saved_as'] : Arr::get($User->profile_fields, 'iconfilepath'),
        )
        , $User->username
        )) {
          // ユーザ情報更新成功時
          Response::redirect('user/view');
        } else {
          // ユーザ登録失敗時
          Response::redirect('error/unknownError');
        }
      } else {
        Validate_Util::validateErrorCheck($val, $this->template);
        $User->email = Input::post('email');
        $User->age = Input::post('age');
        $User->gender = Input::post('gender');
        $User->selfprofile = Input::post('selfprofile');
      }
    }
  }

  // ユーザ削除ボタン押下時
  public function action_delete()
  {
    $createduserid = Auth::get('id');

    // 許可する遷移元リスト
    $referrerCheckArray = array(
      '/user/view',
      '/user/view/'.$createduserid,
    );

    // 遷移元のチェック
    Presenter_CommonUtil::isNotReferrerInForgiveLists($referrerCheckArray);

    $db = Database_Connection::instance();

    try {
      // トランザクション開始
      $db->start_transaction();

      // 各ユーザに紐づくデータを削除
      Model_Thread::logicalDeleteByUser($createduserid);
      Model_Response::logicalDeleteByUser($createduserid);

      // トランザクション完了
      $db->commit_transaction();

      // ユーザを削除
      Auth::check() and Auth::delete_user(Auth::get_screen_name());

    } catch(Exception $e) {
      // ロールバック
      DB::rollback_transaction();
      Response::redirect('error/unknownError');
    }
    Response::redirect('thread/index');
  }

  private function fileUpload($User = null) {

    $file = null;

    // アイコンupload用の設定を追記
    $config = array(
      'randomize' => true,
      'prefix'    => isset($User) ? $User->username.'_' : Input::post('username').'_'
    );

    // $_FILES 内のアップロードされたファイルを処理する
    Upload::process($config);

    // 有効なファイルがある場合
    if (Upload::is_valid())
    {

      // 設定にしたがって保存する
      Upload::save();

      // ファイル情報を取得
      $file = Upload::get_files(0);

      // Uploadエラー処理
      foreach (Upload::get_errors() as $file)
      {
        $errors = $file['errors'];
        $this->template->content->set('error', var_dump($file));
        Response::redirect('error/unknownError');
      }
    }
    return $file;
  }

}
