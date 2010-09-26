<form id="<?php echo isset($form_id) ? $form_id : '' ?>" class="comment_add_F" action="<?php echo url_for('comment_add', array('type' => $type, 'item_id' => $item_id, 'parent_id' => $parent_id)) ?>">
  <?php echo $form['content']->renderError(array('class' => 'error')) ?>
  <?php echo $form['content']->render(array('class' => 'length_counter', 'lengthIndicator' => '#add_comment_length_'.$parent_id, 'maxlength' => '2000')) ?>
  <div id="add_comment_length_<?php echo $parent_id ?>" class="counter"><span>0</span>/<?php echo sfConfig::get('app_comment_max_length') ?></div>
  <input type="submit" value="submit comment" class="submit medium_button" />
  <?php echo $form->renderHiddenFields() ?>
</form>