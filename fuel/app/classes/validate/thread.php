<?php 

class validate_Thread {

  public static function validate(){
    $val = Validation::forge();
    $val->add_field('subject', 'タイトル', 'required')
        ->add_rule('max_length', 255);
    $val->add_field('body', '本文', 'required')
        ->add_rule('max_length', 255);
    return $val;
  }

}
