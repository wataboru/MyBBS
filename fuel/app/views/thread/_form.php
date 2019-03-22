<?php echo Form::open(array("class"=>"form-horizontal")); ?>
  <fieldset>
    <div class="form-group">
      <?php echo Form::label('タイトル', 'subject', array('class'=>'control-label')); ?>
      <?php echo Form::textarea('subject', Input::post('subject', isset($Thread) ? $Thread->subject : ''), array('class' => 'col-md-8 form-control', 'rows' => 2)); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['subjectError']) ? $error['subjectError'] : ''; ?>
      </p>
    </div>
    <div class="form-group">
      <?php echo Form::label('本文', 'body', array('class'=>'control-label')); ?>
      <?php echo Form::textarea('body', Input::post('body', isset($Thread) ? $Thread->body : ''), array('class' => 'col-md-8 form-control', 'rows' => 8)); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['bodyError']) ? $error['bodyError'] : ''; ?>
      </p>
    </div>
    <div class="form-group">
      <label class='control-label'>&nbsp;</label>
      <?php echo Form::submit('submit', '保存', array('class' => 'btn btn-primary')); ?>
    </div>
  </fieldset>
<?php echo Form::close(); ?>
