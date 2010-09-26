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
class newsActions extends sfActions
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
    $news_table = Doctrine::getTable('News');
    $this->title_slug = $request->getParameter('title_slug');
    $this->newsItem = $news_table->getNewsItem($this->title_slug);
    $this->links = Doctrine::getTable('NewsLink')->getLinks($this->newsItem['id']);
    $this->tags = Doctrine::getTable('NewsTag')->getTags($this->newsItem['id']);
    $this->linkForm = new NewsLinkForm();
    $this->tagForm = new NewsTagForm();
  }

  public function executeAdd(sfWebRequest $request)
  {
    $this->form = new NewsForm();
  }

  // Process a new news submission
  public function executeProcessAdd(sfWebRequest $request)
  {
    $this->form = new NewsForm();
    $errors = array();
    $error = false;
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $errors['result'] = 'login';
      $this->renderText(json_encode($errors));
      return sfView::NONE;
    }

    $user = $this->getUser()->getGuardUser();
    if ($request->getParameter('news'))
    {
      $submission = $request->getParameter('news');
      $tags = $request->getParameter('tags');
      $limelights = $request->getParameter('limelights');

      $errors['tag_error'] = false;
      $errors['limelight_error'] = false;

      // tag error?
      if (count($tags) < sfConfig::get('app_news_add_tags_min') || count($tags) > sfConfig::get('app_news_add_tags_max'))
        $errors['tag_error'] = true;

      // limelight error?
      if (count($limelights) < sfConfig::get('app_news_add_limelights_min') || count($limelights) > sfConfig::get('app_news_add_limelights_max'))
        $errors['limelight_error'] = true;

      $this->form->bind($submission);
      if ($this->form->isValid())
      {
        // check that the link url hasn't been submitted yet
        $link = Doctrine::getTable('NewsLink')->findOneBySourceUrl($submission['source_url']);
        if ($link)
        {
          $errors['result'] = 'error';
          $errors['info_error'][] = array('name' => 'source_url', 'error' => '<ul class="error_list"><li>A news story with this link URL has already been submitted!</li></ul>');
          $this->renderText(json_encode($errors));
          return sfView::NONE;
        }

        if (!$errors['tag_error'] && !$errors['limelight_error'])
        {
          $n = new News();
          $n->user_id = $user->id;
          $n->title = $submission['title'];
          $n->content = $submission['content'];
          // do we have a news image?
          if (trim($submission['news_image']) != '')
            $n->news_image = $submission['news_image'];
          $n->save();

          $s = Doctrine::getTable('Limelight')->findOneByNameSlug(LimelightUtils::slugify($submission['source_name']));
          if (!$s && !$user->hasPermission('link_add_new')) {
            $this->renderText('{ "result":"error", "text":"You must have a score of at least '.LimelightUtils::getUserActionMinScore('add a NEW link').' to add news stories from a new source." }');
            return sfView::NONE;
          }
          if (!$s) // create a new source if the source has never been added
          {
            $s = new Limelight();
            $s->name = $submission['source_name'];
            $s->limelight_type = 'Source';
            $s->user_id = $user->id;
            $s->save();
          }

          $nl = new NewsLink();
          $nl->source_url = $submission['source_url'];
          $nl->user_id = $user->id;
          $nl->item_id = $n->id;
          $nl->source_id = $s->id;
          $nl->save();

          Doctrine::getTable('Tag')->newsAddTags($user->id, $n->id, $tags);
          Doctrine::getTable('Limelight')->newsAddLimelights($user->id, $n->id, $limelights);

          $this->getUser()->setFlash('notice', 'Congrats, your news story has been successfully submitted!');
          $errors['result'] = 'success';
          $errors['url'] = url_for('news_show', array('title_slug' => $n->title_slug));
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

  public function executeUploadImage(sfWebRequest $request)
  {
    $return_data = array();

    // check that it's an image
    $img = $_FILES['Filedata']['tmp_name'];
    $imgInfo_array = getimagesize($img);
    if ($imgInfo_array && $_FILES['Filedata']['size'] > 2000000)
    {
      $return_data['result'] = 'error';
      $this->renderText(json_encode($return_data).'$**$');
      return sfView::NONE;
    }

    $parts = explode('/', $imgInfo_array['mime']);
    $ext = $parts[count($parts)-1];

    // create the 4 file sizes and save
    $fileName = uniqid('NI') . '.' . $ext;
    $thumbnail_l = new sfThumbnail(700, 700);
    $thumbnail_l->loadFile($_FILES['Filedata']['tmp_name']);
    $thumbnail_l->save(sfConfig::get('sf_upload_dir').'/n_stories/large/'.$fileName);
    $thumbnail_m = new sfThumbnail(250, 250);
    $thumbnail_m->loadFile($_FILES['Filedata']['tmp_name']);
    $thumbnail_m->save(sfConfig::get('sf_upload_dir').'/n_stories/med/'.$fileName);
    $thumbnail_s = new sfThumbnail(150, 120);
    $thumbnail_s->loadFile($_FILES['Filedata']['tmp_name']);
    $thumbnail_s->save(sfConfig::get('sf_upload_dir').'/n_stories/small/'.$fileName);
    $thumbnail_t = new sfThumbnail(75, 75);
    $thumbnail_t->loadFile($_FILES['Filedata']['tmp_name']);
    $thumbnail_t->save(sfConfig::get('sf_upload_dir').'/n_stories/thumb/'.$fileName);

    $return_data['result'] = 'success';
    $return_data['fileName'] = $fileName;
    $return_data['filePath'] = sfConfig::get('app_news_image_path').'/small/'.$fileName;

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

  public function executeLinkAdd($request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    if (!$request->getParameter('item_id')) {
      $this->renderText('{ "result":"error", "text":"There was an error while trying to add the link. Please try again later." }');
      Doctrine::getTable('Log')->newLog('news link', 'No item_id parameter present.', $user->getGuardUser()->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    $item_id = $request->getParameter('item_id');

    if (!$user->hasPermission('link_add')) {
      $this->renderText('{ "result":"error", "text":"You must have a score of at least '.LimelightUtils::getUserActionMinScore('add a link').' to add links." }');
      return sfView::NONE;
    }

    if ($request->getParameter('news_link'))
    {
      $submission = $request->getParameter('news_link');
      $form = new NewsLinkForm();
      $form->bind($submission);
      if ($form->isValid())
      {
        $link = Doctrine::getTable('NewsLink')->checkDuplicate($submission['source_name'], $submission['source_url'], $item_id);
        if ($link)
        {
          $this->renderText('{ "result":"error", "text":"A link with this URL has already been submitted, or this source has already been submitted!" }');
          return sfView::NONE;
        }
        $s = Doctrine::getTable('Limelight')->findOneByNameSlug(LimelightUtils::slugify($submission['source_name']));
        if (!$s && !$user->hasPermission('link_add_new')) {
          $this->renderText('{ "result":"error", "text":"You must have a score of at least '.LimelightUtils::getUserActionMinScore('add a NEW link').' to add links from a new source." }');
          return sfView::NONE;
        }
        if (!$s) // create a new source if the source has never been added
        {
          $s = new Limelight();
          $s->name = $submission['source_name'];
          $s->limelight_type = 'Source';
          $s->user_id = $user->id;
          $s->save();
        }

        $nl = new NewsLink();
        $nl->source_url = $submission['source_url'];
        $nl->user_id = $user->id;
        $nl->item_id = $item_id;
        $nl->source_id = $s->id;
        $nl->save();

        $this->renderText('{ "result":"success" }');
        return sfView::NONE;
      } else {
        //$this->renderText('{ "result":"error", "text":"'.$form.'" }');
        $this->renderText('{ "result":"error", "text":"Please check that you entered a source name, and that the source URL is a valid URL (http:// included)." }');
        return sfView::NONE;
      }
    }
    $this->renderText('{ "result":"error", "text":"There was an error while submitting your link. Please try again later." }');
    return sfView::NONE;
  }
}