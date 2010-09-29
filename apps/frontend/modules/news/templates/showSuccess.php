<?php include_partial('content/layoutPart1'); ?>

<?php
  use_stylesheet('news.css');
  use_helper('Text');

  slot('title', $newsItem['title']);
  slot('sidebar0');
    include_partial('news/tagSidebar', array('tags' => $tags, 'tagForm' => $tagForm, 'tag_lock' => $newsItem['tag_lock'], 'item_id' => $newsItem['id']));
  end_slot();
?>

<input id="newsstory_id" disabled readonly type=hidden value="<?php echo $newsItem['id'] ?>" />
<input id="newsstory_title_slug" disabled readonly type=hidden value="<?php echo $newsItem['title_slug'] ?>" />

<div class="content_panel">
  <div id="n_head">
    <?php
    if ($newsItem['status'] == 'Active')
    {
      include_partial('content/scoreBox', array(
          'class' => 'news_'.$newsItem['id'],
          'score' => $newsItem['score'],
          'type' => 'sb_m',
          'target' => '.news_'.$newsItem['id'],
          'title' => 'rate this news story',
          'my' => 'top left',
          'at' => 'bottom center',
          'url' => url_for('news_rate_box', array('id' => $newsItem['id']))
        )
      );
    }
    ?>
    <div id="n_head_name"><?php echo link_to($newsItem['title'], $links[0]['source_url']) ?></div>
    <div id="n_locks">
      <?php if ($newsItem['tag_lock'] == 1): ?>
      <div class="lock_red tipBox" tipText="The add tags functionality of this news story has been locked by a moderator">T</div>
      <?php endif; ?>
    </div>
    <div class="clearLeft"></div>
  </div>

  <?php
  if ($newsItem['status'] == 'Flagged'):
    echo '<div class="ns_status_text">This news story has been flagged for review.</div>';
  elseif ($newsItem['status'] == 'Disabled'):
    echo '<div class="ns_status_text">This news story has been disabled.</div>';
  else:
  ?>

    <div id="n_infoBox" class="rndB_3">
      
      <div class="image"><?php echo image_tag(sfConfig::get('app_news_image_path') . '/small/' . $newsItem['news_image']); ?></div>
      <div class="n_infoItemFirst">
        submitted by
        <?php
        include_component('user', 'userLink', array(
        'user_id'        => $newsItem['user_id'],
        'show_score'     => true,
        'pos'            => 'top',
        ));
        ?>
      </div>
      <div class="n_infoItem"><b>Top Source</b> <span id="n_ii1"><?php echo link_to($links[0]['Source']['name'], $links[0]['source_url']) ?></span></div>
      <div class="n_infoItem"><b>Submitted</b> <span id="n_ii2"><?php echo LimelightUtils::timeLapse($newsItem['created_at']) ?></span></div>

      <div class="n_infoItem">
        <b>Limelights</b>
        <div id="n_ii3">
          <?php
          include_component('limelight', 'limelightLink', array(
            'id'           => $newsItem['Limelights'][0]['id'],
            'pic'          => true
          ));
          if (count($newsItem['Limelights']) > 1) {
            for ($i = 1; $i < count($newsItem['Limelights']); $i++) {
              include_component('limelight', 'limelightLink', array(
                'id'           => $newsItem['Limelights'][$i]['id'],
                'pic'          => true
              ));
            }
          }
          ?>
        </div>
      </div>
      <div class="n_infoItem"><b>Daily views</b> <span id="n_ii6"><?php echo $newsItem['daily_views'] ?></span></div>
      <div class="n_infoItem"><b>Total views</b> <span id="n_ii7"><?php echo $newsItem['total_views'] ?></span></div>
    </div>

    <div id="n_content">
      <span id="via">via</span> <b><?php echo link_to($links[0]['Source']['name'], $links[0]['source_url']) ?></b> - <?php echo $newsItem['content'] ?>
      <div id="ns_options">
        <?php
        include_partial('content/flagButton', array(
            'class' => 'news_flag_'.$newsItem['id'],
            'type' => 'fb_m',
            'target' => '.news_flag_'.$newsItem['id'],
            'title' => 'flag this news story',
            'my' => 'bottom center',
            'at' => 'top center',
            'text' => 'flag',
            'url' => url_for('news_flag_box', array('id' => $newsItem['id']))
          )
        );
        include_partial('shareNews', array('item' => $newsItem));
        include_partial('content/favoriteButton', array(
            'class' => 'news_favorite_'.$newsItem['id'],
            'type' => 'favb_m',
            'target' => '.news_favorite_'.$newsItem['id'],
            'title' => 'favorite this news story',
            'my' => 'bottom center',
            'at' => 'top center',
            'text' => 'favorite',
            'url' => url_for('news_favorite_box', array('id' => $newsItem['id']))
          )
        );
        include_partial('content/disable', array('item' => $newsItem, 'url' => 'news_disable'));

        if ($newsItem['tag_lock'] == 0)
          include_partial('content/lockFunction', array('item' => $newsItem, 'url' => 'news_tag_lock', 'lock_text' => 'lock tags'));
        else if ($newsItem['tag_lock'] == 1)
          include_partial('content/lockFunction', array('item' => $newsItem, 'url' => 'news_tag_lock', 'lock_text' => 'unlock tags'));
        ?>
      </div>
      <div class="clearLeft"></div>
      <div class="extra_links rnd_3">
        <h3 title="if an additional news source has an article on this story topic, link it here">who's talking about it</h3>
        <span class="new_link <?php echo $sf_user->isAuthenticated() ? 'blind' : 'authenticate' ?> rnd_3" blindElem="linkForm" blindText="- hide link form">+ add a new link</span>
        <form id="linkForm" class="rnd_3 hide" action="<?php echo url_for('news_link_add', array('item_id' => $newsItem['id'])) ?>">
          <?php echo $linkForm['source_name']->renderRow(array('autocomplete' => 'off')) ?>
          <?php echo $linkForm['source_url']->renderRow() ?>
          <?php echo $linkForm['_csrf_token']->render() ?>
          <input class="submit" type="submit" value="submit link" />
        </form>
        <ul>
          <?php foreach ($links as $key => $link): ?>
          <li><?php include_partial('news/link', array('pos' => $key+1, 'link' => $link, 'link_count' => count($links))) ?></li>
          <?php endforeach ?>
        </ul>
        <div class="clear"></div>
      </div>
      <?php include_component('news', 'chartScoreView', array('id' => $newsItem['id'], 'sf_cache_key' => $newsItem['id'])) ?>
    </div>

    <?php
    include_component('comment', 'showComments', array(
        'type'         => 'News',
        'item'         => $newsItem,
        'sf_cache_key' => 'comments_News_'.$newsItem['id'].'-'.$user
      ));
    ?>
  <?php endif ?>
</div>

<?php include_partial('content/layoutPart2'); ?>