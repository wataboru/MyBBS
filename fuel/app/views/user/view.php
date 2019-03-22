<?php if ($User): ?>
  <ul>
    <li style='list-style: none;'>
      <ul>
        <li><?php echo Asset::img('userIcon/'.Arr::get($User->profile_fields, 'iconfilepath'), array('style' => 'width: 100px; height:100;')); ?></li>
      </ul>
    </li>
    <li>
      <h3>ユーザ名</h3>
      <ul>
        <li><p><?php echo $User->username; ?></p></li>
      </ul>
    </li>
    <li>
      <h3>メールアドレス</h3>
      <ul>
        <li><p><?php echo $User->email; ?></p></li>
      </ul>
    </li>
    <li>
      <h3>性別</h3>
      <ul>
        <li>
          <?php switch (Arr::get($User->profile_fields, 'gender')): 
            case 0: ?>
             <p>男性</p>
            <?php break; ?>
            <?php case 1: ?>
              <p>女性</p>
            <?php break; ?>
            <?php case 2: ?>
              <p>その他</p>
            <?php break; ?>
          <?php endswitch; ?>
        </li>
      </ul>
    </li>
    <li>
      <h3>年齢</h3>
      <ul>
        <li><p><?php echo  Arr::get($User->profile_fields, 'age').'歳'; ?></p></li>
      </ul>
    </li>
    <li>
      <h3>プロフィール</h3>
      <ul>
        <li><pre><?php echo  Arr::get($User->profile_fields, 'selfprofile'); ?></pre></li>
      </ul>
    </li>
    <?php if($User->id == Auth::get('id')): ?>
      <li style='list-style: none;'>
      <br>
        <div class="btn-toolbar">
          <div class="btn-group">
            <?php echo Html::anchor('user/edit', '<i class="icon-wrench"></i> 編集', array('class' => 'btn btn-default btn-sm')); ?>
            <?php echo Html::anchor('user/delete/'.$User->id, '<i class="icon-trash icon-white"></i> 削除', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('削除してよろしいですか?')")); ?>
          </div>
        </div>
      </li>
    <?php endif; ?>
  </ul>

<?php else: ?>
  <p>対象のユーザは存在しません。</p>
<?php endif ?>
