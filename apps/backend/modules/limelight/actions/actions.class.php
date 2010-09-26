<?php

require_once dirname(__FILE__).'/../lib/limelightGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/limelightGeneratorHelper.class.php';

/**
 * limelight actions.
 *
 * @package    limelight
 * @subpackage limelight
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class limelightActions extends autoLimelightActions
{
  public function executeUpdate(sfWebRequest $request)
  {
    $this->limelight = $this->getRoute()->getObject();
    $this->form = new BackendLimelightForm($this->limelight);

    $this->form->bind(
      $request->getParameter($this->form->getName()),
      $request->getFiles($this->form->getName())
    );

    if ($this->form->isValid())
    {
      $files = $request->getFiles();
      $old_image = $this->limelight->profile_image;
      $this->limelight = $this->form->save();
      if ($files['limelight']['profile_image']['name'] != '')
      {
        $tmp_img = $files['limelight']['profile_image']['tmp_name'];
        $this->limelight->saveProfileImage($tmp_img);
      }
      else
      {
        $this->limelight->profile_image = $old_image;
        $this->limelight->save();
      }

      $this->getUser()->setFlash('notice', $this->limelight->name.' limelight updated!');
      $this->redirect('limelight', $this->limelight);
    }

    $this->setTemplate('edit');
  }
}
