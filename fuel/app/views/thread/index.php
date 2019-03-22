<?php if ($Threads): ?>
<table class="table table-striped">
  <thead>
    <tr>
      <th>スレッド名</th>
      <th>&nbsp;</th>
      <th>コメント数</th>
      <th>編集　/　削除</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Threads as $thread): ?>
      <tr>
        <td><?php echo Html::anchor('thread/view/'.$thread->id, $thread->subject);?><td>
        <td>
        <?php if ($Responses): ?>
          <?php foreach ($Responses as $response): ?>
            <?php $thread->id == $response->threadid ? $responseCounter++ : '' ; ?> 
          <?php endforeach ?>
          <?php echo $responseCounter; ?> 
        <?php else: ?>
          <?php echo $responseCounter; ?>
        <?php endif ?>
        </td>
        <td> 
          <?php if($thread->createduserid == Auth::get('id')): ?>
            <div class="btn-toolbar">
              <div class="btn-group">
                <?php echo Html::anchor('thread/edit/'.$thread->id, '<i class="icon-wrench"></i> 編集', array('class' => 'btn btn-default btn-sm')); ?>
                <?php echo Html::anchor('thread/delete/'.$thread->id, '<i class="icon-trash icon-white"></i> 削除', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('削除してよろしいですか?')")); ?>
              </div>
            </div>
          <?php endif; ?>
        </td>
      </tr>
    <?php $responseCounter = 0; ?>
    <?php endforeach; ?>
  </tbody>
</table>

<?php else: ?>
  <p>スレッドがありません。</p>
<?php endif; ?>
<?php if(Auth::check()): ?>
  <p>
    <?php echo Html::anchor('thread/create', '新規スレッド作成', array('class' => 'btn btn-success')); ?>
  </p>
<?php endif; ?>
