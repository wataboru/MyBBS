<p>
  <strong>スレッドタイトル</strong>
  <pre><?php echo $Thread->subject; ?></pre>
</p>
<p>
  <strong>本文</strong>
  <pre><?php echo $Thread->body; ?></pre>
</p>
<p>
  <strong>作成ユーザ：</strong>
  <?php echo Html::anchor('user/view/'.$Thread->createduserid, Model_User::find($Thread->createduserid)->username); ?>
</p>


<div style='margin-top: 20px;'>
  <?php if($Thread->createduserid == Auth::get('id')): ?>
    <?php echo Html::anchor('thread/edit/'.$Thread->id, 'Edit'); ?> |
  <?php endif; ?>
  <?php echo Html::anchor('thread/index', 'Back'); ?>
</div>

<hr style='border-top: 3px double #8c8b8b; margin-top: 5px;'>

<strong>このスレッドに対するコメント...</strong>
<?php if ($Responses): ?>
  <table class="table table-striped">
  <thead>
    <tr>
      <th>コメント</th>
      <th>更新 / 削除</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Responses as $response): ?>
       <tr>
         <td style='padding-bottom: 3px;'>
           <pre style='margin-bottom: 0px;'><?php echo $response->body; ?></pre>
           <strong>ユーザ：</strong>
           <?php echo Html::anchor('user/view/'.$response->createuserid, Model_User::find($response->createuserid)->username); ?>
         </td>
        <td>
          <?php if($Thread->createduserid == Auth::get('id')): ?>
            <div class="btn-toolbar">
              <div class="btn-group">
                <?php echo Html::anchor('response/edit/'.$response->id, '<i class="icon-wrench"></i> 編集', array('class' => 'btn btn-default btn-sm')); ?>
                <?php echo Html::anchor('response/delete/'.$response->id, '<i class="icon-trash icon-white"></i> 削除', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>
              </div>
            </div>
          <?php endif; ?>
        </td>
       </tr>
    <?php endforeach ?>
  </tbody>
</table>
<?php else: ?>
  <p>コメントはまだありません。</p>
<?php endif ?>

<?php if(Auth::check()): ?>
  <p>
    <?php echo Html::anchor('response/create/'.$Thread->id, 'コメントを追加', array('class' => 'btn btn-success')); ?>
  </p>
<?php endif; ?>


