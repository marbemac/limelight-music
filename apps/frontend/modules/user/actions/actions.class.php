<?php

sfProjectConfiguration::getActive()->loadHelpers('Url');

/**
 * user actions.
 *
 * @package    user
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class userActions extends sfActions
{
  // ***** FOR THE BETA SPLASH PAGE
  public function executeAddBetaEmail($request)
  {
    $email = $request->getParameter('email');
    if (strlen(trim($email)) > 0)
    {
      $flag = Doctrine::getTable('BetaEmail')->findOneByEmail($email);
      if ($flag)
        return sfView::NONE;
      
      $be = new BetaEmail();
      $be->email = $email;
      $be->ip = $_SERVER['REMOTE_ADDR'];
      $be->save();
    }
    return sfView::NONE;
  }
  public function executeBetaAccess($request)
  {
    $result = array();
    $pass = $request->getParameter('p');
    if ($pass == sfConfig::get('app_beta_pass'))
    {
      $result['result'] = 'success';
      $this->getUser()->setAttribute('beta_access', true);
    }
    else
    {
      $result['result'] = 'error';
    }
    $this->renderText(json_encode($result));
    return sfView::NONE;
  }

  public function executeBetaGiveaway($request)
  {
    $result = array();
    $group = trim($request->getParameter('c'));
    $guess = $request->getParameter('g');
    $email = trim($request->getParameter('e'));

    $be = Doctrine::getTable('BetaEmail')->findOneByEmail($email);
    if (!$be)
    {
      $be = new BetaEmail();
      $be->email = $email;
      $be->ip = $_SERVER['REMOTE_ADDR'];
      $be->save();
    }

    $code = sfConfig::get('app_beta_giveaway_group');
    if ($group != $code)
    {
      $result['result'] = 'error';
      $result['text'] = 'That\'s not the right code! Visit the Tech Limelight twitter or facebook page to get the latest giveaway code.';
      $this->renderText(json_encode($result));
      return sfView::NONE;
    }
    $previous = Doctrine::getTable('BetaGiveaway')->checkSubmission($be->id);
    if ($previous)
    {
      $result['result'] = 'error';
      $result['text'] = 'You already made a guess for this giveaway. We\'ll let you know if you win.
                         Follow us on Twitter and Facebook to be notified when the next one starts!';
      $this->renderText(json_encode($result));
      return sfView::NONE;
    }

    $bg = new BetaGiveaway();
    $bg->guess = LimelightUtils::slugify($guess);
    $bg->group_code = sfConfig::get('app_beta_giveaway_group_code');
    $bg->beta_email_id = $be->id;
    $bg->save();

    $result['result'] = 'success';
    $result['text'] = 'Congrats, you\'ve successfully entered into the giveaway! We\'ll shoot you an email if you win. Follow us
                       on Twitter and Facebook to get a notification when the next one starts!';
    $this->renderText(json_encode($result));
    return sfView::NONE;
  }
  // END BETA SPLASH

  // new Janrain login handler
  public function executeTokenize($request)
  {
    /* STEP 1: Extract token POST parameter */
    $rpxApiKey = sfConfig::get('app_rpx_api_key');

    /* STEP 2: Use the token to make the auth_info API call */
    $token = $request->getParameter('token');
    $post_data = array('token'  => $token,
                       'apiKey' => $rpxApiKey,
                       'format' => 'json');

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/auth_info');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $raw_json = curl_exec($curl);
    curl_close($curl);

    /* STEP 3: Parse the JSON auth_info response */
    $auth_info = json_decode($raw_json, true);

    if ($auth_info['stat'] == 'ok') {
      /* STEP 3 Continued: Extract the 'identifier' from the response */
      $profile = $auth_info['profile'];
      $identifier = $profile['identifier'];
      $primaryKey = $profile['primaryKey'];

      // will store whether we need to create a new mapping for this openID
      $new_map = false;

      // do we have an account for them yet?
      $user = Doctrine::getTable('sfGuardUser')->find($primaryKey);
      // first check the primaryKey returned
      if (!$user)
        $user = Doctrine::getTable('sfGuardUser')->findOneByRpxIdentifier($identifier);
      
      // then if none by identifier, create a new user
      if (!$user)
      {
        $new_map = true; // this is a new user, create a new map
        $user = new sfGuardUser();
        $user->rpx_identifier = $identifier;
        $user->rpx_provider_name = isset($profile['providerName']) ? $profile['providerName'] : null;

        $username = preg_replace('/\W+/', '_', $profile['preferredUsername']);
        $username = strtolower(trim($username, '_'));
        $user->username = $username;

        $user->Profile->activated = 1;
        $user->Profile->status = 'Active';

      }
      else // we already have an account for this user
      {
        if ($user->Profile->status == 'Suspended')
        {
          Doctrine::getTable('Log')->newLog('janrain login error', 'suspended account login attempt', $user->id, $_SERVER['REMOTE_ADDR']);
          $this->getUser()->setFlash('error', 'This account has been temporarily suspended due to misconduct until '.$user->Profile->suspend_until.'. If you believe this is an error, please contact us.');
          $this->redirect('homepage');
        }
        else if ($user->Profile->status == 'Banned')
        {
          Doctrine::getTable('Log')->newLog('janrain login error', 'banned account login attempt', $user->id, $_SERVER['REMOTE_ADDR']);
          $this->getUser()->setFlash('error', 'This account has been permanantly banned. If you believe this is an error, please contact us.');
          $this->redirect('homepage');
        }

        $td = 0;
        if ($user->last_login == null)
          Doctrine::getTable('Badge')->increaseBadgeStat('Loyalty', $user->id);
        else {
          $last_login = strtotime($user->last_login);
          $td = mktime(0, 0, 0, date('n'), date('j'), date('Y')) - mktime(0, 0, 0, date('n', $last_login), date('j', $last_login), date('Y', $last_login));
          $td = $td/24/60/60;
        }

        if ($td == 1)
          Doctrine::getTable('Badge')->increaseBadgeStat('Loyalty', $user->id);
        else if ($td > 1)
          Doctrine::getTable('Badge')->setBadgeStat('Loyalty', $user->id, 1);
      }

      $autobiographer_prefill_count = 0;

      // keep the rpx data up to date
      if (isset($profile['name']['givenName']) && $profile['name']['givenName'] != $user->Profile->first_name)
      {
        $user->Profile->first_name =  $profile['name']['givenName'];
        $autobiographer_prefill_count++;
      }
      if (isset($profile['name']['familyName']) && $profile['name']['familyName'] != $user->Profile->last_name)
      {
        $user->Profile->last_name =  $profile['name']['familyName'];
        $autobiographer_prefill_count++;
      }
      if (isset($profile['gender']) && $profile['gender'] != $user->Profile->gender)
      {
        $user->Profile->gender =  $profile['gender'];
        $autobiographer_prefill_count++;
      }
      $user->Profile->rpx_birthday = isset($profile['birthday']) ? $profile['birthday'] : null;
      $user->Profile->rpx_url = isset($profile['url']) ? $profile['url'] : null;
      $user->Profile->email = isset($profile['verifiedEmail']) ? $profile['verifiedEmail'] : null;
      $user->Profile->rpx_profile_image = isset($profile['photo']) ? $profile['photo'] : null;

      $user->Profile->login_count += 1;
      $user->checkBadges();
      $user->save();

      for ($i=0; $i<$autobiographer_prefill_count; $i++)
        Doctrine::getTable('Badge')->increaseBadgeStat('Autobiographer', $user->id);

      $this->getUser()->signin($user, false);
      
      // do we need to create a new mapping?
      if ($new_map)
      {
        $post_data = array('apiKey'     => $rpxApiKey,
                           'identifier' => $identifier,
                           'primaryKey' => $user->id);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/map');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $raw_json = curl_exec($curl);
        curl_close($curl);
        
        $this->getUser()->setFlash('notice', $user->username . ', thanks for joining tech limelight! Use the \'change username\' button below to choose a username if you don\'t like the default that was assigned you.');
      }
      else
      {
        $this->getUser()->setFlash('notice', 'Welcome back, ' . $user->username . '!');
      }
      $this->redirect('user_show', array('username' => urlencode($user->username)));

    /* an error occurred */
    } else {
      // gracefully handle the error.  Hook this into your native error handling system.
      Doctrine::getTable('Log')->newLog('janrain login error', $auth_info['err']['msg'].' - code '.$auth_info['err']['code'], 0, $_SERVER['REMOTE_ADDR']);
      $this->getUser->setFlash('error', 'There was an error logging you in. Please try a different provider, or try again later. If the problem persists, please let us know.');
      $this->redirect('homepage');
    }

    return sfView::NONE;
  }

  public function executeChangeUsername (sfWebRequest $request)
  {
    $username = trim($request->getParameter('u', null));
    if (!$username)
    {
      $this->renderText(json_encode(array('result' => 'error', 'text' => 'Your username cannot be blank!')));
      return sfView::NONE;
    }

    if (strlen($username) < 3 || strlen($username) > 15)
    {
      $this->renderText(json_encode(array('result' => 'error', 'text' => 'Your username must be between 3 and 15 characters.')));
      return sfView::NONE;
    }

    if (!preg_match('/^\b[a-zA-Z0-9]+\b$/', $username))
    {
      $this->renderText(json_encode(array('result' => 'error', 'text' => 'Your username may only contain letters and numbers.')));
      return sfView::NONE;
    }

    $user = Doctrine::getTable('sfGuardUser')->findOneByUsername($username);
    if ($user)
    {
      $this->renderText(json_encode(array('result' => 'error', 'text' => 'That username is already taken! Try another one.')));
      return sfView::NONE;
    }

    $user = $this->getUser()->getGuardUser();
    $user->username = $username;
    $user->username_changed = true;
    $user->save();
    $this->getUser()->setFlash('notice', 'Username successfully changed!');

    $this->renderText(json_encode(array('result' => 'success', 'url' => url_for('user_show', array('username' => $user->username)))));
    return sfView::NONE;
  }

  // hides the home welcome splash for authenticated users and anon users
  public function executeHideWelcomeSplash()
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      $user = $user->getGuardUser();
      $user->show_welcome_splash = false;
      $user->save();
    }
    else
    {
      $user->setAttribute('show_welcome_splash', false);
    }

    return sfView::NONE;
  }

  // hides the top help bar for authenticated users and anon users
  public function executeHideTopHelp()
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      $user = $user->getGuardUser();
      $user->show_help = false;
      $user->save();
    }
    else
    {
      $user->setAttribute('show_help', false);
    }

    return sfView::NONE;
  }


  /**
   * executeNewUser
   * Displays the register user form and handles submission and creation of tech limelight user
   */
  public function executeNew(sfWebRequest $request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
      return $this->redirect('@homepage');

    $this->form = new RegisterForm();
  }

  public function executeCreate(sfWebRequest $request) {
    $this->form = new RegisterForm();
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function processForm(sfWebRequest $request) {
    $this->form = new RegisterForm();

    if ($request->getParameter('user'))
    {
      $submission = $request->getParameter('user');
      
      if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
        $captcha = array(
          'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
          'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
        );
        $this->form->bind(array_merge($submission, array('captcha' => $captcha)));
      } else
      {
        $this->form->bind($submission);
      }

      if ($this->form->isValid())
      {
        $code = uniqid('U');
        $sfUser = new sfGuardUser();
        $sfUser->username = $submission['username'];
        $sfUser->password = $submission['password'];
        $sfUser->Profile->email = $submission['email'];
        $sfUser->Profile->activate_code = $code;
        $sfUser->save();

        $message = Swift_Message::newInstance()
          ->setFrom('no-reply@techlimelight.com')
          ->setTo($submission['email'])
          ->setSubject('Welcome to '.sfConfig::get('app_site_name').'! Activate your new account now.')
          ->setBody($this->getPartial('validateEmail', array('username' => $submission['username'], 'code' => $code)), 'text/html')
        ;
        $this->getMailer()->send($message);

        $this->redirect('user_created');
      }
    }
  }

  public function executeCreated() {

  }

  public function executeValidate(sfWebRequest $request) {
    $user = Doctrine::getTable('sfGuardUser')->findOneByUsername($request->getParameter('username'));
    // Is there an account with this email?
    if ($user) {
      // Does the id = the activation code on the account?
      if ($user->Profile->getActivate_code() == $request->getParameter('code')) {
        $user->Profile->status = 'Active';
        $user->Profile->activated = True;
        $user->save();
        $this->text = 'Your account has been successfully verified! Please login by clicking on the \'login\' link above';
      } else
        $this->text = 'Validation failed. If you believe this is an error, please contact us.';
    } else
      $this->text = 'Validation failed. If you believe this is an error, please contact us.';
  }

  /**
   * executeCheckUsername
   * Used in ajax call from user reg form to check username
   */
  public function executeCheckUsername(sfWebRequest $request) {
    $username = Doctrine::getTable('sfGuardUser')->checkUsername($request->getParameter('username'));
    if ($username != '')
      $text = 'Username already taken!';
    else if (strlen($request->getParameter('username')) >= 4)
      $text = '<span style="color: #060">Available</span>';
    else
      $text = '';
    return $this->renderText($text);
  }

  /**
   * executeCheckEmail
   * Used in ajax call from user reg form to check email
   */
  public function executeCheckEmail(sfWebRequest $request) {
    $email = Doctrine::getTable('Profile')->checkEmail($request->getParameter('email'));
    if($email != '')
      $text = 'Email address already in use!';
    else
      $text = '';
    return $this->renderText($text);
  }

  public function executeClearNotifications(sfWebRequest $request) {
    $user = $this->getUser();
    if (!$user->isAuthenticated())
      return sfView::NONE;
    $user = $user->getGuardUser();
    Doctrine::getTable('UserNotification')->markAllRead($user->id);
    return sfView::NONE;
  }

  public function executeDeleteNotification(sfWebRequest $request) {
    $user = $this->getUser();
    if (!$user->isAuthenticated())
      return sfView::NONE;
    $user = $user->getGuardUser();
    Doctrine::getTable('UserNotification')->markOneRead($user->id, $request->getParameter('id'));
    return sfView::NONE;
  }

  public function executeTab(sfWebRequest $request) {
    $user = $this->getRoute()->getObject();
    if ($user->hasGroup('admin'))
      $groupText = '<div class="group admin rnd_3">administrator</div>';
    else if ($user->hasGroup('supermod'))
      $groupText = '<div class="group mod rnd_3">moderator</div>';
    else if ($user->Profile->first_100)
      $groupText = '<div class="group first_100 rnd_3">first 100 user</div>';
    else if ($user->Profile->first_100)
      $groupText = '<div class="group first_1000 rnd_3">first 1000 user</div>';
    else
      $groupText = '';

    return $this->renderPartial('user/tab', array('user' => $user, 'groupText' => $groupText));
  }

  public function executeUpdateSetting(sfWebRequest $request) {
    $user = $this->getUser();
    if (!$user->isAuthenticated() || !$request->isMethod('POST') || !$request->getParameter('setting') || !$request->getParameter('value')) {
      $this->renderText('{ "success":"false" }');
      return sfView::NONE;
    }
    $user = $user->getGuardUser();

    $setting = $request->getParameter('setting');
    $value = $request->getParameter('value');
    $badge_increase = false;

    if ($setting == 'first_name') {
      if ($user->Profile->first_name == null)
        $badge_increase = true;
      $user->Profile->first_name = $value;
    }
    else if ($setting == 'last_name') {
      if ($user->Profile->last_name == null)
        $badge_increase = true;
      $user->Profile->last_name = $value;
    }
    else if ($setting == 'zipcode') {
      if ($user->Profile->zipcode == null)
        $badge_increase = true;
      $user->Profile->zipcode = $value;
    }
    else if ($setting == 'gender') {
      if ($user->Profile->gender == null)
        $badge_increase = true;
      $user->Profile->gender = $value;
    }
    else if ($setting == 'age_range') {
      if ($user->Profile->age_range == null)
        $badge_increase = true;
      $user->Profile->age_range = $value;
    }
    else if ($setting == 'income_range') {
      if ($user->Profile->income_range == null)
        $badge_increase = true;
      $user->Profile->income_range = $value;
    }

    $user->save();
    if ($badge_increase)
      Doctrine::getTable('Badge')->increaseBadgeStat('Autobiographer', $user->id);

    $this->renderText('{ "success":"true" }');
    return sfView::NONE;
  }

  public function executeUpdateImage(sfWebRequest $request) {
    $user = Doctrine::getTable('sfGuardUser')->find($request->getParameter('id'));
    if ($_FILES['Filedata']['size'] > 2500000 || !getimagesize($_FILES['Filedata']['tmp_name']))
    {
      echo 0;
      return sfView::NONE;
    }

    if ($user->Profile->profile_image == 'user_profile_default.jpg') {
      Doctrine::getTable('Badge')->increaseBadgeStat('Self Portrait', $user->id);
      $image_count = 1;
    } else {
      $temp = explode('_', $user->Profile->profile_image);
      $temp2 = explode('.', $temp[2]);
      $image_count = (int)$temp2[0]+1;
    }

    $i = explode('.', $_FILES['Filedata']['name']);
    // filename format is user_(user_id)_(image count).(file_type)
    $fileName = 'user_'.$user->id.'_'.$image_count.'.'.$i[count($i)-1];

    // create the 4 file sizes and save
    $thumbnail_l = new sfThumbnail(500, 500);
    $thumbnail_l->loadFile($_FILES['Filedata']['tmp_name']);
    $thumbnail_l->save(sfConfig::get('sf_upload_dir').'/u_profile/large/'.$fileName);
    $thumbnail_m = new sfThumbnail(150, 150);
    $thumbnail_m->loadFile($_FILES['Filedata']['tmp_name']);
    $thumbnail_m->save(sfConfig::get('sf_upload_dir').'/u_profile/med/'.$fileName);
    $thumbnail_s = new sfThumbnail(75, 75);
    $thumbnail_s->loadFile($_FILES['Filedata']['tmp_name']);
    $thumbnail_s->save(sfConfig::get('sf_upload_dir').'/u_profile/small/'.$fileName);
    $thumbnail_t = new sfThumbnail(40, 40);
    $thumbnail_t->loadFile($_FILES['Filedata']['tmp_name']);
    $thumbnail_t->save(sfConfig::get('sf_upload_dir').'/u_profile/thumb/'.$fileName);

    $user->Profile->profile_image = $fileName;
    $user->save();

    return sfView::NONE;
  }

  public function executeMinifeed(sfWebRequest $request) {
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    $this->items = Doctrine::getTable('UserAction')->getMinifeed($this->user->id, sfConfig::get('app_user_feed_num'), 0);
    $this->next_page = 2;
    $this->feed_more_url = 'user_minifeed_more';
  }

  /**
   * this is used for the show more functionality of user feeds
   * if the request is ajax we just want the extra data and return the partial
   * else if regular request we want all the data and set to regular minifeed template
   */
  public function executeMinifeedMore(sfWebRequest $request) {
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    $this->items = Doctrine::getTable('UserAction')->getMinifeed(
            $this->user['id'],
            sfConfig::get('app_user_feed_num'),
            sfConfig::get('app_user_feed_num') * ($request->getParameter('page')-1)
    );
    $this->next_page = $request->getParameter('page')+1;
    $this->feed_more_url = 'user_minifeed_more';
    if ($request->isXmlHttpRequest())
      return $this->renderPartial('user/actionFeed', array(
        'items' => $this->items,
        'user' => $this->user,
        'next_page' => $this->next_page,
        'feed_more_url' => $this->feed_more_url
      ));
    else
      $this->setTemplate('minifeed');
  }

  public function executeBadge(sfWebRequest $request) {
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    $this->badges = Doctrine::getTable('Badge')->getUserBadges($this->user->id);
  }

  public function executeStatRevenue(sfWebRequest $request) {
    $days = $request->getParameter('d', 1);
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    $this->stats = Doctrine::getTable('UserScore')->getUserStats($this->user->id, $days);
    
    if ($request->hasParameter('d'))
    {
      $this->renderText(json_encode($this->stats));
      return sfView::NONE;
    }
  }

  public function executeUnfollow(sfWebRequest $request) {
    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      $this->renderText('{ "result":"login" }');
      return sfView::NONE;
    }

    if (!$request->isMethod('POST') || !$request->getParameter('id')) {
      $this->renderText('{ "result":"error", "text":"There was an error while trying to unfollow this user, please try again later" }');
      return sfView::NONE;
    }

    $user->getGuardUser()->unFollow($request->getParameter('id'));

    Doctrine::getTable('Badge')->decreaseBadgeStat('Sheep', $user->getGuardUser()->id);
    Doctrine::getTable('Badge')->decreaseBadgeStat('King', $request->getParameter('id'));

    $this->renderText('{ "result":"success", "text":"You have stopped following this user", "new_text":"unfollowed" }');
    return sfView::NONE;
  }

  public function executeFollowingUser(sfWebRequest $request) {
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    $this->following = Doctrine::getTable('FollowUserReference')->getUserData($this->user['id']);
    $this->items = Doctrine::getTable('UserAction')->getFollowingFeed($this->user->id, sfConfig::get('app_user_feed_num'), 0, $this->following['Following']);
    $this->next_page = 2;
    $this->feed_more_url = 'user_following_more';
  }

  public function executeFollowingUserMore(sfWebRequest $request) {
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    $this->following = Doctrine::getTable('FollowUserReference')->getUserData($this->user['id']);
    $this->items = Doctrine::getTable('UserAction')->getFollowingfeed(
            $this->user->id,
            sfConfig::get('app_user_feed_num'),
            sfConfig::get('app_user_feed_num') * ($request->getParameter('page')-1),
            $this->following['Following']
    );
    $this->next_page = $request->getParameter('page')+1;
    $this->feed_more_url = 'user_following_more';
    if ($request->isXmlHttpRequest())
      return $this->renderPartial('user/actionFeed', array(
        'items' => $this->items,
        'user' => $this->user,
        'next_page' => $this->next_page,
        'feed_more_url' => $this->feed_more_url
       ));
    else
      $this->setTemplate('followingUsers');
  }

  public function executeFollowingLimelight(sfWebRequest $request) {
    $this->user = $this->getRoute()->getObject();
    $this->following = Doctrine::getTable('FollowUserReference')->getUserData($this->user['id']);
    $this->following_limelights = Doctrine::getTable('FollowLimelightReference')->getUserData($this->user['id']);
    $this->items = Doctrine::getTable('Limelight')->getFollowingFeed($this->user->id, sfConfig::get('app_user_feed_num'), 0, $this->following_limelights['Following']);
    $this->next_page = 2;
    $this->feed_more_url = 'lime_following_more';
  }

  public function executeFollowingLimelightMore(sfWebRequest $request) {
    $this->user = $this->getRoute()->getObject();
    $this->following_limelights = Doctrine::getTable('FollowLimelightReference')->getUserData($this->user['id']);
    $this->items = Doctrine::getTable('Limelight')->getFollowingfeed(
            $this->user->id,
            sfConfig::get('app_user_feed_num'),
            sfConfig::get('app_user_feed_num') * ($request->getParameter('page')-1),
            $this->following_limelights['Following']
    );
    $this->next_page = $request->getParameter('page')+1;
    $this->feed_more_url = 'lime_following_more';
    if ($request->isXmlHttpRequest())
      return $this->renderPartial('user/actionFeed', array(
        'items' => $this->items,
        'user' => $this->user,
        'next_page' => $this->next_page,
        'feed_more_url' => $this->feed_more_url
       ));
    else
      $this->setTemplate('followingLimelights');
  }

  public function executeFavorited(sfWebRequest $request) {
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    $this->type = $request->getParameter('type', 'news');
    $this->order_by = $request->getParameter('order_by', 'favorite_date');
    $this->items = Doctrine::getTable('Favorite')->getUserFavoriteFeed($this->user->id, sfConfig::get('app_user_feed_num'), 0, $this->order_by, $this->type);
    $this->next_page = 2;
    $this->feed_more_url = 'user_favorited_more';
  }

  public function executeFavoritedMore(sfWebRequest $request) {
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    $this->type = $request->getParameter('type', 'news');
    $this->order_by = $request->getParameter('order_by', 'favorite_date');
    $this->items = Doctrine::getTable('Favorite')->getUserFavoriteFeed(
      $this->user->id,
      sfConfig::get('app_user_feed_num'),
      sfConfig::get('app_user_feed_num') * ($request->getParameter('page')-1),
      $this->order_by,
      $this->type
    );
    $this->next_page = $request->getParameter('page')+1;
    $this->feed_more_url = 'user_favorited_more';
    if ($request->isXmlHttpRequest())
      return $this->renderPartial('user/actionFeed', array(
        'items' => $this->items,
        'user' => $this->user,
        'next_page' => $this->next_page,
        'feed_more_url' => $this->feed_more_url,
        'type' => $this->type
      ));
    else
      $this->setTemplate('favorited');
  }

  public function executeSettings(sfWebRequest $request) {
    $this->user = Doctrine::getTable('sfGuardUser')->getUserByUsername($request->getParameter('username'));
    if (!$this->getUser()->isAuthenticated() || $this->getUser()->getGuardUser()->username != $this->user->username)
      return $this->redirect('user_show', array('username' => $this->user->username));
  }

  // ** Allow the user to redeem their current balance through paypal
  public function executePaypalClaimRedeem(sfWebRequest $request) {

    $user = $this->getUser();
    if (!$user->isAuthenticated())
    {
      $user->setFlash('error', 'You aren\'t logged in. You gotta login before you can do that!');
      $this->redirect('homepage');
    }

    $claim_amount = $user->getGuardUser()->getUserClaimAmount();
    if ($claim_amount <= 0)
    {
      $user->setFlash('error', 'You don\'t have any cash to redeem! Contribute interesting content to up your popularity score to make the top users list next distribution and earn cash!');
      $this->redirect('user_stat_revenue', array('username' => $user->getGuardUser()->username));
    }
    else if ($claim_amount < sfConfig::get('app_paypal_min_claim'))
    {
      $user->setFlash('error', 'The minimum required cash threshold is $'.sfConfig::get('app_paypal_min_claim').'. Earn that much and try again!');
      $this->redirect('user_stat_revenue', array('username' => $user->getGuardUser()->username));
    }

    //-------------------------------------------------
    // When you integrate this code
    // look for TODO as an indication
    // that you may need to provide a value or take action
    // before executing this code
    //-------------------------------------------------

    require_once (dirname(__FILE__).'/../../../../../config/paypalplatform.php');


    // ==================================
    // PayPal Platform Implicit Payment Module
    // ==================================

    // Request specific required fields
    $senderEmail		= "marc_1284088736_biz@techlimelight.com";				// TODO - The paypal account email address of the sender
                                                                                    // think of it as required for an implicit payment and
                                                                                    // set to the same account that owns the API credentials
    $actionType			= "PAY";
    $cancelUrl			= "https://NoOp";	// There is no approval step for implicit payment
    $returnUrl			= "https://NoOp";	// There is no approval step for implicit payment
    $currencyCode		= "USD";

    // An implicit payment can be a simple or parallel or chained payment
    // TODO - specify the receiver emails
    //        remove or set to an empty string the array entries for receivers that you do not have
    //        for a simple payment, specify only receiver0email, and remove the other array entries
    $receiverEmailArray	= array(
                            $user->getGuardUser()->Profile->email
                          );
    // TODO - specify the receiver amounts as the amount of money, for example, '5' or '5.55'
    //        remove or set to an empty string the array entries for receivers that you do not have
    //        for a simple payment, specify only receiver0amount, and remove the other array entries
    $claim_amount = ($claim_amount > sfConfig::get('app_paypal_max_claim')) ? sfConfig::get('app_paypal_max_claim') : $claim_amount;
    $receiverAmountArray = array(
                      $claim_amount
                    );

    // TODO - specify values ONLY if you are doing a chained payment
    //        if you are doing a chained payment,
    //           then set ONLY 1 receiver in the array to 'true' as the primary receiver, and set the
    //           other receivers corresponding to those indicated in receiverEmailArray to 'false'
    //           make sure that you do NOT specify more values in this array than in the receiverEmailArray
    $receiverPrimaryArray = array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                    );

    // TODO - Set invoiceId to uniquely identify the transaction associated with each receiver
    //        set the array entries with value for receivers that you have
    //		  each of the array values must be unique
    $receiverInvoiceIdArray = array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                    );

    // Request specific optional fields
    //   Provide a value for each field that you want to include in the request, if left as an empty string the field will not be passed in the request
    $feesPayer						= "";		// For an implicit payment use case, this cannot be "SENDER"
    $ipnNotificationUrl				= "";
    $memo							= "";		// maxlength is 1000 characters
    $pin							= "";		// No pin for an implicit payment use case
    $preapprovalKey					= "";		// No preapprovalKey for an implicit use case
    $reverseAllParallelPaymentsOnError	= "";				// Only specify if you are doing a parallel payment as your implicit payment
    $trackingId						= generateTrackingID();	// generateTrackingID function is found in paypalplatform.php

    //-------------------------------------------------
    // Make the Pay API call
    //
    // The CallPay function is defined in the paypalplatform.php file,
    // which is included at the top of this file.
    //-------------------------------------------------
    $resArray = CallPay ($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray,
                                                    $receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray,
                                                    $feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey,
                                                    $reverseAllParallelPaymentsOnError, $senderEmail, $trackingId
    );

    $ack = strtoupper($resArray["responseEnvelope.ack"]);
    Doctrine::getTable('Log')->newLog('paypal claim debug', print_r($resArray), $user->getGuardUser()->id, $_SERVER['REMOTE_ADDR']);
    if($ack=="SUCCESS")
    {
            // payKey is the key that you can use to identify the payment resulting from the Pay call
            $payKey = urldecode($resArray["payKey"]);
            // paymentExecStatus is the status of the payment
            $paymentExecStatus = urldecode($resArray["paymentExecStatus"]);

            $user->getGuardUser()->setUserClaimed($payKey);
            Doctrine::getTable('Badge')->increaseBadgeStat('$$$', $user->getGuardUser()->id);
            $user->setFlash('notice', 'Success! Your redeemed money has been sent to the email associated with your account via Paypal.
              Please give the email a little while to reach you. ('.$user->getGuardUser()->Profile->email.')');
    }
    else
    {
            //Display a user friendly Error on the page using any of the following error information returned by PayPal
            //TODO - There can be more than 1 error, so check for "error(1).errorId", then "error(2).errorId", and so on until you find no more errors.
            $ErrorCode = urldecode($resArray["error(0).errorId"]);
            $ErrorMsg = urldecode($resArray["error(0).message"]);
            $ErrorDomain = urldecode($resArray["error(0).domain"]);
            $ErrorSeverity = urldecode($resArray["error(0).severity"]);
            $ErrorCategory = urldecode($resArray["error(0).category"]);

            $message = 'Msg: '.$ErrorMsg.'. Code: '.$ErrorCode.'. Severity: '.$ErrorSeverity.'. Domain: '.$ErrorDomain.'. Category: '.$ErrorCategory;

            $user->setFlash('error', 'Oops, there was an error during the redeem process. Don\'t fret, your unclaimed balance hasn\'t changed and we\'re working on it. If this continues to happen please let us know.
              Thanks for your patience while we work out the kinks!');
            Doctrine::getTable('Log')->newLog('paypal claim error', $message, $user->getGuardUser()->id, $_SERVER['REMOTE_ADDR']);
    }

    $this->redirect('user_stat_revenue', array('username' => $user->getGuardUser()->username));
  }
}