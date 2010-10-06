// ***** STUFF THAT HAS TO BE LOADED ON PAGE LOAD QUICKLY ***** //

// adjust the URL post page load
var $pathname = window.location.href.split('#');
if ($pathname.length == 1)
{
  $pathname = window.location.pathname.split('.php/');
  var $temp = $pathname[$pathname.length-1];
  var $path = window.location.href.split(window.location.pathname);
  $path = $path[0];
  if ($pathname.length > 1)
  {
    window.location.href = $path+$pathname[0]+'.php/'+'#'+$pathname[0]+'.php/'+$pathname[1];
  }
  else
  {
    window.location.href = $path+'/#'+$pathname[0];
  }
}

// ********************
// IMPORTANT, main site navigation ajax shit
// ********************
$.address.change(function(event) {
  $.ajax({
    type: "GET",
    url: event.value,
    beforeSend: function(request) {
      $('#site_loading').oneTime(400, function(){ $(this).show() }).text('loading...');
    },
    success: function(html) {
      $('#site_loading').stopTime().hide();
      $('#container').html(html);
      if($('#lime_player_C').metadata().id)
      {
        var $status = $('#lplayer_play_pause').hasClass('play') ? 'play' : 'pause';
        $('#song_'+$('#lime_player_C').metadata().id).addClass('playing').find('.song_play_pause').removeClass('play').addClass($status);
      }
      $('.ui-tooltip').remove();
    },
    error: function(request, status, error)
    {
      if (request.status == '404') {
        $('#site_loading').stopTime().hide();
        $('#container').html(request.responseText);
      }
      else if (request.status == '500')
      {
        $('#site_loading').text('Oops, there was an error! If this persists, please let us know.');
      }
    }
  });
});


$('a').live('click', function() {
    if ($(this).hasClass('xa'))
      return;

    $.address.value($(this).attr('href'));
    return false;
});

// END PRELOAD //

