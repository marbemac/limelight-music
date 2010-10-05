<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

/**
 * news actions.
 *
 * @package    news
 * @subpackage news
 * @author     marc
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class songActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated()) {
      $user_id = $user->getGuardUser()->id;
      $this->user = $user->getGuardUser()->id;
    } else {
      $user_id = 0;
      $this->user = 'notlogged';
    }
    $table = Doctrine::getTable('song');
    $this->name_slug = $request->getParameter('name_slug');
    $this->song = $table->getSong($this->name_slug);
    $this->tags = Doctrine::getTable('ItemTag')->getTags($this->song['id'], 'song');
    $this->tagForm = new ItemTagForm();
  }

  public function executeAdd(sfWebRequest $request)
  {
    $this->form = new SongForm();
  }

  // Process a new news submission
  public function executeProcessAdd(sfWebRequest $request)
  {
    $this->form = new SongForm();
    $errors = array();
    $error = false;
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $errors['result'] = 'login';
      $this->renderText(json_encode($errors));
      return sfView::NONE;
    }

    $user = $this->getUser()->getGuardUser();
    if ($request->getParameter('song'))
    {
      $submission = $request->getParameter('song');
      $limelights = $request->getParameter('limelights');

      $errors['limelight_error'] = false;

      // limelight error?
      if (count($limelights) < sfConfig::get('app_song_add_limelights_min') || count($limelights) > sfConfig::get('app_song_add_limelights_max'))
        $errors['limelight_error'] = true;

      $errors['file_error'] = false;

      // file_error?
      if (!$submission['filename'])
        $errors['file_error'] = true;

      $this->form->bind($submission);
      if ($this->form->isValid())
      {
        // check that the link url hasn't been submitted yet
        $song = Doctrine::getTable('Song')->findOneByNameSlug(LimelightUtils::slugify($submission['name']));
        if ($song)
        {
          $errors['result'] = 'error';
          $errors['info_error'][] = array('name' => 'name', 'error' => '<ul class="error_list"><li>A song with this name has already been submitted!</li></ul>');
          $this->renderText(json_encode($errors));
          return sfView::NONE;
        }

        if (!$errors['limelight_error'] && !$errors['file_error'])
        {
          $s = new Song();
          $s->user_id = $user->id;
          $s->name = $submission['name'];
          $s->content = isset($submission['content']) ? $submission['content'] : '';
          $s->filename = $submission['filename'];
          $s->save();

          Doctrine::getTable('Limelight')->songAddLimelights($user->id, $s->id, $limelights);

          $this->getUser()->setFlash('notice', 'Congrats, your song has been successfully submitted!');
          $errors['result'] = 'success';
          $errors['url'] = url_for('song_show', array('name_slug' => $s->name_slug));
          $this->renderText(json_encode($errors));
          return sfView::NONE;
        }
      }

      $errors['result'] = 'error';
      // basic info errors
      foreach ($this->form as $field)
      {
        $errors['info_error'][] = array('name' => $field->getName(), 'error' => $field->renderError());
      }

      $this->renderText(json_encode($errors));
      return sfView::NONE;
    }
  }

  public function executeUploadSong(sfWebRequest $request)
  {
    $return_data = array();

    $file_types = array('mp3', 'mp4', 'mpeg', 'aac', 'wma', 'mpa');

    // check that it's a song
    $file = $_FILES['Filedata']['tmp_name'];
    $ext = pathinfo($_FILES['Filedata']['name']);
    $ext = $ext['extension'];

    if (!in_array($ext, $file_types) || $_FILES['Filedata']['size'] > 10000000)
    {
      $return_data['result'] = 'error';
      $return_data['text'] = 'Unsupported extension ('.$ext.') or file is too big ('.$_FILES['Filedata']['size'].').';
      $this->renderText(json_encode($return_data).'$**$');
      return sfView::NONE;
    }

    require_once (dirname(__FILE__).'/../../../../../config/S3.php');
    $s3 = new S3(sfConfig::get('app_amazon_access_key_id'), sfConfig::get('app_amazon_secret_key_id'), false);

    $fileName = uniqid('SF') . '.' . $ext;

    //create a new bucket
    //$s3->putBucket("music-limelight-songs", S3::ACL_PUBLIC_READ);
    if($s3->putObjectFile($file, sfConfig::get('app_amazon_song_bucket'), $fileName, S3::ACL_PUBLIC_READ))
    {
      $return_data['result'] = 'success';
      $return_data['fileName'] = $fileName;
    }
    else
    {
      $return_data['result'] = 'error';
      $return_data['text'] = 'There was an error uploading the file. Please try again later. If the problem persists, let us know!';
    }

    // TODO: this is a hack to get around uploadifys strange response data
    $this->renderText(json_encode($return_data).'$**$');
    return sfView::NONE;
  }

  public function executeLookup(sfWebRequest $request)
  {
    if (!$query = $request->getParameter('q'))
    {
      $this->renderText('{ "result":"error" }');
      return sfView::NONE;
    }

    $items = Doctrine::getTable('News')->getForNewsLookup($query);

    $this->renderText(json_encode($items));
    return sfView::NONE;
  }

  public function executeAddTag(sfWebRequest $request)
  {
    $form = new NewsTagForm();
    $return_data = array();
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $errors['result'] = 'login';
      $this->renderText(json_encode($errors));
      return sfView::NONE;
    }

    if (!$user->hasPermission('tag_add')) {
      $return_data = array('result' => 'error', 'text' => 'You cannot add tags, you must have a score of at least '.LimelightUtils::getUserActionMinScore('add a tag').'.');
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    $user = $this->getUser()->getGuardUser();

    if ($request->getParameter('newsTag'))
    {
      $submission = $request->getParameter('newsTag');

      $form->bind($submission);
      if ($form->isValid())
      {
        $t = Doctrine::getTable('Tag')->findOneByNameSlug(LimelightUtils::slugify($submission['name']));

        if (!$t && !$user->hasPermission('tag_add_new')) {
          $return_data = array('result' => 'error', 'text' => 'You can only add tags that are already in the system, you must have a score of at least '.LimelightUtils::getUserActionMinScore('add a NEW tag').' to add tags that have never been added to '.sfConfig::get('app_site_name').' before.');
          $this->renderText(json_encode($return_data));
          return sfView::NONE;
        }

        $news_id = $request->getParameter('news_id');

        if ($t)
        {

          $check = Doctrine::getTable('NewsTag')->checkTag($t['id'], $news_id);
          if ($check)
          {
            $return_data = array('result' => 'error', 'text' => 'This tag has previously been added to this news story!');
            $this->renderText(json_encode($return_data));
            return sfView::NONE;
          }
        }
        else
        {
          $t = new Tag();
          $t->name = $submission['name'];
          $t->user_id = $user->id;
          $t->save();
        }
        
        $nt = new NewsTag();
        $nt->user_id = $user->id;
        $nt->tag_id = $t['id'];
        $nt->item_id = $news_id;
        $nt->save();

        $return_data = array('result' => 'success', 'name' => $t['name']);
        $this->renderText(json_encode($return_data));
        return sfView::NONE;
      }

      $return_data['result'] = 'error';
      // basic info errors
      foreach ($form as $field)
      {
        $return_data['info_error'][] = array('name' => $field->getName(), 'error' => $field->renderError());
      }
    }

    $this->renderText(json_encode($return_data));
    return sfView::NONE;
  }

  public function executeGetTagTab(sfWebRequest $request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $user_id = 0;
    else
      $user_id = $user->getGuardUser()->id;

    $tag_id = $request->getParameter('tag_id', null);
    $submitter_id = $request->getParameter('submitter_id', null);

    if ($tag_id && $submitter_id)
      $tag = Doctrine::getTable('NewsTag')->getTag($tag_id, $user_id);
    else
      return sfView::NONE;

    $this->renderPartial('news/tagTab', array('user_id' => $user_id, 'tag' => $tag, 'submitter_id' => $submitter_id, 'score_update_url' => 'news_tag_update_score'));
    return sfView::NONE;
  }
}