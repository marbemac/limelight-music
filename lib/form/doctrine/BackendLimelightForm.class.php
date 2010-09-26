<?php

class BackendLimelightForm extends LimelightForm
{
  public function configure()
  {
    $this->widgetSchema['profile_image'] = new sfWidgetFormInputFileEditable(array(
      'label'     => 'Limelight Profile Image',
      'file_src'  => sfConfig::get('app_limelight_image_path') . '/small/'.$this->getObject()->profile_image,
      'is_image'  => true,
      'edit_mode' => !$this->isNew(),
      'template'  => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
    ));
  }
}

?>
