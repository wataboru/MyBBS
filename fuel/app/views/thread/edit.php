<?php echo render('thread/_form'); ?>

<br>
<p>
  <?php echo Html::anchor('thread/view/'.$Thread->id, 'View'); ?> |
  <?php echo Html::anchor('thread/index', 'Back'); ?>
</p>
