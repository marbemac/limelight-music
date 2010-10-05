<div id="lime_player_C" data-song_id="">

  <div class="lime_player_overlay">
    <?php echo image_tag('lime_player_choose_song.png') ?>
  </div>

  <div id="lime_player"></div>

  <div class="lp-single-player">
    <div class="lp-interface">
      <ul class="lp-controls">
        <li id="lplayer_play_pause" class="play"></li>
        <li><a href="#" id="lplayer_next" class="lp-next" tabindex="1"></a></li>
        <li><a href="#" id="lplayer_prev" class="lp-prev" tabindex="1"></a></li>
      </ul>
      <div id="lplayer_volume_bar" class="lp-volume-bar"></div>
      <div id="lplayer_volume_min" data-muted="0" data-vol="0" class="lp-volume-min" tabindex="1"></div>
      <div class="lp-progress">
        <a id="lp-song-title" href=""></a>
        <div id="lplayer_load_bar" class="lp-load-bar">
          <div id="lplayer_play_bar" class="lp-play-bar"></div>
        </div>
        <div id="lplayer_play_time" class="lp-play-time">00:00</div>
        <div id="lplayer_total_time" class="lp-total-time">00:00</div>
      </div>
    </div>

    <ul class="lp-interact">
      <li>
        <div></div>
      </li>
      <li>
        <div>share</div>
      </li>
      <li>
        <div class="favorite"></div>
      </li>
      <li>
        <div class="sb_song rnd_5">
          <div class="neg"></div>
          <div class="pos"></div>
          
        </div>
      </li>
    </ul>

    <div id="lplayer_playlist" class="lp-playlist">
      <ul>
        <li></li>
      </ul>
    </div>
  </div>

</div>