<div id='header' style='margin: 2px; font-size: 20px;'>
  <div class="col-md-8 TOP">
    <?php echo Html::anchor('thread/index', 'TOP'); ?>
  </div>
  <div class="col-md-2 UserName">
    <?php echo "ようこそ。 ".Auth::get_screen_name()."さん"; ?>
  </div>
  <div class="col-md-1 SIGNUP">
    <?php echo Html::anchor('user/view', 'ユーザー情報'); ?>
  </div>
  <div class="col-md-1 LOGIN">
    <?php echo Html::anchor('user/logout', 'ログアウト'); ?>
  </div>
  <hr>
</div>
