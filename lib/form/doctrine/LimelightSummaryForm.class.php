<?php

/**
 * LimelightSummary form.
 *
 * @package    limelight
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LimelightSummaryForm extends BaseLimelightSummaryForm
{
  public function configure()
  {
    $this->useFields(array('summary'));

    $this->setWidgets(array(
      'summary'   => new sfWidgetFormTextarea(array(),
        array(
          'class'     => 'length_counter rnd_5',
          'lengthIndicator' => '#summary_length',
          'maxlength' => 275,
        )),
    ));

    $this->setValidators(array(
      'summary'        => new sfValidatorString(array('trim' => true, 'required' => true, 'min_length' => 10, 'max_length' => 275)),
    ));
  }
}
