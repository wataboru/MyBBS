
<p>
  <strong>スレッドタイトル <?php echo $Thread->updated_at ?></strong>
  <pre><?php echo $Thread->subject; ?></pre>
</p>
<table>
  <tr>
    <td>
      <p style='text-align: center;'>
        <?php echo Html::anchor('user/view/'.$Thread->createduserid, Asset::img('userIcon/'.Arr::get($Thread->user->profile_fields, 'iconfilepath'), array('style' => 'width: 50px; height: 50;'))); ?>
      </p>
      <p style='text-align: center;'>
        <?php echo Html::anchor('user/view/'.$Thread->createduserid, $Thread->user->username); ?>
      </p>
    </td>
    <td>
      <p>
        <pre><?php echo $Thread->body; ?></pre>
      </p>
    </td>
  </tr>
</table>

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
      <th> </th>
      <th>更新 / 削除</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($Responses as $response): ?>
       <tr>
         <?php if( $response->deleteflag == 0 ): ?>
           <td style='width: 80px; text-align: center;'>
             <?php echo Html::anchor('user/view/'.$response->createuserid, Asset::img('userIcon/'.Arr::get($response->user->profile_fields, 'iconfilepath'), array('style' => 'width: 50px; height: 50;'))); ?>
           </td>
           <td style='padding-bottom: 3px;'>
             <p style='margin-bottom: 0px;'><?php echo Html::anchor('user/view/'.$response->createuserid, $response->user->username); ?> ...  <?php echo $response->updated_at ?></p>
             <pre style='margin-bottom: 0px;'><?php echo $response->body; ?></pre>
           </td>
           <td style='vertical-align: middle;'>
             <?php if($response->createuserid == Auth::get('id')): ?>
               <div class="btn-toolbar">
                 <div class="btn-group">
                   <?php echo Html::anchor('response/edit/'.$response->id, '<i class="icon-wrench"></i> 編集', array('class' => 'btn btn-default btn-sm')); ?>
                   <?php echo Html::anchor('response/delete/'.$response->id, '<i class="icon-trash icon-white"></i> 削除', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('削除してよろしいですか?')")); ?>
                 </div>
               </div>
             <?php endif; ?>
           </td>
         <?php else: ?>
           <td style='width: 80px; text-align: center;'>
             <?php echo Asset::img('userIcon/default.jpg', array('style' => 'width: 50px; height: 50;')); ?>
           </td>
           <td style='padding-bottom: 3px;'>
             <pre style='margin-bottom: 0px;'>コメントは削除されました...</pre>
           </td>
           <td>
           </td>
         <?php endif; ?>
       </tr>
    <?php endforeach ?>
  </tbody>
</table>
<?php else: ?>
  <p>コメントはまだありません。</p>
<?php endif ?>

<?php if(Auth::check()): ?>
  <div id='addResponseForm'>
    <?php echo Form::open(array("class"=>"form-horizontal")); ?>
      <fieldset>
        <div class="form-group">
          <?php echo Form::label('コメントの追加', 'body', array('class'=>'control-label')); ?>
          <?php echo Form::textarea('body', isset($Response)? $Response->body : '', array('class' => 'col-md-4 form-control', 'rows' => 4)); ?>
          <?php echo Form::hidden('threadId', $Thread->id)?>
        </div>
        <p style='font-weight: bold; color: red;'>
          <?php echo isset($error['bodyError']) ? $error['bodyError'] : ''; ?>
        </p>
        <div class="form-group">
          <label class='control-label'>&nbsp;</label>
          <?php echo Form::submit('submit', '追加', array('class' => 'btn btn-primary')); ?>
          <label class='control-label'>&nbsp;</label>
          <?php echo Form::reset('reset', 'リセット', array('class' => 'btn btn-primary')); ?>
        </div>
      </fieldset>
     <?php echo Form::close(); ?>
  </div>
<?php endif; ?>

<hr style='border-top: 3px double #8c8b8b; margin-bottom: 5px;'>
<div style='margin-bottom: 20px;'>
  <?php echo Html::anchor('thread/index', 'Back'); ?>
</div>



