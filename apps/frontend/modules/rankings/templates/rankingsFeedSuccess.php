{
"users" : [
<?php foreach($users as $key => $user): ?>
{
"id":"user_<?php echo $user['id'] ?>",
"change":"<?php echo (isset($user['user_score_increase']) ? $user['user_score_increase'] : '0') ?>",
"item":"<?php echo addcslashes(preg_replace('/\r?\n/m', '', get_partial('userItem', array('user' => $user, 'key' => $key))), '\"') ?>"
}
<?php if (isset($users[$key+1])): ?>
,
<?php endif; ?>
<?php endforeach; ?>
],
"limelights" : [
<?php foreach($limelights as $key => $ll): ?>
{
"id":"ll_<?php echo $ll['id'] ?>",
"change":"<?php echo (isset($ll['ll_score_increase']) ? $ll['ll_score_increase'] : '0') ?>",
"item":"<?php echo addcslashes(preg_replace('/\r?\n/m', '', get_partial('limelightItem', array('ll' => $ll, 'key' => $key))), '\"') ?>"
}
<?php if (isset($limelights[$key+1])): ?>
,
<?php endif; ?>
<?php endforeach; ?>
],
"news" : [
<?php foreach($newss as $key => $news): ?>
{
"id":"news_<?php echo $news['id'] ?>",
"change":"<?php echo (isset($news['news_score_increase']) ? $news['news_score_increase'] : '0') ?>",
"item":"<?php echo addcslashes(preg_replace('/\r?\n/m', '', get_partial('newsItem', array('news' => $news, 'key' => $key))), '\"') ?>"
}
<?php if (isset($newss[$key+1])): ?>
,
<?php endif; ?>
<?php endforeach; ?>
]
}