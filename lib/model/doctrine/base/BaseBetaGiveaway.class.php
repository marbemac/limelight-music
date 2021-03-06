<?php

/**
 * BaseBetaGiveaway
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $guess
 * @property integer $group_code
 * @property integer $beta_email_id
 * @property BetaEmail $BetaEmail
 * 
 * @method string       getGuess()         Returns the current record's "guess" value
 * @method integer      getGroupCode()     Returns the current record's "group_code" value
 * @method integer      getBetaEmailId()   Returns the current record's "beta_email_id" value
 * @method BetaEmail    getBetaEmail()     Returns the current record's "BetaEmail" value
 * @method BetaGiveaway setGuess()         Sets the current record's "guess" value
 * @method BetaGiveaway setGroupCode()     Sets the current record's "group_code" value
 * @method BetaGiveaway setBetaEmailId()   Sets the current record's "beta_email_id" value
 * @method BetaGiveaway setBetaEmail()     Sets the current record's "BetaEmail" value
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBetaGiveaway extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('beta_giveaway');
        $this->hasColumn('guess', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('group_code', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('beta_email_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('BetaEmail', array(
             'local' => 'beta_email_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}