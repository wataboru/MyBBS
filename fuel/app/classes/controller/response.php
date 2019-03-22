<?php

class Controller_Response extends Controller_Base
{

  public function before()
  {
    parent::before();
  }

  // 削除ボタン押下時
  public function action_delete($responseId = null)
  {
    // 引数の必須チェック
    is_null($responseId) and Response::redirect_back();

    // レスポンスの取得/存在チェック
    if (! $response = Model_Response::find($responseId))
    {
      Response::redirect('error/404');
    }

    // 認証チェック
    Presenter_CommonUtil::isCreateUser($response->createuserid);

    // 許可する遷移元リスト
    $referrerCheckArray = array(
      '/thread/view/'.$response->threadid,
    );

    // 遷移元のチェック
    Presenter_CommonUtil::isNotReferrerInForgiveLists($referrerCheckArray);

    // 認証チェック
    Presenter_CommonUtil::isCreateUser($response->createuserid);

    // 更新値のセット
    $response->set(array('deleteflag' => 1));

    // データ更新
    if ($response->save())
    {
      // 処理なし
    } else {
      Session::set_flash('fatalError', 'コメントの更新に失敗しました。');
      Response::redirect('error/detectionError');
    }
    // スレッド詳細画面へ遷移
    Response::redirect(Input::referrer());
  }

  // 編集ボタン押下時
  public function action_edit($responseId)
  {
    // 引数のレスポンスの存在チェック
    is_null($responseId) and Response::redirect_back();
    // レスポンスの取得/存在チェック
    if (! $data['Response'] = Model_Response::find($responseId))
    {
      Response::redirect('error/404');
    } 

    // スレッドの取得/存在チェック
    if  (! $data['Thread'] = Model_Thread::findWithUser($data['Response']->threadid))
    {
      Response::redirect('error/404');
    }

    // updated_atデータを変換し格納
    Model_Thread::findWithDate($data['Thread']);

    // 認証チェック
    Presenter_CommonUtil::isCreateUser($data['Response']->createuserid);

    // 許可する遷移元リスト
    $referrerCheckArray = array(
      '/thread/view/'.$data['Response']->threadid,
      '/response/edit/'.$data['Response']->id,
    );

    // 遷移元のチェック
    Presenter_CommonUtil::isNotReferrerInForgiveLists($referrerCheckArray);

    // レスポンス編集画面生成
    $this->template->title = 'コメント編集';
    $this->template->content = View::forge('response/edit', $data);

    //  レスポンス更新ボタン押下時
    if (Input::method() == 'POST')
    {
      $val = Validate_Response::validate();

      if ($val->run())
      {
        // データの取得
        $Response = Model_Response::find($responseId);
        $Response->body = Input::post('body');

        // データ更新
        if ($Response and $Response->save())
        {
          Response::redirect('thread/view/'.Input::post('threadId'));
        } else {
          Response::redirect('error/unknownError');
        }
      } else {
        Validate_Util::validateErrorCheck($val, $this->template);
        $data['Response']->body = Input::post('body');
      }
    $this->template->set_global('Response', $data['Response'], false); 
    }
  }

}
