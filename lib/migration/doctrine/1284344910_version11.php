<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version11 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropForeignKey('limelight', 'limelight_manufacturer_id_limelight_id');
        
        $this->createTable('limelight_slice', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'name' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '255',
             ),
             'profile_image' => 
             array(
              'type' => 'string',
              'default' => 'limelight_profile_default.gif',
              'length' => '255',
             ),
             'slice_type' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'model',
              1 => 'version',
              ),
              'default' => 'product',
              'length' => '',
             ),
             'user_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'item_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'deleted_at' => 
             array(
              'default' => '',
              'notnull' => '',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'name_slug' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             ), array(
             'indexes' => 
             array(
              'limelight_slice_sluggable' => 
              array(
              'fields' => 
              array(
               0 => 'name_slug',
              ),
              'type' => 'unique',
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             ));
        $this->removeColumn('limelight', 'manufacturer_name');
        $this->removeColumn('limelight', 'manufacturer_id');
        $this->addColumn('comment', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('item', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('limelight', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('limelight', 'company_name', 'string', '255', array(
             ));
        $this->addColumn('limelight', 'company_id', 'integer', '4', array(
             ));
        $this->addColumn('limelight_pro_con', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('limelight_review_pro', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('limelight_review_user', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('limelight_specification', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('limelight_summary', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('news', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('news_link', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('news_tag', 'slice_id', 'integer', '4', array(
             ));
        $this->addColumn('wiki', 'slice_id', 'integer', '4', array(
             ));
    }

    public function down()
    {
       $this->createForeignKey('limelight', 'limelight_manufacturer_id_limelight_id', array(
             'name' => 'limelight_manufacturer_id_limelight_id',
             'local' => 'manufacturer_id',
             'foreign' => 'id',
             'foreignTable' => 'limelight',
             ));

        $this->dropTable('limelight_slice');
        $this->addColumn('limelight', 'manufacturer_name', 'string', '255', array(
             ));
        $this->addColumn('limelight', 'manufacturer_id', 'integer', '4', array(
             ));
        $this->removeColumn('comment', 'slice_id');
        $this->removeColumn('item', 'slice_id');
        $this->removeColumn('limelight', 'slice_id');
        $this->removeColumn('limelight', 'company_name');
        $this->removeColumn('limelight', 'company_id');
        $this->removeColumn('limelight_pro_con', 'slice_id');
        $this->removeColumn('limelight_review_pro', 'slice_id');
        $this->removeColumn('limelight_review_user', 'slice_id');
        $this->removeColumn('limelight_specification', 'slice_id');
        $this->removeColumn('limelight_summary', 'slice_id');
        $this->removeColumn('news', 'slice_id');
        $this->removeColumn('news_link', 'slice_id');
        $this->removeColumn('news_tag', 'slice_id');
        $this->removeColumn('wiki', 'slice_id');
    }
}