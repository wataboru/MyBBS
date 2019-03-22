<?php echo Form::open(array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>
  <fieldset>
    <div class="form-group">
      <?php echo Form::label('メールアドレス', 'email', array('class'=>'control-label')); ?>
        <?php echo Form::input('email', Input::post('email', isset($User) ? $User->email : ''), array('type' => 'email', 'class' => 'col-md-8 form-control')); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['emailError']) ? $error['emailError']: ''; ?>
      </p>
    </div>
    <?php if(isset($User)): ?>
      <div class='form-group'>
        <label class='control-label'>
          <?php echo "名前: ".$User->username ?>
        </label>
      </div>
      <div class='form-group'>
        <?php echo Form::label('現在のパスワード', 'old_password', array('class'=>'control-label')); ?>
          <?php echo Form::password('old_password', '', array('class' => 'col-md-8 form-control')); ?>
        <p style='font-weight: bold; color: red;'>
          <?php echo isset($error['old_passwordError']) ? $error['old_passwordError']: ''; ?>
        </p>
      </div>
    <?php else: ?>
      <div class='form-group'>
        <?php echo Form::label('名前', 'username', array('class'=>'control-label')); ?>
          <?php echo Form::input('username', Input::post('username', isset($User) ? $User->username : ''), array('type' => 'text', 'class' => 'col-md-8 form-control')); ?>
        <p style='font-weight: bold; color: red;'>
          <?php echo isset($error['usernameError']) ? $error['usernameError']: ''; ?>
        </p>
      </div>
    <?php endif; ?>
    <div class='form-group'>
      <?php echo Form::label('パスワード', 'password', array('class'=>'control-label')); ?>
        <?php echo Form::password('password', '', array('class' => 'col-md-8 form-control',)); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['passwordError']) ? $error['passwordError']: ''; ?>
      </p>
    </div>
    <div class='form-group'>
      <?php echo Form::label('パスワードの確認', 'passwordRequire', array('class'=>'control-label')); ?>
        <?php echo Form::password('passwordRequire', '', array('class' => 'col-md-8 form-control',)); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['passwordRequireError']) ? $error['passwordRequireError']: ''; ?>
      </p>
    </div>

    <div class='form-group'>
      <?php echo Form::label('男性', 'gender', array('class'=>'control-label')); ?>
        <?php echo Form::radio('gender', '0', Input::post('gender', isset($User) ? Arr::get($User->profile_fields, 'gender') : '')); ?>
      <?php echo Form::label('女性', 'gender', array('class'=>'control-label')); ?>
        <?php echo Form::radio('gender', '1', Input::post('gender', isset($User) ? Arr::get($User->profile_fields, 'gender') : '')); ?>
      <?php echo Form::label('その他', 'gender', array('class'=>'control-label')); ?>
        <?php echo Form::radio('gender', '2', Input::post('gender', isset($User) ? Arr::get($User->profile_fields, 'gender') : '')); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['genderError']) ? $error['genderError']: ''; ?>
      </p>
    </div>
    <div class='form-group'>
      <?php echo Form::label('年齢', 'age', array('class'=>'control-label')); ?>
        <?php echo Form::select('age', Input::post('age', isset($User) ? Arr::get($User->profile_fields, 'age') : '18'), range(0, 99), array('class' => 'form-control' ,'style' => 'width: 50px;')); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['ageError']) ? $error['ageError']: ''; ?>
      </p>
    </div>
    <div class='form-group'>
      <?php echo Form::label('自己紹介', 'selfprofile', array('class'=>'control-label')); ?>
        <?php echo Form::textarea('selfprofile', Input::post('selfprofile', isset($User) ? Arr::get($User->profile_fields, 'selfprofile') : ''), array('class' => 'col-md-8 form-control', 'rows' => 8)); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['selfprofileError']) ? $error['selfprofileError']: ''; ?>
      </p>
    </div>
    <div class='form-group'>
      <?php echo Form::label('アイコンファイル', 'iconfile', array('class'=>'control-label')); ?>
        <?php echo Form::file('iconfile', array('class' => '', 'accept' => 'image/*')); ?>
      <p style='font-weight: bold; color: red;'>
        <?php echo isset($error['iconfileError']) ? $error['iconfileError']: ''; ?>
      </p>
    </div>
    <div class='form-group'>
      <label class='control-label'>&nbsp;</label>
      <?php echo Form::submit('submit', isset($User) ? '更新' : '登録', array('class' => 'btn btn-primary')); ?>
      <label class='control-label'>&nbsp;</label>
      <?php echo Form::reset('reset', 'リセット', array('class' => 'btn btn-primary')); ?>
    </div>
  </fieldset>
<?php echo Form::close(); ?>
