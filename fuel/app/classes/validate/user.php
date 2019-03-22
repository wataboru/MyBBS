<?php

class Validate_User
{
  public static function _validation_uniqueName($username)
  {
    Validation::active()->set_message('uniqueName', 'この :label は既に使われています。');
    $result = DB::select('id')
                ->from('users')
                ->where('username', $username)
                ->execute();
    return ! ($result->count() > 0);
  }

  public static function _validation_uniqueEmail($email)
  {
    if (Auth::get_email() == $email) {
      return true;
    }
    Validation::active()->set_message('uniqueEmail', 'この :label は既に使われています。');
    $result = DB::select('email')
                ->from('users')
                ->where('email', $email)
                ->execute();
    return ! ($result->count() > 0);
  }

  public static function _validation_isMatchPassword($password)
  {
    Validation::active()->set_message('isMatchPassword', ':label が誤っています。');
    $username = Auth::get_screen_name();
    return Auth::validate_user($username, $password);
  }

  public static function _validation_isImageFile()
  {
    Validation::active()->set_message('isImageFile', ':label の形式は[jpg,jpeg,png,gif]のいずれかにしてください。');
    // 許可するファイルタイプを指定
    $mimetypes = array(
      'image/jpg',
      'image/jpeg',
      'image/png',
      'image/gif',
    );

    // $_FILES 内のアップロードされたファイルを処理する
    Upload::process();

    // ファイルが存在する場合
    if (Upload::is_valid()) {
      // ファイルタイプが一致するかチェック
      foreach ($mimetypes as $mimetype) {
        if ($mimetype == Upload::get_files(0)['mimetype']) {
          return true;
        }
      }
      // ファイルタイプが一致しない場合
      return false;
    } else {
      // ファイルが存在しない場合
      return true;
    }
  }

  public static function validate_create() {
    $val = Validation::forge();
    $val->add_callable('Validate_User');
    $val->add_field('username', '名前', 'required')
        ->add_rule('min_length', 4)
        ->add_rule('max_length', 50)
        ->add_rule('uniqueName', $val->input('username', ''));
    $val->add_field('password', 'パスワード', 'required')
        ->add_rule('min_length', 8)
        ->add_rule('max_length', 50);
    $val->add_field('passwordRequire', 'パスワードの確認', 'required')
        ->add_rule('match_value', $val->input('password', ''), true);
    $val->add_field('email', 'メールアドレス', 'required')
        ->add_rule('valid_email')
        ->add_rule('max_length', 255)
        ->add_rule('uniqueEmail', $val->input('email', ''));
    $val->add_field('gender', '性別', 'required')
        ->add_rule('numeric_between', 0, 2);
    $val->add_field('age', '年齢', 'required')
        ->add_rule('numeric_between', 0, 99);
    $val->add_field('selfprofile', '自己紹介文', 'required')
        ->add_rule('max_length', 500);
    $val->add('iconfile', 'アイコンファイル')
        ->add_rule('isImageFile');
    return $val;
  }

  public static function validate_update() {
    $val = Validation::forge();
    $val->add_callable('Validate_User');
    $val->add_field('old_password', '現在のパスワード', 'required')
        ->add_rule('min_length', 8)
        ->add_rule('max_length', 50)
        ->add_rule('isMatchPassword', $val->input('old_password', ''));
    $val->add_field('password', 'パスワード', 'required')
        ->add_rule('min_length', 8)
        ->add_rule('max_length', 50);
    $val->add_field('passwordRequire', 'パスワードの確認', 'required')
        ->add_rule('match_value', $val->input('password', ''), true);
    $val->add_field('email', 'メールアドレス', 'required')
        ->add_rule('valid_email')
        ->add_rule('max_length', 255)
        ->add_rule('uniqueEmail', $val->input('email', ''));
    $val->add_field('gender', '性別', 'required')
        ->add_rule('numeric_between', 0, 2);
    $val->add_field('age', '年齢', 'required')
        ->add_rule('numeric_between', 0, 99);
    $val->add_field('selfprofile', '自己紹介文', 'required')
        ->add_rule('max_length', 500);
    $val->add('iconfile', 'アイコンファイル')
        ->add_rule('isImageFile');
    return $val;
  }

  public static function validate_login() {
    $val = Validation::forge();
    $val->add_field('email', 'メールアドレス', 'required')
        ->add_rule('valid_email')
        ->add_rule('max_length', 255);
    $val->add_field('password', 'パスワード', 'required')
        ->add_rule('min_length', 8)
        ->add_rule('max_length', 50);
    return $val;
  }

}

