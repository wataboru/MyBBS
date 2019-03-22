<h4 style='color: red; font-weight: bold;'><?php echo Session::get_flash('login_error'); ?></h4>

<?php echo Form::open(array("class"=>"form-horizontal")); ?>
  <fieldset>
    <div class="form-group">
      <?php echo Form::label('メールアドレス', 'email', array('class'=>'control-label')); ?>
        <?php echo Form::input('email', isset($user) ? $user->email : '', array('type' => 'email', 'class' => 'col-md-8 form-control')); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['emailError']) ? $error['emailError']: ''; ?>
      </p>
    </div>
    <div class="form-group">
      <?php echo Form::label('パスワード', 'password', array('class'=>'control-label')); ?>
        <?php echo Form::password('password', isset($user) ? $user->password : '', array('class' => 'col-md-8 form-control')); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['passwordError']) ? $error['passwordError']: ''; ?>
      </p>
    </div>
    <div class="form-group">
      <label class='control-label'>&nbsp;</label>
      <?php echo Form::submit('submit', 'ログイン', array('class' => 'btn btn-primary')); ?>
      <label class='control-label'>&nbsp;</label>
      <?php echo Form::submit('reset', 'リセット', array('class' => 'btn btn-primary')); ?>
    </div>
  </fieldset>
<?php echo Form::close(); ?>
