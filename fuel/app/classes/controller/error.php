<?php

class Controller_Error extends Controller_Base
{

  public function before()
  {
    parent::before();

  }

  public function action_404()
  {
    $this->template->title = 'ステータス:404　不明なページです。';
    $this->template->content = View::forge('error/404');
  }

  public function action_unknownError()
  {
    $this->template->title = 'ステータス:500　不明なエラーが発生しました。';
    $this->template->content = View::forge('error/unknownError');
  }

  public function action_detectionError()
  {
    $this->template->title = 'ステータス:501　エラーが発生しました。';
    $this->template->content = View::forge('error/detectionError');
  }
}
