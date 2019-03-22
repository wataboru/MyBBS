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
  <?php echo Html::anchor('thread/view/'.$Response->threadid, 'Back'); ?>
</div>

<hr style='border-top: 3px double #8c8b8b; margin-top: 5px;'>

<strong>コメントの編集</strong>
<div id='addResponseForm'>
  <?php echo Form::open(array("class"=>"form-horizontal")); ?>
    <fieldset>
      <div class="form-group">
        <?php echo Form::label('コメント', 'body', array('class'=>'control-label')); ?>
        <?php echo Form::textarea('body', $Response->body, array('class' => 'col-md-4 form-control', 'rows' => 4)); ?>
        <?php echo Form::hidden('threadId', $Thread->id)?>
      </div>
        <p style='font-weight: bold; color: red;'>
          <?php echo isset($error['bodyError']) ? $error['bodyError'] : ''; ?>
        </p>
      <div class="form-group">
        <label class='control-label'>&nbsp;</label>
        <?php echo Form::submit('submit', '更新', array('class' => 'btn btn-primary')); ?>
        <label class='control-label'>&nbsp;</label>
        <?php echo Form::reset('reset', 'リセット', array('class' => 'btn btn-primary')); ?>
      </div>
    </fieldset>
  <?php echo Form::close(); ?>
</div>


