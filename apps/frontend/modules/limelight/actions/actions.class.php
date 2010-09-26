<?php
/**
 * limelight actions.
 *
 * @package    limelight
 * @subpackage limelight
 * @author     marc
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class limelightActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */

  public function executeShow(sfWebRequest $request)
  {
    $user = $this->getUser();
    $this->user_id = $user->isAuthenticated() ? $user->getGuardUser()->id : 0;
    $this->limelight = $this->getRoute()->getObject();

    if ($this->limelight->limelight_type == 'product')
    {
      $this->slices = Doctrine::getTable('Limelight')->getSlices($this->limelight['id'], $this->limelight['name']);
    }

    if ($this->limelight->limelight_type == 'company')
    {
      $this->products = Doctrine::getTable('Limelight')->getProducts($this->limelight['id'], sfConfig::get('app_limelight_product_num'), 0);
    }

    $this->wikis = Doctrine::getTable('Wiki')->getLimelightWikis($this->limelight['id']);
    $this->wikiForm = new WikiForm();
    $this->spec_requirements_check = Doctrine::getTable('Limelight')->checkSpecRequirements($this->limelight['id']);
  }

  public function executeSuggest(sfWebRequest $request)
  {
    $this->form = new LimelightForm();
    $this->categories = Doctrine::getTable('Category')->getCategories();
  }

  // Process a new limelight suggestion
  public function executeProcessSuggest(sfWebRequest $request)
  {
    $this->form = new LimelightForm();
    $errors = array('result' => '', 'global_error' => '', 'info_error' => array());
    $error = false;
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $errors['result'] = 'login';
      $this->renderText(json_encode($errors));
      return sfView::NONE;
    }

    $user = $this->getUser()->getGuardUser();
    if ($request->getParameter('limelight'))
    {
      $submission = $request->getParameter('limelight');

      // check if limelight type
      if (!in_array($submission['limelight_type'], array('product', 'technology', 'company', 'source')))
      {
        $errors['result'] = 'error';
        $errors['info_error'][] = array('name' => '#limelightSuggest_F .item.types label', 'error' => 'error_on');
      }

      // check the category is present
      if (!$submission['category_1'])
      {
        $errors['result'] = 'error';
        $errors['info_error'][] = array('name' => '#limelightSuggest_F .item.category_chooser label', 'error' => 'error_on');
      }

      // if the type is a product, check that the company is present
      if ($submission['limelight_type'] == 'product' && !$submission['company_name'])
      {
        $errors['result'] = 'error';
        $errors['info_error'][] = array('name' => '#limelight_company_name', 'error' => '<ul class="error_list"><li>The product company name is required.</li></ul>');
      }

      // return an error if no type or category
      if ($errors['result'] == 'error')
      {
        $this->renderText(json_encode($errors));
        return sfView::NONE;
      }

      $this->form->bind($submission);
      if ($this->form->isValid())
      {
        // check that the limelight hasn't been submitted yet
        $ll = Doctrine::getTable('Limelight')->findOneByName($submission['name']);
        if ($ll)
        {
          $errors['result'] = 'error';
          $errors['info_error'][] = array('name' => '#limelight_name', 'error' => '<ul class="error_list"><li>A limelight with this name has already been submitted!</li></ul>');
          $this->renderText(json_encode($errors));
          return sfView::NONE;
        }

        // do we need to check for / create a new company?
        if ($submission['company_name'] && $submission['limelight_type'] == 'product')
        {
          $company = Doctrine::getTable('Limelight')->findOneByNameSlug(LimelightUtils::slugify($submission['company_name']));
          if (!$company)
          {
            $company = new Limelight();
            $company->user_id = $user->id;
            $company->name = $submission['company_name'];
            $company->limelight_type = 'company';
            $company->save();
          }
        }

        // create the actual limelight
        $ll = new Limelight();
        $ll->user_id = $user->id;
        $ll->name = $submission['name'];
        if (isset($company))
        {
          $ll->company_name = $company->name;
          $ll->company_id = $company->id;
        }
        $ll->limelight_type = $submission['limelight_type'];
        $ll->save();

        // create the limelight summary
        $s = new LimelightSummary();
        $s->user_id = $user->id;
        $s->item_id = $ll->id;
        $s->summary = $submission['summary'];
        $s->version = Doctrine::getTable('LimelightSummary')->generateVersionNum($ll->id);
        $s->save();

        // attach it to the given categories
        $cl = new CategoryLimelight();
        $cl->limelight_id = $ll->id;
        $cl->category_id = $submission['category_1'];
        $cl->save();
        if (isset($submission['category_2']))
        {
          $cl = new CategoryLimelight();
          $cl->limelight_id = $ll->id;
          $cl->category_id = $submission['category_2'];
          $cl->save();
        }
        if (isset($submission['category_2']) && isset($submission['category_3']))
        {
          $cl = new CategoryLimelight();
          $cl->limelight_id = $ll->id;
          $cl->category_id = $submission['category_3'];
          $cl->save();
        }

        // retrive, save, and attach the chosen limelight image
        // check the image mime type
        if (isset($submission['profile_image']))
        {
          $img_info = getimagesize($submission['profile_image']);
          $mime = $img_info['mime'];
          $ext = substr(strrchr($mime, '/'), 1);

          // get the image if it's there and of the right type
          if (in_array($ext, array('jpeg', 'jpg', 'png', 'bmp', 'gif')))
          {
            $ch = curl_init($submission['profile_image']);
            $tmp_filename = uniqid('TLI') . '.' . $ext;
            $tmpfname = tempnam(sfConfig::get('sf_upload_dir').'/tmp', $tmp_filename);
            $tmp_image = fopen($tmpfname, "wb");
            curl_setopt($ch, CURLOPT_FILE, $tmp_image);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($tmp_image);
            $ll->saveProfileImage($tmpfname);
            unlink($tmpfname);
          }
        }
        
        $this->getUser()->setFlash('notice', 'Congrats, your limelight has been successfully submitted! Start contributing to it below.');
        $errors['result'] = 'success';
        $errors['url'] = url_for('lime_show', array('name_slug' => $ll->name_slug));
        $this->renderText(json_encode($errors));
        return sfView::NONE;
      }

      $errors['result'] = 'error';
      $errors['global_error'] = $this->form->renderGlobalErrors();
      // info errors
      foreach ($this->form as $field)
      {
        $errors['info_error'][] = array('name' => '#limelight_'.$field->getName(), 'error' => $field->renderError());
      }

      $this->renderText(json_encode($errors));
      return sfView::NONE;
    }
  }

  public function executeCheck(sfWebRequest $request)
  {
    $name = $request->getParameter('q', null);
    $image_search = $request->getParameter('iq', null);

    $limelights = Doctrine::getTable('Limelight')->checkExistence($name);

    $return_data = array('ll_matches' => array(), 'image_matches' => array());
    foreach ($limelights as $limelight)
    {
      $name = $limelight['company_name'] != null ? $limelight['company_name'].' '.$limelight['name'] : $limelight['name'];
      $return_data['ll_matches'][] = array('name' => $name, 'url' => url_for('lime_show', array('name_slug' => $limelight['name_slug'])));
    }

    // Scrape google for the first 10 images that match the name
    require(sfConfig::get('sf_root_dir').'/lib/Goutte/goutte.phar');
    $client = new Goutte\Client();
    
    $name_sanitized = preg_replace('/\W+/', '+', $image_search);
    $name_sanitized = strtolower(trim($name_sanitized, '+'));

    $crawler = $client->request('GET', 'http://www.google.com/images?q='.$name_sanitized.'&biw=1920&bih=979');
    $images = $crawler->filter('.rg_l')->each(function ($node, $i)
    {
      if ($i > 15)
        return;

      $image = $node->getAttribute('href');
      $startPos = strrpos($image, 'imgurl=')+7;
      $endPos = strpos($image, '&imgrefurl');
      $lenOfPart = $endPos - $startPos;
      $imgUrl = substr($image, $startPos, $lenOfPart);
      return $imgUrl;
    });

    foreach ($images as $image)
    {
      $return_data['image_matches'][] = $image;
    }

    $this->renderText(json_encode($return_data));
    return sfView::NONE;
  }

  public function executeAddSlice (sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $return_data;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
    {
      $return_data['result'] = 'login';
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    $form = new LimelightSliceForm();

    if ($request->getParameter('slice'))
    {
      $submission = $request->getParameter('slice');
      $ll = Doctrine::getTable('Limelight')->checkStub($submission['limelight_id']);
      if (!($ll['is_stub'] && $user->hasPermission('stub_edit')) && !$user->hasPermission('limelight_slice_add')) {
        if ($ll['is_stub'])
          $return_data = array('result' => 'error', 'text' => 'You cannot edit limelight stubs, you must have a score of at least '.LimelightUtils::getUserActionMinScore('edit a limelight stub').'.');
        else
          $return_data = array('result' => 'error', 'text' => 'You cannot add limelight slices, you must have a score of at least '.LimelightUtils::getUserActionMinScore('add a limelight slice').'.');
        $this->renderText(json_encode($return_data));
        return sfView::NONE;
      }

      $form->bind($submission);
      if ($form->isValid())
      {
        $found = Doctrine::getTable('LimelightSlice')->checkDuplicate($submission['limelight_id'], $submission['name']);
        if ($found) {
          $return_data['result'] = 'error';
          $return_data['global_error'] = 'The slice you are trying to add has previously been added this limelight';
          $this->renderText(json_encode($return_data));
          return sfView::NONE;
        }

        $slice = new LimelightSlice();
        $slice->name = $submission['name'];
        $slice->item_id = $submission['limelight_id'];
        $slice->user_id = $user->getGuardUser()->id;
        $slice->save();

        $return_data['result'] = 'success';
        $this->renderText(json_encode($return_data));
        return sfView::NONE;
      }
      else
      {
        $return_data['global_error'] = $form->renderGlobalErrors();
      }
    }

    $return_data['result'] = 'error';
    // basic info errors
    foreach ($form as $field)
    {
      $return_data['info_error'][] = array('name' => $field->getName(), 'error' => $field->renderError());
    }
    $this->renderText(json_encode($return_data));
    return sfView::NONE;
  }

  public function executeAddSpecification (sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $return_data;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
    {
      $return_data['result'] = 'login';
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    if ($request->getParameter('specification'))
    {
      $submission = $request->getParameter('specification');
      $form = new LimelightSpecificationForm($submission['limelight_id']);
      $ll = Doctrine::getTable('Limelight')->checkStub($submission['limelight_id']);
      if (!($ll['is_stub'] && $user->hasPermission('stub_edit')) && !$user->hasPermission('limelight_spec_add')) {
        if ($ll['is_stub'])
          $return_data = array('result' => 'error', 'text' => 'You cannot edit limelight stubs, you must have a score of at least '.LimelightUtils::getUserActionMinScore('edit a limelight stub').'.');
        else
          $return_data = array('result' => 'error', 'text' => 'You cannot add limelight specifications, you must have a score of at least '.LimelightUtils::getUserActionMinScore('add a limelight spec').'.');
        $this->renderText(json_encode($return_data));
        return sfView::NONE;
      }

      $form->bind($submission);
      if ($form->isValid())
      {
        $found = Doctrine::getTable('LimelightSpecification')->checkDuplicate($submission['limelight_id'], $submission['name'], $submission['content']);
        if ($found) {
          $return_data['result'] = 'error';
          $return_data['global_error'] = 'The specification you are trying to add has previously been added this limelight';
          $this->renderText(json_encode($return_data));
          return sfView::NONE;
        }

        $spec = Doctrine::getTable('Specification')->add($submission['name'], $user->getGuardUser()->id);
        $s = Doctrine::getTable('Limelight')->findOneByNameSlug(LimelightUtils::slugify($submission['name']));
        if (!$s && !$user->hasPermission('link_add_new')) {
          $this->renderText('{ "result":"error", "text":"You must have a score of at least '.LimelightUtils::getUserActionMinScore('add a NEW link').' to add specs from a new source." }');
          return sfView::NONE;
        }
        if (!$s) // create a new source if the source has never been added
        {
          $s = new Limelight();
          $s->name = $submission['source_name'];
          $s->limelight_type = 'Source';
          $s->user_id = $user->getGuardUser()->id;
          $s->save();
        }

        $limeSpec = new LimelightSpecification();
        $limeSpec->content = $submission['content'];
        $limeSpec->source_url = $submission['source_url'];
        $limeSpec->item_id = $submission['limelight_id'];
        $limeSpec->user_id = $user->getGuardUser()->id;
        $limeSpec->specification_id = $spec->id;
        $limeSpec->source_id = $s->id;
        $limeSpec->slice_id = ($submission['slices'] == 0) ? null : $submission['slices'];
        $limeSpec->save();

        $return_data['result'] = 'success';
        $this->renderText(json_encode($return_data));
        return sfView::NONE;
      }
      else
      {
        $return_data['global_error'] = $form->renderGlobalErrors();
      }
    }
    else
    {
      $form = new LimelightSpecificationForm(0);
    }

    $return_data['result'] = 'error';
    // basic info errors
    foreach ($form as $field)
    {
      $return_data['info_error'][] = array('name' => $field->getName(), 'error' => $field->renderError());
    }
    $this->renderText(json_encode($return_data));
    return sfView::NONE;
  }

  public function executeAddProCon($request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $return_data;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
    {
      $return_data['result'] = 'login';
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    if ($request->getParameter('limelight_procon'))
    {
      $submission = $request->getParameter('limelight_procon');
      $form = new LimelightProConForm($submission['limelight_id']);
      $ll = Doctrine::getTable('Limelight')->checkStub($submission['limelight_id']);
      if (!($ll['is_stub'] && $user->hasPermission('stub_edit')) && !$user->hasPermission('procon_add')) {
        if ($ll['is_stub'])
          $return_data = array('result' => 'error', 'text' => 'You cannot edit limelight stubs, you must have a score of at least '.LimelightUtils::getUserActionMinScore('edit a limelight stub').'.');
        else
          $return_data = array('result' => 'error', 'text' => 'You cannot add limelight pros or cons, you must have a score of at least '.LimelightUtils::getUserActionMinScore('add a pro/con').'.');
        $this->renderText(json_encode($return_data));
        return sfView::NONE;
      }

      $form->bind($submission);
      if ($form->isValid())
      {
        $item_type = $request->getParameter('item_type', null);
        $found = Doctrine::getTable('LimelightProCon')->checkDuplicate($submission['limelight_id'], $submission['name']);
        if ($found) {
          $return_data['result'] = 'error';
          $return_data['global_error'] = 'The '.$item_type.' you are trying to add has previously been added this limelight';
          $this->renderText(json_encode($return_data));
          return sfView::NONE;
        }

        $pc = new LimelightProCon();
        $pc->name = substr($submission['name'], 0, sfConfig::get('app_limelight_procon_max_length'));
        $pc->type = $item_type;
        $pc->item_id = $submission['limelight_id'];
        $pc->slice_id = ($submission['slices'] == 0) ? null : $submission['slices'];
        $pc->user_id = $user->getGuardUser()->id;
        $pc->save();

        $return_data['result'] = 'success';
        $this->renderText(json_encode($return_data));
        return sfView::NONE;
      }
      else
      {
        $return_data['global_error'] = $form->renderGlobalErrors();
      }
    }
    else
    {
      $form = new LimelightProConForm(0);
    }

    $return_data['result'] = 'error';
    // basic info errors
    foreach ($form as $field)
    {
      $return_data['info_error'][] = array('name' => $field->getName(), 'error' => $field->renderError());
    }
    $this->renderText(json_encode($return_data));
    return sfView::NONE;
  }

  public function executeApprove(sfWebRequest $request)
  {
    $user = $this->getUser();
    $return_data = array();
    if (!$user->isAuthenticated())
    {
      $return_data['result'] = 'login';
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    if (!$user->hasPermission('limelight_approve'))
    {
      $return_data['result'] = 'error';
      $return_data['text'] = 'You cannot approve limelights, you must have a score of at least '.LimelightUtils::getUserActionMinScore('approve limelights').'.';
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    Doctrine::getTable('Limelight')->approveLimelight($request->getParameter('id', null));

    $return_data = array('result' => 'success', 'new_text' => 'approved', 'text' => 'Limelight successfully approved!');
    $this->renderText(json_encode($return_data));
    return sfView::NONE;
  }

  public function executeEditSummary(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $return_data;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
    {
      $return_data['result'] = 'login';
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    $ll = Doctrine::getTable('Limelight')->checkStub($request->getParameter('id'));
    if (!($ll['is_stub'] && $user->hasPermission('stub_edit')) && !$user->hasPermission('limelight_approve')) {
      if ($ll['is_stub'])
        $return_data = array('result' => 'error', 'text' => 'You cannot edit limelight stubs, you must have a score of at least '.LimelightUtils::getUserActionMinScore('edit a limelight stub').'.');
      else
        $return_data = array('result' => 'error', 'text' => 'You cannot edit limelight summaries, you must have a score of at least '.LimelightUtils::getUserActionMinScore('approve limelights').'.');
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    if ($request->hasParameter('s'))
    {
      $summary = $request->getParameter('s');
      if (strlen($summary) > 275)
      {
        $return_data = array('result' => 'error', 'text' => 'Limelight summaries have a max length of 275 characters.');
        $this->renderText(json_encode($return_data));
        return sfView::NONE;
      }
      $s = new LimelightSummary();
      $s->user_id = $user->getGuardUser()->id;
      $s->item_id = $ll->id;
      $s->summary = $summary;
      $s->version = Doctrine::getTable('LimelightSummary')->generateVersionNum($ll->id);
      $s->save();

      $return_data = array('result' => 'success');
      $this->renderText(json_encode($return_data));
      return sfView::NONE;
    }

    $return_data = array('result' => 'success');
    $this->renderText(json_encode($return_data));
    return sfView::NONE;
  }

  public function executeShowNews(sfWebRequest $request)
  {
    $user = $this->getUser();
    $user_id = $user->isAuthenticated() ? $user->getGuardUser()->id : 0;
    $this->user_id = $user->isAuthenticated() ? $user->getGuardUser()->id : 0;

    if ($request->hasParameter('id'))
    {
      $this->limelight_id = $request->getParameter('id');
      $this->limelight_type = $request->getParameter('type');
    }
    else
    {
      $this->limelight = $this->getRoute()->getObject();
      $this->limelight_id = $this->limelight->id;
      $this->limelight_type = $this->limelight->limelight_type;
    }

    $this->items = Doctrine::getTable('Limelight')->getNewsFeed(
            $this->limelight_id,
            $this->limelight_type,
            sfConfig::get('app_limelight_feed_num'),
            sfConfig::get('app_limelight_feed_num') * ($request->getParameter('page', 1)-1)
    );
    $this->next_page = $request->getParameter('page', 1)+1;
    $this->feed_more_url = 'lime_show_news_more';

    if ($this->getRequest()->isXmlHttpRequest())
    {
      return $this->renderPartial('user/actionFeed', array(
        'items' => $this->items,
        'limelight_id' => $this->limelight_id,
        'next_page' => $this->next_page,
        'type' => 'news',
        'feed_more_url' => $this->feed_more_url
      ));
      return sfView::NONE;
    }

    //    if ($request->isXmlHttpRequest() && $request->getParameter('ci') && $request->getParameter('sb') && $request->getParameter('tp'))
//    {
//      $ci = $request->getParameter('ci');
//      $sb = $request->getParameter('sb');
//      $tp = $request->getParameter('tp');
//      $user->setFlash('ci', $ci);
//      $user->setFlash('sb', $sb);
//      $user->setFlash('tp', $tp);
//    }
//    else if ($request->isXmlHttpRequest() || $user->hasFlash('ci'))
//    {
//      $ci = $user->getFlash('ci');
//      $sb = $user->getFlash('sb');
//      $tp = $user->getFlash('tp');
//      $user->setFlash('ci', $ci);
//      $user->setFlash('sb', $sb);
//      $user->setFlash('tp', $tp);
//    }
//    else
//    {
//      $ci = 30;
//      $sb = 'news_score_increase';
//      $tp = 3;
//    }

//    $this->section = $request->getParameter('section', null);
//
//    $this->filters = array('sb' => $sb);
//    $this->items = Doctrine::getTable('News')->findByFilters($ci, $sb, $tp, 0, $this->user_id, $this->section, $this->limelight->id);
//
//    if ($request->isXmlHttpRequest())
//    {
//      $this->renderPartial('content/feedItems', array('items' => $this->items, 'user' => $this->user_id, 'type' => 'News', 'section' => $this->section, 'filters' => $this->filters));
//      return sfView::NONE;
//    }
//    else
//    {
//      $this->limelightStats = Doctrine::getTable('Limelight')->getLimelightStats($this->limelight['id'], $this->user_id);
//    }
  }

  public function executeShowProducts(sfWebRequest $request)
  {
    $user = $this->getUser();
    $user_id = $user->isAuthenticated() ? $user->getGuardUser()->id : 0;
    $this->user_id = $user->isAuthenticated() ? $user->getGuardUser()->id : 0;

    if ($request->hasParameter('id'))
    {
      $this->limelight_id = $request->getParameter('id');
    }
    else
    {
      $this->limelight = $this->getRoute()->getObject();
      $this->limelight_id = $this->limelight->id;
    }

    $this->items = Doctrine::getTable('Limelight')->getProducts(
            $this->limelight_id,
            sfConfig::get('app_limelight_product_num'),
            sfConfig::get('app_limelight_product_num') * ($request->getParameter('page', 1)-1)
    );
    $this->next_page = $request->getParameter('page', 1)+1;
    $this->feed_more_url = 'lime_show_products_more';

    if ($this->getRequest()->isXmlHttpRequest())
    {
      $this->renderPartial('user/actionFeed', array(
        'items' => $this->items,
        'limelight_id' => $this->limelight_id,
        'next_page' => $this->next_page,
        'type' => 'limelight',
        'feed_more_url' => $this->feed_more_url
      ));
      return sfView::NONE;
    }
  }



































  public function executeDisableSpec(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $user_id = $user->getGuardUser()->id;

    if (!$user->hasPermission('spec_disable')) {
      $this->renderText('{"html":"You do not have permission to disable specifications in this limelight", "code":"0"}');
      return sfView::NONE;
    }

    $spec_id = $request->getParameter('id');
    $flag_type = $request->getParameter('type');

    $specFlagsTable = Doctrine::getTable('LimelightSpecFlags');
    $disabled = $specFlagsTable->flag($user_id, $spec_id, $flag_type, true);

    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager)
      $cacheManager->remove('@sf_cache_partial?module=limelight&action=_wiki&sf_cache_key=ll_id='.$disabled['spec']['limelight_id'].'&user_id='.$disabled['disabled']);

    $this->renderText('{"html":"Moderator action :: specification sucessfully disabled", "code":"1"}');

    return sfView::NONE;
  }

  public function executeLockSpecs(sfWebRequest $request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $user = $user->getGuardUser();
    if (!$user->hasPermission('spec_lock')) {
      $this->renderText('0**You do not have permission to change the specifications lock settings on this limelight.');
      return sfView::NONE;
    }

    $ll_id = $request->getParameter('id');
    $lock_code = $request->getParameter('lock_code');

    $ll = Doctrine::getTable('Limelight')->findOneById($ll_id);
    $ll->spec_lock = $lock_code;
    $ll->save();

    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager) {
      $cacheManager->remove('@sf_cache_partial?module=limelight&action=_wiki&sf_cache_key=ll_id='.$ll_id.'&user_id=*');
    }

    $this->renderText('1**Moderator action :: the limelight specifications lock was successfully updated');

    return sfView::NONE;
  }

  public function executeOwn($request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$request->hasParameter('item_id')) {
      $this->renderText('{ "result":"error", "text":"There was an error while \'owning\' this item. Please try again later" }');
      Doctrine::getTable('Log')->newLog('limelight own', 'No ajax or not post or parameters missing.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $item_id = $request->getParameter('item_id');
    $count = $request->getParameter('count', 'err');
    if ($count != 'err')
      $count++;

    $o = new LimelightOwn();
    $o->user_id = $user->id;
    $o->item_id = $item_id;
    $o->save();
    
    $this->renderText('{ "result":"success", "text":"You have added this limelight to your owned list!", "new_text":"owned - '.$count.'"}');
    return sfView::NONE;
  }

  public function executeDisown($request)
  {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    $user = $user->getGuardUser();
    if (!$request->isXmlHttpRequest() || !$request->isMethod('post') || !$request->hasParameter('item_id')) {
      $this->renderText('{ "result":"error", "text":"There was an error while \'disowning\' this item. Please try again later" }');
      Doctrine::getTable('Log')->newLog('limelight disown', 'No ajax or not post or parameters missing.', $user->id, $_SERVER['REMOTE_ADDR']);
      return sfView::NONE;
    }

    $item_id = $request->getParameter('item_id');
    $count = $request->getParameter('count', 'err');
    if ($count != 'err')
      $count--;

    Doctrine::getTable('LimelightOwn')->Disown($item_id, $user->id);

    $this->renderText('{ "result":"success", "text":"You have removed this limelight from your owned list!", "new_text":"own - '.$count.'"}');
    return sfView::NONE;
  }

  public function executeUpdateProConScore($request)
  {
    if (!$this->request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $this->user = $user->getGuardUser();
    $target_user_id = $request->getParameter('target_user_id');
    $procon_id = $request->getParameter('item_id');
    $direction = $request->getParameter('d');

    if ($this->user->id == $target_user_id)
      $this->forward404('You submitted this item. You may not score your own submissions.');

    $updated = Doctrine::getTable('LimelightProConScore')->updateScore($procon_id, $this->user->id, $target_user_id, $direction);

    if ($updated) {
      $cacheManager = $this->getContext()->getViewCacheManager();
      if ($cacheManager) {
        $cacheManager->remove('@sf_cache_partial?module=limelight&action=_proscons&sf_cache_key=ll_id='.$updated->limelight_id.'&user_id=*');
        $cacheManager->remove('@sf_cache_partial?module=user&action=_userLink&sf_cache_key=*'.$target_user_id);
      }
      $this->renderText($updated->score);
    } else
      $this->renderText('err');

    return sfView::NONE;
  }

  

  public function executeFlagProCon($request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $user = $user->getGuardUser();

    if ($user->Profile->score < sfConfig::get('app_limelight_procon_ms_flag')) {
      $this->renderText('{"html":"You must have a minimum score of <b>' . sfConfig::get('app_limelight_procon_ms_flag') . '</b> in order to flag pros and cons.", "code":"0"}');
      return sfView::NONE;
    }

    $user_id = $user->id;
    $pc_id = $request->getParameter('id');
    $flag_type = $request->getParameter('type');

    $pcFlagsTable = Doctrine::getTable('LimelightProConFlags');
    $flagged = $pcFlagsTable->flag($user_id, $pc_id, $flag_type, false);

    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager)
      $cacheManager->remove('@sf_cache_partial?module=limelight&action=_proscons&sf_cache_key=ll_id='.$flagged['procon']['limelight_id'].'&user_id='.$flagged['disabled']);

    $this->renderText('{"html":"Pro/Con successfully flagged for review. Thanks for helping keep '. sfConfig::get('app_site_name') .' clean and accurate!", "code":"1"}');

    return sfView::NONE;
  }

  public function executeDisableProCon($request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $user = $user->getGuardUser();

    if (!$user->hasPermission('procon_disable')) {
      $this->renderText('{"html":"You do not have permission to disable pros /cons in this limelight", "code":"0"}');
      return sfView::NONE;
    }

    $user_id = $user->id;
    $pc_id = $request->getParameter('id');
    $flag_type = $request->getParameter('type');

    $pcFlagsTable = Doctrine::getTable('LimelightProConFlags');
    $flagged = $pcFlagsTable->flag($user_id, $pc_id, $flag_type, true);

    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager)
      $cacheManager->remove('@sf_cache_partial?module=limelight&action=_proscons&sf_cache_key=ll_id='.$flagged['procon']['limelight_id'].'&user_id='.$flagged['disabled']);

    $this->renderText('{"html":"Moderator action :: pro / con sucessfully disabled", "code":"1"}');

    return sfView::NONE;
  }

  public function executeLockProCon($request)
  {
    if (!$request->isXmlHttpRequest())
      $this->forward404;

    $user = $this->getUser();
    if (!$user->isAuthenticated())
      $this->forward('sfGuardAuth', 'secure');

    $user = $user->getGuardUser();
    if (!$user->hasPermission('procon_lock')) {
      $this->renderText('0**You do not have permission to change the pro / cons lock settings on this limelight.');
      return sfView::NONE;
    }

    $ll_id = $request->getParameter('id');
    $lock_code = $request->getParameter('lock_code');

    $ll = Doctrine::getTable('Limelight')->findOneById($ll_id);
    $ll->procon_lock = $lock_code;
    $ll->save();
      
    $cacheManager = $this->getContext()->getViewCacheManager();
    if ($cacheManager)
      $cacheManager->remove('@sf_cache_partial?module=limelight&action=_proscons&sf_cache_key=ll_id='.$ll_id.'&user_id=*');

    $this->renderText('1**Moderator action :: the limelight pro/con lock was successfully updated');

    return sfView::NONE;
  }

  public function executeShowReviews()
  {
    $user = $this->getUser();
    $this->user_id = ($user->isAuthenticated() ? $user->getGuardUser()->id : 0);
    $this->limelight = $this->getRoute()->getObject();

    if ($this->limelight->release_date && date('Y-m-d', time() + sfConfig::get('app_reviews_enable_user_date')) >= $this->limelight->release_date)
        $this->reviewsUserFlag = true;
    else
        $this->reviewsUserFlag = false;

    if ($this->limelight->release_date && date('Y-m-d', time() + sfConfig::get('app_reviews_enable_pro_date')) >= $this->limelight->release_date)
        $this->reviewsProFlag = true;
    else
        $this->reviewsProFlag = false;

    $this->limelightStats = Doctrine::getTable('Limelight')->getLimelightStats($this->limelight['id'], $this->user_id);
  }
}