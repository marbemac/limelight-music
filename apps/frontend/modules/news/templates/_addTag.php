<form id="newsTagF" class="hide" action="<?php echo url_for('news_tag_add', array('news_id' => $item_id)) ?>">
  <div class="form_error"><?php echo $form['name']->renderError() ?></div>
  <?php echo $form['name']->render(array('class' => 'hide', 'data-url' => url_for('populate_tags_tbl'))) ?>
  <input type="submit" value="add it" class="small_button rnd_3" />
</form>