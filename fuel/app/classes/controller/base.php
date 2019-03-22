<?php

class Controller_Base extends Controller_Template
{

  public function before()
  {
    parent::before();

    if(Auth::check()) {
      $this->template->header = View::forge('parts/userHeader');
    } else {
      $this->template->header = View::forge('parts/guestHeader');
    }
    $this->template->footer = View::forge('parts/footer');

    // 未ログインの場合、ログイン画面へ遷移
    $this->redirectIfNeededNotLogin();

  }

  private function redirectIfNeededNotLogin() {

    // 認証対象のメソッド
    $method = Uri::segment(2);
    // ログインチェックコンフィグ呼出
    Config::load('authCheckMethodConfig');
    // ログインチェック対象のメソッド
    $authCheckMethods = Config::get('auth.'.Uri::segment(1));
      
    // 認証対象のメソッドがチェック対象であり、かつログインしているかどうか
    if ((empty($method) || in_array($method, $authCheckMethods)) && !Auth::check())
      {  
         // 未ログイン時はログイン画面へリダイレクト
         Response::redirect('user/login');
      }
  }

  public function after($response)
  {
    $response = parent::after($response);
    return $response;
  }

}
