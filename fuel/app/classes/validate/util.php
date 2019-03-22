<?php 

class Validate_Util {

  public static function validateErrorCheck($val, $template)
  {
    $validateErrors = array();
    foreach ($val->error() as $error)
    {
      $validateErrors += array($error->field->name.'Error' => $error->get_message());
    }
    $template->set_global('error', $validateErrors, false);
  }

}
