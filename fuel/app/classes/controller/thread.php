<?php

class Controller_Thread extends Controller_Base
{

  public function before()
  {
    parent::before();
  }

  // 初期表示時
  public function action_index()
  {
    $data['Threads'] = Model_Thread::find_by('deleteflag', 0);
    $data['Responses'] = Model_Response::find_by('deleteflag', 0);
    $data['responseCounter'] = 0;

    // スレッド一覧画面生成
    $this->template->title = "スレッド一覧";
    $this->template->content = View::forge('thread/index', $data);
  }

  // スレッド名リンク押下時
  public function action_view($id = null)
  {
    is_null($id) and Response::redirect('thread');

    if ( ! $data['Thread']  = Model_Thread::findWithUser($id))
    {
      Response::redirect('error/404');
    }

    // updated_atデータを変換し格納
    Model_Thread::findWithDate($data['Thread']);
    $data['Responses'] = Model_Response::findByWithUser('threadid', $id);
    Model_Response::findWithDate($data['Responses']);

    // スレッド詳細画面生成
    $this->template->title = "スレッド詳細";
    $this->template->content = View::forge('thread/view', $data);

    //  レスポンス追加ボタン押下時
    if (Input::method() == 'POST')
    {
      $val = Validate_Response::validate();

      if ($val->run())
      {
        $Response = Model_Response::forge(array(
          'threadid'      => Input::post('threadId'),
          'body'          => Input::post('body'),
          'createuserid'  => Auth::get('id'),
          'deleteflag'    => 0,
        ));

        if ($Response and $Response->save())
        {
          Response::redirect(Input::referrer());
        } else {
          Response::redirect('error/unknownError');
        }
      } else {
        Validate_Util::validateErrorCheck($val, $this->template);
        $Response = new Model();
        $Response->body = Input::post('body');
        $this->template->set_global('Response', $Response, false);
      }
    }

  }

  // 新規スレッド作成ボタン押下時
  public function action_create()
  {
    // スレッド作成画面生成
    $this->template->title = "新規スレッド作成";
    $this->template->content = View::forge('thread/create');
    $Thread = new Model();

    // 許可する遷移元リスト
    $referrerCheckArray = array(
      '/thread/index',
      '/thread/create',
    );

    // 遷移元のチェック
    Presenter_CommonUtil::isNotReferrerInForgiveLists($referrerCheckArray);

    // 作成ボタン押下時
    if (Input::method() == 'POST')
    {
      $val = Validate_Thread::validate();

      if ($val->run())
      {
        $Thread = Model_Thread::forge(array(
          'subject'       => Input::post('subject'),
          'body'          => Input::post('body'),
          'createduserid' => Auth::get('id'),
          'deleteflag'    => 0,
        ));

        if ($Thread and $Thread->save())
        {
          Response::redirect('thread/index');
        } else {
          Response::redirect('error/unknownError');
        }

      } else {
        Validate_Util::validateErrorCheck($val, $this->template);
        $Thread->subject = Input::post('subject');
        $Thread->body = Input::post('body');
        $this->template->set_global('Thread', $Thread, false);
      }
    }
  }

  // 更新ボタン押下時
  public function action_edit($id = null)
  {
    // 引数必須チェック
    is_null($id) and Response::redirect('thread');
    // スレッドの取得/存在チェック
    if ( ! $Thread = Model_Thread::find($id))
    {
      Response::redirect('error/404');
    }

    // 認証チェック
    Presenter_CommonUtil::isCreateUser($Thread->createduserid);

    // 許可する遷移元リスト
    $referrerCheckArray = array(
      '/thread/index',
      '/thread/view/'.$Thread->id,
      '/thread/edit/'.$Thread->id,
    );
    
    // 遷移元のチェック
    Presenter_CommonUtil::isNotReferrerInForgiveLists($referrerCheckArray);

    // スレッド更新画面生成
    $this->template->title = "スレッド更新";
    $this->template->content = View::forge('thread/edit');

    if (Input::method() == 'POST')
    {
      $val = Validate_Thread::validate();

      if ($val->run())
      {
        $Thread->subject = Input::post('subject');
        $Thread->body = Input::post('body');
        $Thread->createduserid = Auth::get('id');

          if ($Thread->save())
          {
            Response::redirect('thread/index');
          } else {
            Response::redirect('error/unknownError');
          }
      } else {
        Validate_Util::validateErrorCheck($val, $this->template);
        $Thread->subject = Input::post('subject');
        $Thread->body = Input::post('body');
      }
    }
    $this->template->set_global('Thread', $Thread, false);
  }


  // 削除ボタン押下時
  public function action_delete($id = null)
  {
    // 引数必須チェック
    is_null($id) and Response::redirect('thread'); 
    // スレッドの取得/存在チェック
    if ( ! $Thread = Model_Thread::find($id))
    { 
      Response::redirect('error/404');
    }

    // 認証チェック
    Presenter_CommonUtil::isCreateUser($Thread->createduserid);

    // 許可する遷移元リスト
    $referrerCheckArray = array(
      '/thread/index',
    );
    
    // 遷移元のチェック
    Presenter_CommonUtil::isNotReferrerInForgiveLists($referrerCheckArray);

    $db = Database_Connection::instance();

    try {
      // トランザクション開始
      $db->start_transaction();

      // スレッドに紐づくレスポンスを削除
      Model_Thread::logicalDeleteById($id);
      Model_Response::logicalDeleteByThread($id);

      // トランザクション完了
      $db->commit_transaction();

    } catch(Exception $e) {
      // ロールバック
      DB::rollback_transaction();
      Response::redirect('error/unknownError');
    }

    Response::redirect('thread/index');
  }

}
