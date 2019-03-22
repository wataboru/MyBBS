<?php 

class validate_Response {

  public static function validate(){
    $val = Validation::forge();
    $val->add_field('body', 'コメント', 'required')
        ->add_rule('max_length', 255);
    return $val;
  }

}
