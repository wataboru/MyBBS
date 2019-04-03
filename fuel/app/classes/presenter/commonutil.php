<?php

class Presenter_CommonUtil
{

  public static function getReferrerUriSplit() {
  
    $referrerUri = '';
    $counter = 0;
    $referrer = preg_split('[/]', Input::referrer());

    for ($i=4;$i<count($referrer);$i++) {
    $referrerUri = $referrerUri.'/'.$referrer[$i];
    }
    
    return $referrerUri;
  }

  public static function isNotReferrerInForgiveLists($forgiveList) {

    $referrer = Presenter_CommonUtil::getReferrerUriSplit();

    // 遷移元のチェック
    if(! in_array($referrer, $forgiveList, true) && ! in_array('all', $forgiveList, true)) {
      Session::set_flash('fatalError', '不正な経路でアクセスがありました。');
      Response::redirect('error/detectionError');
    }
  }

  public static function isCreateUser($createUserId)
  {
    // 認証チェック
    if ($createUserId != Auth::get('id'))
    {
      Session::set_flash('fatalError', '対象の権限がありません。');
      Response::redirect('error/detectionError');
    }
  }

}