$(document).ready(function(){
  // ********************
  // SONGS
  // ********************

  // handle the news submission form
  var songSubmit = function()
  {
    var self = $('.song_add .submit');
    self.die('click').text('submitting...').addClass('submitting');
    var formData = {};

    $('h2.error').hide();
    $('.error_list').remove();

    // get the basic info
    formData[$('#songAdd_F #song_name').attr('name')] = $('#songAdd_F #song_name').val();
    formData[$('#songAdd_F #song_content').attr('name')] = $('#songAdd_F #song_content').val();
    formData[$('#songAdd_F #song_file').attr('name')] = $('#songAdd_F #song_file').val();
    formData[$('#songAdd_F #song__csrf_token').attr('name')] = $('#songAdd_F #song__csrf_token').val();

    // get the limelight info
    formData['limelights'] = {}
    $.each($('.limelight_add_C .on'), function(index, val) {
      formData['limelights'][index] = $(val).children('span.name').metadata().name;
    })

    $.post(self.metadata().url, formData, function(data) {
      if (data.result == 'error')
      {
        self.live('click.submit', songSubmit).text('submit song').removeClass('submitting');

        // handle the basic info errors
        $('.song_add .error_list').remove();
        $.each(data.info_error, function(index, val) {
          if ($(val).error != '')
          {
            $('#song_'+val.name).before(val.error);
          }
        })

        // handle the limelight errors
        if (data.limelight_error == true)
          $('#song_limelight').before('<ul class="error_list limelights"><li>You must select between 1 and 10 limelights. Selected limelights have a solid green border. Click on limelights to toggle between selected and deselected, or add new ones in the input box below. You currently have '+ $('.limelight_add_C .on, .tag_add_C .on').length +' limelights selected.</li></ul>').parent().parent().addClass('limelights');
        else
          $('#song_limelight').parent().parent().removeClass('limelights');

        // handle the file errors
        if (data.file_error == true)
          $('#song_add_file').after('<ul class="error_list file"><li>You must upload the song file!</li></ul>');

        $.scrollTo($('.song_add .dont'), 500, {onAfter:function() {
          $('h2.error').fadeIn(1000);
        }
        });
      }
      else if (data.result == 'success')
      {
        window.location = data.url;
      }
      else if (data.result == 'login')
      {
        self.live('click.submit', songSubmit).text('submit song').removeClass('submitting');
        authenticate();
      }
    }, 'json')
  };
  $('.song_add .submit').live('click.submit', songSubmit);

  // song add page file upload
  $('#song_add_file').livequery(function() {
    var $self = $(this);
    $('#song_file').val('');
    $self.uploadify({
      'uploader'    : '/js/uploadify/uploadify.swf',
      'script'      : $self.metadata().url,
      'auto'        : true,
      'fileDesc'    : 'mp3, mp4, aac, mpa, wma',
      'fileExt'     : '*.mp3;*.mp4;*.aac;*.mpa;*.wma',
      'buttonImg'   : '/images/song_add_choose_file.gif',
      'width'       : 278,
      'height'      : 40,
      'sizeLimit'   : 15000000,
      'buttonText'  : 'choose audio file',
      'onOpen'      : function(event,queueID,fileObj) {
        $('.song_add .item.song_upload .ajax_loader').fadeIn(400);
      },
      'onComplete'  : function(a,b,c,d) {
          $('..song_add .item.song_upload .ajax_loader').fadeOut(400);
        // hack to get around strange uploadify response data
        var data = d.split('$**$');
        data = JSON.parse(data[0]);
        if (data.result == 'error')
        {
          displayNotice(data.text, 0);
        }
        else
        {
          $('#song_file').val(data.fileName);
          $('#song_add_fileUploader').replaceWith('<div class="song_upload_success">' + data.realName + ' successfully uploaded!</div>');
        }
      }
    });
  });

  // ********************

  // ********************
  // JPLAYER
  // ********************

  $('#lime_player').jPlayer( {
    ready: function () {
      //this.element.jPlayer("setFile", "/uploads/songs/files/marry.mp3"); // Auto-Plays the file
    },
    customCssIds: true,
    nativeSupport: true,
    swfPath: "/js"
  })
  //.jPlayer("cssId", "play", "lplayer_play")
  //.jPlayer("cssId", "pause", "lplayer_pause")
  //.jPlayer("cssId", "stop", "lplayer_stop")
  //.jPlayer("cssId", "loadBar", "lplayer_load_bar")
  //.jPlayer("cssId", "playBar", "lplayer_play_bar")
  //.jPlayer("cssId", "volumeMin", "lplayer_volume_min")
  //.jPlayer("cssId", "volumeMax", "lplayer_volume_max")
  //.jPlayer("cssId", "volumeBar", "lplayer_volume_bar")
  //.jPlayer("cssId", "volumeBarValue", "lplayer_volume_bar_value");

  // Make the player
  // volume slider
  $("#lplayer_volume_bar").slider({
    value: 60,
    orientation: "horizontal",
    range: "min",
    min: 0,
    max: 100,
    animate: true
  });
  // progress slider
  $("#lplayer_play_bar").slider({
    value: 0,
    orientation: "horizontal",
    range: "min",
    min: 0,
    max: 100,
    animate: true
  });
  // END MAKE

  // Control the player upon interaction
  $("#lime_player").jPlayer("onProgressChange", function(lp,ppr,ppa,pt,tt) {
    $("#lplayer_play_time").text($.jPlayer.convertTime(pt));
    $("#lplayer_total_time").text($.jPlayer.convertTime(tt));
    $("#lplayer_play_bar").slider('value', ppa);
  });

  // control the volume slider
  $("#lplayer_volume_bar").slider({
    slide: function(event, ui) {
      $('#lplayer_volume_min').metadata().muted = 0;
      $("#lime_player").jPlayer("volume", ui.value);
    }
  });

  // control the mute button
  $('#lplayer_volume_min').live('click', function() {
    var $self = $(this);
    if ($self.metadata().muted == 0)
    {
      $self.metadata().muted = 1;
      $self.metadata().vol = $("#lplayer_volume_bar").slider('value');
      $("#lplayer_volume_bar").slider('value', 0);
      $("#lime_player").jPlayer("volume", 0);
    }
    else
    {
      $self.metadata().muted = 0;
      $("#lplayer_volume_bar").slider('value', $self.metadata().vol);
      $("#lime_player").jPlayer("volume", $self.metadata().vol);
    }
  })

  // control the progress slider
  $("#lplayer_play_bar").slider({
    slide: function(event, ui) {

      $(this).stopTime();

      var $item = $('#song_'+$('#lime_player_C').metadata().id);
      var $diag = $("#lime_player").jPlayer('getData', 'diag');
      $("#lime_player").jPlayer("playHeadTime", $diag.totalTime*(ui.value/100));

      // update the user song tracker session
      $(this).oneTime(200, function() {
        $.post($item.metadata().url, { 'status':'playing', 'progress_bar_change':true }, function(data) {
          $item.find('.song_play_pause').removeClass('play').addClass('pause');
          $('#lplayer_play_pause').removeClass('play').addClass('pause');
        });
      });
      
    }
  });

  // control the play/pause button on the player
  $('#lplayer_play_pause').live('click', function() {
    var $self = $(this);
    var $item = $('#song_'+$('#lime_player_C').metadata().id).find('.song_play_pause');
    var $status = $item.hasClass('play') ? 'playing' : 'paused';

    $.post($item.metadata().url, { 'status':$status }, function(data) {
    }, 'json');

    if ($self.hasClass('play'))
    {
      $item.removeClass('play').addClass('pause');
      $self.removeClass('play').addClass('pause');
      $('#lime_player').jPlayer('play');
    }
    else
    {
      $item.removeClass('pause').addClass('play');
      $self.removeClass('pause').addClass('play');
      $('#lime_player').jPlayer('pause');
    }
  })

  // control play/pause button on song feed items
  $('.song_play_pause').live('click', function() {
    var $self = $(this);
    var $item = $('#song_'+$self.metadata().id);
    var $status = $self.hasClass('play') ? 'playing' : 'paused';
    $('.lime_player_overlay').remove();

    $.post($self.metadata().url, { 'status':$status }, function(data) {
      if (data.result == 'error')
      {
        displayNotice(data.text, 0);
        return false;
      }

      if ($status == 'playing')
      {
        // do we need to load a new file?
        if ($('#lp-song-title').text() != $item.children('.name').text())
        {
          $('#lime_player').jPlayer('setFile', 'https://'+$('#sbucket').metadata().val+'/'+data.file_name);
          $('#lime_player_C').metadata().id = $self.metadata().id;
          $('#lp-song-title').text($item.children('.name').text()).attr('href', $item.children('.name').attr('href'));
          loadInteractButtons();
        }

        $('#lime_player').jPlayer('play');
        $('.song_play_pause').removeClass('pause').addClass('play');
        $self.removeClass('play').addClass('pause');
        $('#lplayer_play_pause').removeClass('play').addClass('pause');
        $('.feed.song.playing').removeClass('playing');
        $item.addClass('playing');
      }
      else if ($status == 'paused')
      {
        $('#lime_player').jPlayer('pause');
        $self.removeClass('pause').addClass('play');
        $('#lplayer_play_pause').removeClass('pause').addClass('play');
      }
    }, 'json');
  })

  // on song complete
  $("#lime_player").jPlayer("onSoundComplete", function() {
    var $self = $('#lime_player_C');
    var $item = $('#song_'+$self.metadata().id);
    $item.find('.song_play_pause').removeClass('pause').addClass('play');
    $('#lplayer_play_pause').removeClass('pause').addClass('play');
    $.post($('#lime_player').metadata().oncomplete_url, function() {});
  });

  function loadInteractButtons()
  {
    var $self = $('#lime_player_C');
    $.post($self.metadata().load_interact_url, { 'id':$self.metadata().id }, function(data) {
      $('.lp-interact').replaceWith(data);
    })
  }

  // END JPLAYER

  // updates the header every minute if we're logged in
  $(this).everyTime(60000, function() {
    if ($('#h_user_panel').length > 0) {
      $.ajax({
        type: 'GET',
        cache: false,
        url: $('#h_user_panel').metadata().rl,
        success: function(text) {
          $('#h_wrapper').replaceWith(text);
        }
      });
    }
  });

})