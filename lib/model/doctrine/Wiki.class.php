<?php

/**
 * Wiki
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    limelight
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Wiki extends BaseWiki
{
  public function save(Doctrine_Connection $conn = null)
  {
    $conn = $conn ? $conn : $this->getTable()->getConnection();
    $conn->beginTransaction();
    try
    {
      $ret = parent::save($conn);

      $this->updateLuceneIndex();

      $conn->commit();

      return $ret;
    }
    catch (Exception $e)
    {
      $conn->rollBack();
      throw $e;
    }
  }

  public function delete(Doctrine_Connection $conn = null)
  {
    $index = $this->getTable()->getLuceneIndex();

    foreach ($index->find('pk:'.$this->getGroupId()) as $hit)
    {
      $index->delete($hit->id);
    }

    return parent::delete($conn);
  }

  public function updateLuceneIndex()
  {
    $index = $this->getTable()->getLuceneIndex();

    // remove existing entries
    $hits = $index->find('pk:'.$this->getGroupId());
    foreach ($hits as $hit)
    {
      $index->delete($hit->id);
    }

    //sfContext::getInstance()->getLogger()->info('************************* lucene - status - '.$this->getStatus());

    // don't index expired and non-activated wikis, or wikis that are not currently active
    if ($this->getStatus() != 'Active' || $this->getIsActive() != '1')
    {
      return;
    }

    $doc = new Zend_Search_Lucene_Document();

    // store wiki primary key to identify it in the search results
    $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->getGroupId()));

    // index wiki fields
    $doc->addField(Zend_Search_Lucene_Field::UnStored('topics', $this->getTopics(), 'utf-8'));
    $doc->addField(Zend_Search_Lucene_Field::UnStored('content', $this->getContent(), 'utf-8'));

    // add wiki to the index
    $index->addDocument($doc);
    $index->commit();
  }
}