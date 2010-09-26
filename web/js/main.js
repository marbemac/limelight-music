// ***** STUFF THAT HAS TO BE LOADED ON PAGE LOAD QUICKLY ***** //

// turn on the expanders when the page is loaded if any of its children are selected
$('.categories_filter li.on').find('li, .expander').addClass('on');
$('.categories_filter li.on').parents('.child1, .child2').prev().addClass('on');

// move the limelight head profile image overlays
if ($('#ll_head_image').length > 0)
{
  var $left = $('#ll_head_image img').position().left;
  var $right = $('#ll_head_image img').position().left+$('#ll_head_image img').width()-8;
  $('#ll_head_image .left').css('left', $left);
  $('#ll_head_image .right').css('left', $right);
}
// END PRELOAD //

$(document).ready(function(){

  $.metadata.setType("html5");

  // When is a user considered idle? 2 minutes
  // $.idleTimer(120000);

  // ********** BETA SPLASH PAGE *********** //
  $('#beta_email').focus();
  $('#beta_blog').fadeIn(2000);
  $('#beta_store_email').click(function() {submitBetaEmail()});
  $('#beta_email').keyup(function(e) {
    if(e.keyCode == 13) {
      submitBetaEmail();
    }
  })
  $('#beta_access_code').click(function() {$(this).val('')});
  $('#beta_access').click(function() {betaAccess()});
  $('#beta_access_code').keyup(function(e) {
    if(e.keyCode == 13) {
      betaAccess();
    }
  })
  function submitBetaEmail()
  {
    var $email = $('#beta_email').val();
    if ($.trim($email).length > 0)
    {
      $.post($('#beta_store_email').metadata().url, {'email':$email}, function(data) {
        $('#beta_email').blur().css('background-color', 'green', 1000).css('cursor', 'default');
        var $img = $('#beta_info img').clone();
        $('#beta_info').html('Thanks for expressing interest! We\'ll notify you as soon as a beta spot is available.').css({'background-color':'#E7FDDF', 'border-color':'green'}, 1000).prepend($img);
      }, 'json');
    }
    else
    {
      $('#beta_email').val('').effect('shake', {times:2}, 50).effect('highlight', {'color':'orange'}, 900, function() {$(this).focus();});
    }
  }
  function betaAccess()
  {
    var $pass = $('#beta_access_code').val();
    $.post($('#beta_access').metadata().url, {'p':$pass}, function(data) {
      if (data.result == 'success')
      {
        $('#beta_access_code').blur().css('background-color', 'green', 1000);
        window.location.reload();
      }
      else
      {
        $('#beta_access_code').val('').effect('shake', {times:2}, 50).effect('highlight', {'color':'orange'}, 900, function() {$(this).focus();});
      }
    }, 'json');
  }

  $('#beta_switchers li:not(.t)').click(function() {
    var $self = $(this);
    if ($self.hasClass('inactive'))
    {
      displayNotice('We haven\'t released this feature yet. Check back often or follow us on twitter and facebook for the latest updates!', 1);
      $('#beta_features .feature.on').effect('shake', {times:2}, 30);
      return;
    }
    
    $('#beta_switchers li.on').removeClass('on', 200);
    $self.addClass('on', 200);

    $('#beta_features img.on').fadeOut(300, function() {
      $(this).removeClass('on');
      $($self.metadata().target).fadeIn(300).addClass('on');
    })
  })
  // ********** END BETA SPLASH  *********** //

  // tips
  $('.feed.news .stat_box ul img[title]').livequery(function() {$(this).qtip({style: {classes: 'ui-tooltip-shadow ui-tooltip-green', textAlign: 'center'}, position: {my: 'bottom center', at: 'top center'}})})
  $('#h_notification_num[title], #h_score[title], .sidebar_tip[title], .following .user_action[title]').livequery(function() {$(this).qtip({style: {classes: 'ui-tooltip-shadow ui-tooltip-green', tip: true, textAlign: 'center'}, position: {my: 'right center', at: 'left center'}})});
  $('.h_badges span[title]').livequery(function() {$(this).qtip({style: {classes: 'ui-tooltip-shadow ui-tooltip-green', tip: true, textAlign: 'center'}, position: {my: 'top right', at: 'bottom center'}})});
  $('.notification_clear_all[title], .notification_delete[title], .badges .name[title], .user_feed_item .icon[title], #tags_t[title]').livequery(function() {$(this).qtip({style: {classes: 'ui-tooltip-shadow ui-tooltip-green', tip: true, textAlign: 'center'}, position: {my: 'left center', at: 'right center'}})});
  $('.badges .in_progress[title], .badges .complete[title], .interactPosButton[title], .extra_links h3[title]').livequery(function() {$(this).qtip({style: {classes: 'ui-tooltip-shadow ui-tooltip-green', tip: true, textAlign: 'center'}, position: {my: 'bottom center', at: 'top center'}})});
  $('.user_stats li[title]').livequery(function() {$(this).qtip({style: {classes: 'ui-tooltip-shadow ui-tooltip-green', tip: true, textAlign: 'center'}, position: {my: 'bottom left', at: 'top center'}})});
  $('.interactedButton[title]').livequery(function() {$(this).qtip({style: {classes: 'ui-tooltip-shadow ui-tooltip-light', tip: true, textAlign: 'center'}, position: {my: 'bottom center', target: 'top center'}, hide: {fixed: true}})});
  $('.user_link a, .wiki_segment_name').livequery(function() {
    $(this).each(function() {
      var self = $(this);
      self.qtip({
         content: {
           text: 'Loading...',
            ajax: {
              once: true,
              url: self.metadata().url,
              type: 'get'
            }
         },
         style: {classes: 'ui-tooltip-shadow ui-tooltip-'+self.metadata().type, tip: true},
         position: {
            my: self.metadata().my,
            at: self.metadata().at
         },
         hide: {fixed: self.metadata().fixed}
      })
    })
  })

  // **********
  // FILTERS
  // **********
  $('.source .more_button').livequery(function() {
    $(this).qtip({
      content: { 
        text: $(this).next()
      },
      style: {classes: 'ui-tooltip-shadow ui-tooltip-blue', tip: true, textAlign: 'center'}, 
      position: {my: 'bottom center', at: 'top center'}, 
      hide: {fixed: true}
    })
  })
  $('.filter_item').livequery(function() {
    $(this).each(function() {
      var self = $(this);
      self.qtip({
         content: {
           text: self.next().text()
         },
         style: {classes: 'ui-tooltip-shadow ui-tooltip-'+self.metadata().type, tip: true},
         position: {
            my: self.metadata().my,
            at: self.metadata().at
         },
         hide: {fixed: self.metadata().fixed}
      })
    })
  })

  // **********
  // FILTERS
  // **********
  $('.filter_item').livequery(function() {
    $(this).each(function() {
      var self = $(this);
      self.qtip({
         content: {
           text: self.next().text()
         },
         style: {classes: 'ui-tooltip-shadow ui-tooltip-'+self.metadata().type, tip: true},
         position: {
            my: self.metadata().my,
            at: self.metadata().at
         },
         hide: {fixed: self.metadata().fixed}
      })
    })
  })

  // **********
  // FLAGGING
  // **********
  $('.fb_t:not(.loaded), .fb_s:not(.loaded), .fb_m:not(.loaded)').live('click', flagBox);
  function flagBox(event)
  {
    var self = $(event.target);
    $.get(self.metadata().url, function(data) {
      if (data.result == 'success')
      {
        var html;
        if (data.flagged === null)
        {
          html = '<div class="flagBox" data-url="'+data.url+'" data-target="'+self.metadata().target+'">';
          var count;
          $.each(data.box_values, function(i, val) {
            count = '';
            if (i == 0)
              count = 'first';
            else if (i == data.box_values.length-1)
              count = 'last';
            html += '<div class="flag '+count+'">'+val+'</div>';
          })
          html += '</div>';
        }
        else
        {
          html = '<div class="flagBox">';
          html += '<h6>'+data.flagged+'</h6>';
          html += '</div>';
        }
        self.qtip({
           content: {text: html},
           style: {classes: 'ui-tooltip-shadow ui-tooltip-red', tip: true},
           position: {
              my: self.metadata().my,
              at: self.metadata().at,
              adjust: {
                screen: 'fit'
              }
           },
           hide: {delay: 500,fixed: true}
        })
        self.addClass('loaded').qtip('show');
      }
      else if (data.result == 'error')
      {
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
  }

  // submit the flag
  $('.flagBox .flag').live('click', doFlag);
  function doFlag(event) {
    var self = $(event.target);
    self.die('click', doFlag);
    $.post(self.parent().metadata().url, {'type':self.text()}, function(data) {
      if (data.result == 'success')
      {
        self.switchClass('flag', 'flagged', 500).parent().children('.flag:not(.flagged)').switchClass('flag', 'notflagged', 500);
        $(self.parent().metadata().target).addClass('flagged');
      }
      else if (data.result == 'error')
      {
        self.parent().html('<h5>'+data.text+'</h5>');
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
  }
  // END FLAGGING

  // **********
  // FOLLOWING
  // **********
  $('.followButton:not(.loaded)').live('click', function(e) {followBox(e);});
  function followBox(event)
  {
    var self = $(event.target);
    $.get(self.metadata().url, function(data) {
      if (data.result == 'success')
      {
        var html;
        html = '<div class="followBox" data-url="'+data.url+'" data-target="'+self.metadata().target+'">';
        html += '<h6 class="rnd_2">'+data.value+'</h6>';
        html += '</div>';
        self.qtip({
           content: {text: html},
           style: {classes: 'ui-tooltip-shadow ui-tooltip-green', tip: true},
           position: {
              my: self.metadata().my,
              at: self.metadata().at,
              adjust: {
                screen: 'fit'
              }
           },
           hide: {delay: 500,fixed: true}
        })
        self.addClass('loaded').qtip('show');
      }
      else if (data.result == 'error')
      {
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
  }

  // submit the follow/unfollow command
  $('.followBox h6').live('click', doFollow);
  function doFollow(event) {
    var self = $(event.target);
    self.die('click', doFollow);
    $.post(self.parent().metadata().url, function(data) {
      if (data.result == 'success')
      {
        $(self.parent().metadata().target).qtip('destroy');
        $(self.parent().metadata().target).addClass('follow_changed').text('updated');
        displayNotice(data.text, 1);
      }
      else if (data.result == 'error')
      {
        self.parent().html('<h5>'+data.text+'</h5>');
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
  }
  // END FOLLOWING

  // **********
  // FAVORITE
  // **********
  $('.favoriteButton:not(.loaded)').live('click', followBox);
  function favoriteBox(event)
  {
    var self = $(event.target);
    $.get(self.metadata().url, function(data) {
      if (data.result == 'success')
      {
        var html;
        html = '<div class="favoriteBox" data-url="'+data.url+'" data-target="'+self.metadata().target+'">';
        html += '<h6 class="rnd_2">'+data.value+'</h6>';
        html += '</div>';
        self.qtip({
           content: {text: html},
           style: {classes: 'ui-tooltip-shadow ui-tooltip-green', tip: true},
           position: {
              my: self.metadata().my,
              at: self.metadata().at,
              adjust: {
                screen: 'fit'
              }
           },
           hide: {delay: 300,fixed: true}
        })
        self.addClass('loaded').qtip('show');
      }
      else if (data.result == 'error')
      {
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
  }

  // submit the follow/unfollow command
  $('.favoriteBox h6').live('click', doFavorite);
  function doFavorite(event) {
    var self = $(event.target);
    self.die('click', doFavorite);
    $.post(self.parent().metadata().url, function(data) {
      if (data.result == 'success')
      {
        $(self.parent().metadata().target).qtip('destroy');
        $(self.parent().metadata().target).addClass('favorite_changed').text('updated');
        displayNotice(data.text, 1);
      }
      else if (data.result == 'error')
      {
        self.parent().html('<h5>'+data.text+'</h5>');
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
  }
  // END FAVORITE

  // **********
  // SCORING
  // **********
  // load the rateBox
  $('.sb_t:not(.loaded), .sb_s:not(.loaded), .sb_m:not(.loaded), .sb_l:not(.loaded)').live('click', rateBox);
  function rateBox(event)
  {
    var self = $(event.target);
    $.get(self.metadata().url, function(data) {
      if (data.result == 'success')
      {
        var html = '';
        if (data.scored === null)
        {
          html += '<div class="rateBox" data-target="'+self.metadata().target+'">';
          html += '<div class="pos unscored rnd_3" data-url="'+data.rate_up_url+'">'+data.rate_up_img + data.box_values.pos+'</div>';
          html += '<div class="neg unscored rnd_3" data-url="'+data.rate_down_url+'">'+data.rate_down_img + data.box_values.neg+'</div>';
          html += '</div>';
        }
        else
        {
          html += '<div class="scoredBox">';
          if (data.scored >= 0)
            html += '<div class="pos">'+data.box_values.pos_voted+'</div>';
          else
            html += '<div class="neg">'+data.box_values.neg_voted+'</div>';
          html += '</div>';
        }
        self.qtip({
           content: {text: html},
           style: {classes: 'ui-tooltip-shadow ui-tooltip-green', tip: true},
           position: {
              my: self.metadata().my,
              at: self.metadata().at,
              adjust: {
                screen: 'fit'
              }
           },
           hide: {delay: 500,fixed: true}
        })
        self.addClass('loaded').qtip('show');
      }
      else if (data.result == 'error')
      {
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
  }

  // submit the score
  $('.rateBox .pos.unscored, .rateBox .neg.unscored').live('click', doScore);
  function doScore(event) {
    var self = $(event.target);
    self.die('click', doScore);
    $.post(self.metadata().url, function(data) {
      if (data.result == 'success')
      {
        if (self.hasClass('pos'))
        {
          self.animate({backgroundColor: '#93B41F'}, 500).removeClass('unscored').addClass('on');
          self.next().fadeTo(500, .25).removeClass('unscored').css('background-color', '#fff');
        }
        else
        {
          self.animate({backgroundColor: '#B02C28'}, 500).removeClass('unscored').addClass('on');
          self.prev().fadeTo(500, .25).removeClass('unscored').css('background-color', '#fff');
        }
        // update the target score
        $(self.parent().metadata().target).each(function(i,val) {
          $(val).text(parseInt($(val).text())+data.amount);
        })
        // update the user score, if applicable
        if (data.user_id)
        {
          $('.user_link_'+data.user_id+' .score').each(function(i,val) {
            $(val).text(parseInt($(val).text())+data.amount);
          })
        }
      }
      else if (data.result == 'error')
      {
        self.parent().html('<h5>'+data.text+'</h5>');
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
  }

  // **********
  // AUTOCOMPLETES
  // **********

  // sources autocomplete
  $('.source_name').focus(function() {
    var self = $(this);
    if (self.metadata().searchloaded == 0)
    {
      $.get(self.metadata().searchahead, function(data) {
        self.autocomplete(data, {
          minChars: 0,
          max: 10,
          matchContains: true,
          selectFirst: false
        });
        self.metadata().searchloaded = true;
      }, 'json');
    }
  });

  // specifications autocomplete
  $('#specification_content').focus(function() {
    var self = $(this);
    if (self.metadata().searchloaded == 0)
    {
      $.get(self.metadata().searchahead, function(data) {
        self.autocomplete(data, {
          minChars: 0,
          max: 10,
          matchContains: true,
          selectFirst: false
        });
        self.metadata().searchloaded = true;
      }, 'json');
    }
  });

  // specifications autocomplete
  $('#limelight_procon_name').focus(function() {
    var self = $(this);
    if (self.metadata().searchloaded == 0)
    {
      $.get(self.metadata().searchahead, function(data) {
        self.autocomplete(data, {
          minChars: 0,
          max: 30,
          matchContains: true,
          selectFirst: false
        });
        self.metadata().searchloaded = true;
      }, 'json');
    }
  });

  // tags autocomplete
  $('.tag_name').focus(function() {
    var self = $(this);
    if (self.metadata().searchloaded == '0')
    {
      $.get(self.metadata().searchahead, function(data) {
        self.autocomplete(data, {
          minChars: 0,
          max: 10,
          matchContains: true,
          selectFirst: false
        });
        self.metadata().searchloaded = 1;
      }, 'json');
    }
  });
  // END AUTOCOMPLETE

  // ***********
  // LINKS
  // ***********

  // news links form submission
  $('#n_content > .extra_links > form').live('submit', function() {
    var self = $(this);
    var fields = self.serializeArray();
    $.post(self.attr('action'), fields, function(data) {
      if (data.result == 'success') {
        self.children('input:first').focus()
        self.parent().find('ul').append('<li><span class="count rnd_2">'+($('#n_content > .extra_links > ul > li').length+1)+'</span><a href="'+fields[1].value+'">'+fields[0].value+'</a></li>');
        self.children('input:text').val('');
      }
      else if (data.result == 'error')
        displayNotice(data.text, 0);
      else if (data.result == 'login')
        authenticate();
      else
        displayNotice('There was an error adding this news link. We are working hard to fix the problem, please try again later.', 0);
    }, 'json')
    return false;
  })
  // END LINKS

  // ***********
  // TAGS
  // ***********

  $('#newsTagF').live('submit', function() {
    var self = $(this);
    $.post(self.attr('action'), self.serializeArray(), function(data) {
      if (data.result == 'success')
      {
        $('.tag_list').append('<li><span class="tag rnd_3">'+data.name+'</span></li');
        self.children('.tag_name').val('');
      }
      else if (data.result == 'error')
      {
        self.children('.error_list, .error').remove();
        if (data.info_error)
        {
          $.each(data.info_error, function(index, val) {
            if ($(val).error != '')
            {
              self.prepend(val.error);
            }
          })
        }

        if (data.text)
        {
          self.prepend('<div class="error">'+data.text+'</div>');
        }
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json')
    return false;
  })

  // ***********
  // FEED
  // ***********

  $('.filter_group div,.filter_group a').click(function() {
    var $self = $(this);
    $self.addClass('on', 200).siblings().removeClass('on', 200);
    $('#feed_reload').metadata().reload = 1;
    showFeedUpdateText();
    if ($self.parent().hasClass('sort_by'))
    {
      if ($self.hasClass('created'))
        $('.filter_group.time_period').fadeOut(150).prev().fadeOut(150);
      else
        $('.filter_group.time_period').fadeIn(150).prev().fadeIn(150);
    }
    return false;
  })

  // ***********
  // CATEGORY RIBBON
  // ***********
  $('.categories_filter .expander').hover(function() {
    var $self = $(this);
    $self.stopTime('category_menu').addClass('hovering').next().fadeIn(100);
  },
  function() {
    var $self = $(this);
    $self.oneTime(400, 'category_menu', function() {
      $self.removeClass('hovering').next().fadeOut(100);
    })
  })
  $('.categories_filter ul').hover(function() {
    var $self = $(this);
    $self.prev().stopTime('category_menu');
  },
  function() {
    var $self = $(this);
    $self.prev().oneTime(400, 'category_menu', function() {
      $self.fadeOut(100).prev().removeClass('hovering');
    })
  })
  $('.cat_all').click(function() {
    var $self = $(this);
    if ($self.hasClass('on'))
      return false;

    $self.addClass('on');
    $('.categories_filter li, .categories_filter .expander').removeClass('on');

    var catBack = $('.cat_back');
    if (catBack.length > 0)
    {
      var type = (catBack.metadata().type) ? catBack.metadata().type : 'news';
      var category = $self.metadata().value;
      feedReload(type, category);
      return false;
    }

    // if we're on the main feed page
    if ($('#main_feed').length > 0)
    {
      $('#feed_reload').metadata().reload = 1;
      showFeedUpdateText();
      return false;
    }
  })
  $('.categories_filter li .name').click(function() {
    var $self = $(this).parent(); // the li
    var on = $self.hasClass('on') ? true : false;

    if (on)
      $self.removeClass('on').find('li, .expander').removeClass('on');
    else
      $self.addClass('on').find('li, .expander').addClass('on');

    var siblingsOnCount = $self.siblings('li.on').length;
    var siblingsCount = $self.siblings('li').length;
    if (siblingsOnCount == 0 && !$self.hasClass('on'))
    {
      $('.cat_all').addClass('on');
      $self.parent().siblings().removeClass('on').parent().parent().prev().removeClass('on');
    }
    else
    {
      $('.cat_all').removeClass('on');
      $self.parent().prev('.expander').addClass('on').parent().parent().prev('.expander').addClass('on');
    }

    if (siblingsOnCount == siblingsCount && $self.hasClass('on'))
    {
      var $parent = $self.parent().parent();
      $parent.addClass('on');
      if ($parent.siblings('li.on').length == $parent.siblings('li').length)
      {
        var $parentParent = $parent.parent().parent();
        $parentParent.addClass('on');
        if ($parentParent.siblings('li.on').length == $parentParent.siblings('li').length)
        {
          $('.categories_filter').find('li, .expander').removeClass('on');
          $('.cat_all').addClass('on');
        }
      }
    }
    else if (siblingsOnCount == siblingsCount && !$self.hasClass('on'))
    {
      $self.parent().parent().removeClass('on').parent().parent().removeClass('on');
    }

    if ($('.categories_filter li.on').length == 0)
    {
      $('.cat_all').addClass('on');
    }

    // if we're goin back to the main feed
    var catBack = $('.cat_back');
    if (catBack.length > 0)
    {
      var type = (catBack.metadata().type) ? catBack.metadata().type : 'news';
      var category = $self.metadata().value;
      feedReload(type, category);
      return false;
    }
    
    // if we're on the main feed page
    if ($('#main_feed').length > 0)
    {
      $('#feed_reload').metadata().reload = 1;
      showFeedUpdateText();
      return false;
    }
  })
  // END CATEGORIES CHOOSER

  $('.filter_group').hover(function() {
    var $self = $(this);
    $self.find('a.on, div.on').after($self.find('a:not(.on), div:not(.on)'));
    $self.addClass('on');
    $self.find('a:not(.on), div:not(.on, .filler)').show();
  },
  function() {
    var $self = $(this);
    $self.removeClass('on');
    $self.find('a:not(.on), div:not(.on, .filler)').hide();
    initiateFeedReload();
  })

  function showFeedUpdateText()
  {
    if ($('#feed_reload_text').length == 0)
    {
      $('.feed_filter').after('<div id="feed_reload_text" class="rnd_3">filters updated, move mouse off of categories / filters \n\
                              areas when finished choosing options to update feed</div>');
      $('#feed_reload_text').fadeIn(1000);
    }
  }

  $('.categories_filter, .cat_all').hover(function() {
    $('#feed_reload').stopTime('feed_reload');
  },
  function() {
    initiateFeedReload();
  })

  function initiateFeedReload()
  {
    if ($('#feed_reload').metadata().reload == 1)
    {
      $('#feed_reload').oneTime(500, 'feed_reload', function() {
        var filters = {};
        filters['feed_type'] = $('.filter_group.feed_type .on').metadata().value;
        filters['sort_by'] = $('.filter_group.sort_by .on').metadata().value;
        filters['time_period'] = $('.filter_group.time_period .on').metadata().value;
        filters['categories'] = [];
        $('.categories_filter li.on').each(function(index,val) {
          filters['categories'][index] = $(val).metadata().value;
        })

        $('#feed_reload_text').text('reloading feed...');
        $.get($('#feed_reload').metadata().url, filters, function(data) {
          $('#feed_reload_text').fadeOut(1000, function() {$(this).remove()});
          $('#main_feed').fadeOut(150, function() {$(this).html(data).fadeIn(200)});
        })
        $('#feed_reload').metadata().reload = 0;
      })
    }
  }

  // this gets called when a user clicks on a category when not already on the main feed
  function feedReload(type, category)
  {
    var filters = {};
    filters['feed_type'] = type;
    filters['sort_by'] = 'popularity'
    filters['time_period'] = 1;
    filters['categories'] = [];
    filters['categories'][0] = category;

    $.get($('#feed_reload').metadata().url, filters, function(data) {
      window.location = $('#feed_reload').metadata().url;
    })
  }

  // ***********
  // DATA FILTERS
  // ***********
  $('.filters > .show:not(on, head)').live('click', function() {
    var self = $(this);
    $($('.filters > li.on').removeClass('on').metadata().target).removeClass('on').addClass('off').children().removeClass('on');
    $(self.addClass('on').metadata().target).removeClass('off').addClass('on').children(':nth-child(2)').addClass('on');
    $($(self.metadata().target).metadata().target).load($(self.metadata().target).children(':nth-child(2)').metadata().url);
  })
  $('.filter_sort_by > li:not(on)').live('click', function() {
    var self = $(this);
    self.parent().children('li').removeClass('on');
    self.addClass('on');
    $(self.parent().metadata().target).load(self.metadata().url);
  })
  // END DATA FILTERS

  // user actions (actions that simply require a user to click a button and do something
  // requires 'data-url' attribute on element that holds the url to the action
  // optional data-redirect attribute in on element if page should be re-directed
  // expects data to be returned in json format
  // result with either 'success', 'error', or 'login'
  // new_text with string to be displayed to the user
  $('.user_action').live('click', function() {
    var self = $(this);
    if (self.attr('data-redirect'))
      self.html('wait..').css({"cursor":"pointer"});
    $.post(self.attr('data-url'), function(data) {
      if(data.result == 'success') {
        if (self.attr('data-redirect'))
        {
          document.location.href = self.attr('data-redirect');
        }
        else
        {
          displayNotice(data.text, 1);
          self.text(data.new_text).removeClass('user_action');
          if (self.hasClass('interactPosButton'))
            self.removeClass('interactPosButton').addClass('interactedButton').qtip('destroy');
        }
      } else if (data.result == 'error') {
        displayNotice(data.text, 0);
      }else if (data.result == 'login') {
        authenticate();
      }
    }, 'json');
    return false;
  })
  // mod actions
  $('.mod_action').live('dblclick', function() {
    var self = $(this);
    $.post(self.metadata().url, function(data) {
      if(data.result == 'success') {
        displayNotice(data.text, 1);
        self.text(data.new_text).die('dblclick');
      } else if (data.result == 'error') {
        displayNotice(data.text, 0);
      } else if (data.result == 'login') {
        authenticate();
      }
    }, 'json');
    return false;
  })

  // user actions that delete something
  $('.user_action_delete').live('click', function() {
    var self = $(this);
    $.post(self.metadata().url, function(data) {
      if(data.result == 'success') {
        displayNotice(data.text, 1);
        $('#'+self.metadata().remove_id).hide(200, function() {$(this).remove()} );
      } else if (data.result == 'error') {
        displayNotice(data.text, 0);
      } else if (data.result == 'login') {
        authenticate();
      }
    }, 'json');
    return false;
  })

  // user notification delete
  $('.notification_clear_all, .notification_delete').live('click', function() {
    var self = $(this);
    $.post($(this).attr('href'), function() {
      if (self.hasClass('notification_clear_all')) {
        $('.user_notifications > .list_more').remove();
        $('.notification').fadeOut(300, function() {
          $(this).remove()
          $('#h_notification_num a').text('0')
        })
        $('.user_notifications').append('<h6>you have no new notifications</h6>');
        $('.notification_clear_all').fadeOut(300);
      } else {
        self.parent().fadeOut(300, function() {
          $('#h_notification_num a').text(parseInt($('#h_notification_num a').text())-1)
          if ($('.user_notifications > .notification').length == 0) {
            $('.user_notifications').append('<h6>you have no new notifications</h6>');
            $('.notification_clear_all').fadeOut(300);
          }
          else if ($('#notification_more_list').length > 0 && $('#notification_more_list').attr('data-count') != 0) {
            var count = parseInt($('#notification_more_list').attr('data-count'));
            if ($(this).parent().attr('id') != 'notification_more_list')
              $('#notification_more_list').before($('#notification_more_list').children(':first-child').detach());
            $('#notification_more_list').attr('data-count', count - 1);
            if ((count - 1) == 0) {
              $('.user_notifications > .list_more').remove();
            } else {
              if ($('#notification_more_list').is(":visible"))
                $('.user_notifications > .list_more').attr('blindText', 'show '+(count-1)+' more');
              else
                $('.user_notifications > .list_more').html('show '+(count-1)+' more');
            }
          }
          $(this).remove()
        })
      }
      $('.qtip-active').fadeOut(300);
    });
    return false;
  })

  // user settings
  $('.settingE').change(function() {
    var self = $(this);
    $.post(self.parent().parent().metadata().action, {setting: self.metadata().setting, value: self.val()}, function(data) {
      var color;
      if (data.success == 'true')
        color = "green"
      else
        color = "red"
      self.effect('highlight', {color:color}, 2000);
    }, "json");
  });

  // user change profile picture
  if ($('#user_cpi').length > 0) {
    $('#user_cpi').uploadify({
      'uploader'    : '/js/uploadify/uploadify.swf',
      'script'      : $('#user_cpi').metadata().url,
      'cancelImg'   : '/js/uploadify/cancel.png',
      'auto'        : true,
      'sizeLimit'   : '2097152',
      'buttonText'  : 'change image',
      'onComplete'  : function(a,b,c,d) {
        displayNotice('Profile image successfully changed', 1);
      }
    });
  }

  // feeds
  $('.feed_more').live('click', function() {
    var $self = $(this);
    $.get($self.attr('href'), function(data){
      var target = $self.metadata().target;
      $self.remove();
      $(target).append(data);
    })
    return false;
  });

  // user stats time period update
  $('.user_stats .stats_period').click(function() {
    var $self = $(this);
    if ($self.hasClass('on'))
      return;

    $.get($self.parent().metadata().url, {'d':$self.metadata().value}, function(data) {
      $('.user_stats .stats_period').removeClass('on', 250);
      $self.addClass('on', 250);
      $.each(data, function(i, val)
      {
        $.each(val, function(j, val2)
        {
          var $target = $('#'+i+'_'+j);
          updateUserStat($target, val2);
          $.each(val2, function(k, val3)
          {
            var $target = $('#'+i+'_'+j+'_'+k);
            updateUserStat($target, val3);
          })
        })
      })
    }, 'json')
  })
  function updateUserStat($target, $val)
  {
    $target.removeClass('pos neg');
    if (parseInt($val) > 0)
    {
      $target.addClass('pos');
    }
    else if (parseInt($val) < 0)
    {
      $target.addClass('neg');
    }
    $target.fadeOut(200, function() {$(this).text($val).fadeIn(200);});
  }

  // ********************
  // REVENUE
  // ********************
  $('.redeem a').click(function() {
    if ($(this).metadata().loading == true)
      return false;

    $(this).text('redeeming...').css({'color':'#999', 'text-decoration':'none', 'cursor':'default'}).metadata().loading = true;
  })
  $('.claims_show_more').click(function() {
    var $self = $(this);
    var $group = $('.claims li:visible:last').next().metadata().group;
    $('.claims li.claims_'+$group).fadeIn(200);
  })
  // END REVENUE

  // ********************
  // COMMENTS
  // ********************
  $('.comment_list > li > .actions > .addComment').live('click', function() {
    var self = $(this);
    $('#new_comment').hide(300);
    var parent = self.parent().parent();
    if (!self.attr('data-opened')) {
      parent.parent().find('.comment_add_F').hide(300);
      $.get(parent.parent().metadata().url, {'parent_id':self.metadata().id}, function(form) {
        self.attr('data-opened', 1);
        var extra = '';
        if (parent.hasClass('child'))
          extra = '(@ '+parent.find('.info > .submit_by > .user_link > a').text()+') ';
        parent.append(form).find('.comment_add_F').show(300, function() {$(this).find('textarea').val(extra).focus()});
      })
    } else {
      parent.parent().find('.comment_add_F').hide(300);
      if (!parent.find('.comment_add_F').is(':visible'))
        parent.find('.comment_add_F').show(300);
    }
  })
  $('.comment_add_F').live('submit', function(e) {
    e.preventDefault();
    var $self = $(this);
    if ($self.hasClass('loading'))
      return false;
    $self.addClass('loading');
    $self.children(':submit').val('submitting...');
    $.post($self.attr('action'), {'comment':$self.find('textarea').val()}, function(data) {
      if(data.result == 'success') {
        location.reload();
      } else if (data.result == 'error') {
        displayNotice(data.text, 0);
        $self.removeClass('loading').children(':submit').val('submit comment');
      } else if (data.result == 'login') {
        $self.children(':submit').val('submit comment');
        authenticate();
      }
    }, 'json')
  })
  $('.commentScoreAction').live('click', function() {
    var self = $(this);
    $.post(self.metadata().action, function(data) {
      if(data.result == 'success') {
        var parent = self.parent();
        parent.find('.commentScoreAction').hide(200, function() {
          if (parent.find('.voted').length == 0)
          {
            var html = '';
            if (data.amount > 0)
              html = '<div class="voted pos hide">voted</div>';
            else
              html = '<div class="voted neg hide">voted</div>';
            parent.prepend(html).find('.voted').show(200);
          }
        });
        self.parent().find('.sb_s').hide(200, function() {$(this).text(parseInt($(this).text())+parseInt(data.amount)).show(200)});
      } else if (data.result == 'error') {
        displayNotice(data.text, 0);
      } else if (data.result == 'login') {
        authenticate();
      }
    }, 'json')
  })
  // END COMMENTS

  // ********************
  // BASIC SEARCH
  // ********************
  $('.bs_C,.ns_C').click(function() {
    var self = $(this);
    var target = self.next();
    if (target.is(":visible"))
    {
      self.children('div').css({'background-color':'#fff'})
      target.hide(200);
    }
    else
    {
      $('.bs_H').css({'background-color':'#fff'});
      self.children('div').css({'background-color':'#E9EDCB'});
      $('.bs_field_C,.ns_field_C').hide(200);
      target.show(200, function() {target.children('input').focus();});
    }
  });
  $('#basic_search_input').keyup(function(e) {
    var self = $(this);
    if(e.keyCode == 13) {
      location.href = self.metadata().action + '?q=' + self.val()
    }
  });
  $('#basic_search_img').click(function() {location.href = $(this).prev().metadata().action + '?q=' + $(this).prev().val()})
  $('.bs_C').click(function() {
    var self = $(this);

    if (!self.attr('data-searchloaded'))
    {
      $.ajax({
        type: 'GET',
        cache: false,
        dataType: 'json',
        url: self.metadata().searchahead,
        success: function(r) {
          self.next().find('input').focus().autocomplete(r, {
            minChars: 0,
            max: 10,
            width: 234,
            matchContains: true,
            formatItem: function(row) {
              return "<div class='bs_result_item'>" + row.image + "<span>" + row.manufacturer + row.name + "</span><span class='sb_s rnd_3'>" + row.score + "</span></div>";
            },
            formatMatch: function(row) {
              return row.manufacturer + row.name;
            },
            formatResult: function(row) {
              return row.name;
            }
          }).result(function(event, item) {location.href = item.url});
          self.attr('data-searchloaded', true);
        }
      });
    }
  });
  // END SEARCH

  // ********************
  // HELP TOGGLES
  // ********************
  // to adjust the body padding when the top help bar is shown to new users
  $('.top_help .close').click(function() {
    $.post($(this).metadata().url, function() {
      $('.top_help').slideUp(400);
      $('body').removeClass('top_help_on', 400);
      $('.home_welcome').removeClass('help_adjust', 400);
    })
  })
  $('.hide_features').click(function() {
    $.post($(this).metadata().url, function() {
      $('.home_welcome').fadeOut(1000, function() {
        $('.home_welcome_placeholder').removeClass('home_welcome_placeholder', 500);
        $('.welcome_on').removeClass('welcome_on', 500);
      });
    })
  })
  // END HELP TOGGLES

  // ********************
  // AUTHENTICATE SCRIPT
  // ********************
  function authenticate() {
    if ($('#h_register').length > 0)
      $('#h_register').click();
    else
      $('#h_relogin').click();
  }
  //$('.authenticate').live('click', function() { authenticate() });
  // END AUTHENTICATE

  // ********************
  // CHANGE USERNAME
  // ********************
  $('.username_change').click(function() {
    var self = $(this);
    var content = '<div class="username_change"><h3>Permanently change your tech limelight username. You may only change your \n\
                   username <span>ONCE</span>. Pick a good one!<h3><div class="error"></div><input type="text" class="rnd_3" maxlength="15" /></div>//////';
    $('#authDialog').html(content).dialog({
      width: 500, resizable: false, modal: true, draggable: false, closeOnEscape: true,
      title: 'Change Username',
      buttons: {
        'Close': function() {$(this).dialog('destroy');},
        'Change': function() {
          $.post(self.metadata().url, {'u':$('.username_change input').val()}, function(data) {
            if (data.result == 'success')
              window.location = data.url;
            else
            {
              $('.username_change .error').fadeOut(200, function() {$(this).html(data.text).fadeIn(200)});
            }
          }, 'json')
        }
      },
      open: function() {$('.ui-widget-overlay').fadeTo(500, .75);$('.username_change input').focus()},
      close: function() {$(this).dialog("destroy")}
    })
  });
  // END CHANGE USERNAME

  // ********************
  // RPX
  // ********************
  $('#h_login').live('click', function() {
    $('.rpxnow_lightbox_container').append($('.rpx_help.login_C').html());
    $('.rpxnow_lightbox_container').append($('.rpx_limelight.login_C').html());
  })
  $('#h_register').live('click', function() {
    $('.rpxnow_lightbox_container').append($('.rpx_help.register_C').html());
    $('.rpxnow_lightbox_container').append($('.rpx_limelight.register_C').html());
  })
  $('#h_relogin').live('click', function() {
    $('.rpxnow_lightbox_container').append($('.rpx_help.relogin_C').html());
    $('.rpxnow_lightbox_container').append($('.rpx_limelight.login_C').html());
  })
  $('.share').live('click', function() {
      var self = $(this);
      RPXNOW.loadAndRun(['Social'], function () {
      var activity = new RPXNOW.Social.Activity(
         self.metadata().display,
         self.metadata().action,
         self.metadata().url
      );
      RPXNOW.Social.publishActivity(activity);
    });
  })
  // END RPX

  // ********************
  // LOGIN FUNCTIONALITY (deprecated after Janrain)
  // ********************
  $('.rpx_limelight.login').live('click', function() {
    $('.rpxnow_lightbox').fadeOut(200, function() {loginDialog();});
  })

  $('.rpx_limelight.register').live('click', function() {
    window.location = $(this).metadata().url;
  })

  $('#login_form').live('submit', function() {
    loginRequest();
    return false;
  })

  function loginDialog() {
    $.ajax({
      type: 'GET',
      cache: false,
      url: $('.rpx_limelight.login').metadata().url,
      success: function(text) {
        $('#authDialog').html(text).dialog({
          width: 300, resizable: false, modal: true, draggable: false, closeOnEscape: true,
          title: 'Sign In | Tech Limelight',
          buttons: {
            'Close': function() {
              $(this).dialog("destroy");
              $('.rpxnow_lightbox').fadeIn(300);
            },
            'Login': function() {
              loginRequest();
            }
          },
          open: function() {
            $('.ui-widget-overlay').fadeTo(200, .65);
          },
          close: function() {
            $(this).dialog("destroy");
            $('.rpxnow_lightbox').fadeIn(200);
          }
        });
        $('#signin_username').focus();
        $("#signin_password").keyup(function (e) {
          if (e.which == 13)
            loginRequest();
        });
      }
    });
  }
  function loginRequest() {
    $.ajax({
      type: 'POST',
      cache: false,
      data: $('#login_form').serializeArray(),
      url: $('.rpx_limelight.login').metadata().url,
      beforeSend: function() {
        $('#login_form .field').attr('disabled', 'disabled');
        $('.ui-button').attr('disabled', 'disabled');
      },
      success: function(text) {
        if (text == 'logged')
          window.location.reload();
        else {
          $('#authDialog').html(text);
          $('#login_form .field').attr('disabled', '');
          $('.ui-button').attr('disabled', '');
          $('#signin_username').focus();
          $("#signin_password").keyup(function (e) {
            if (e.which == 13)
              loginRequest();
          });
        }
      }
    });
  }

  $("#forgot_pass").live('click', function() {forgotPassDialog();return false;});
  $('#forgot_pass_form').live('submit', function() {
    forgotPassRequest();
    return false;
  });
  function forgotPassDialog() {
    $.ajax({
      type: 'GET',
      cache: false,
      url: $('#forgot_pass').attr('href'),
      success: function(text) {
        $('#authDialog').html(text).dialog({
          width: 300, resizable: false, modal: true, draggable: false, closeOnEscape: true,
          title: 'Forgot Password | Tech Limelight',
          buttons: {
            'Close': function() {
              $(this).dialog("destroy");
              $('.rpxnow_lightbox').fadeIn(200);
            },
            'Send Password': function() {
              forgotPassRequest();
            }
          },
          close: function() {
            $(this).dialog("destroy");
            $('.rpxnow_lightbox').fadeIn(200);
          }
        });
        $('#password_email').focus();
        $("#password_email").keyup(function (e) {
          if (e.which == 13)
            forgotPassRequest();
        });
      }
    });
  }
  function forgotPassRequest() {
    $.ajax({
      type: 'POST',
      cache: false,
      data: $('#forgot_pass_form').serializeArray(),
      url: $('#forgot_pass_form').attr('action'),
      beforeSend: function() {
        $('#forgot_pass_form .field').attr('disabled', 'disabled');
        $('.ui-button').attr('disabled', 'disabled');
      },
      success: function(data) {
        if (data.text == 'changed')
          window.location.reload();
        else {
          $('#authDialog').html(data);
          $('#forgot_pass_form .field').attr('disabled', '');
          $('.ui-button').attr('disabled', '');
          $('#password_email').focus();
          $("#password_email").keyup(function (e) {
            if (e.which == 13)
              forgotPassRequest();
          });
        }
      }
    });
  }
  // END LOGIN FUNCTIONALITY

  // **********************
  // LIMELIGHT MODULE
  // **********************

  // limelight check name on suggest page
  $('#limelightSuggest_F #limelight_name').blur(function() {
    var self = $(this);
    if (self.val() == '')
      return false;

    var $searchVal;
    if ($('#limelightSuggest_F .types .right div.on').text() == 'company' || $('#limelightSuggest_F .types .right div.on').text() == 'source')
    {
      $searchVal = self.val() + ' logo';
    }
    else
    {
      $searchVal = self.val() + ' ' + $('#limelightSuggest_F .category_chooser .cat1:visible option:selected').text()
                                      + ' ' + $('#limelightSuggest_F .category_chooser .cat2:visible option:selected').text()
                                      + ' ' + $('#limelightSuggest_F .category_chooser .cat3:visible option:selected').text();
    }

    $.get(self.metadata().url, {'q':self.val(), 'iq':$searchVal}, function(data) {
      var $ll_matches = (data == null) ? '' : data.ll_matches;
      $('#limelightSuggest_F .matches li:not(.first)').remove();
      if ($ll_matches.length == 0)
      {
        $('#limelightSuggest_F .matches li.first').after('<li>There were <b>NO</b> limelight matches found - add away!</li>');
      }
      else
      {
        $.each($ll_matches, function(index, val) {
          $('#limelightSuggest_F .matches li.first').after('<li class="rnd_3"><a href="'+val.url+'">'+val.name+'</a></li>');
        })
      }
      $('#limelightSuggest_F .matches').show(200);

      var $image_suggestions = (data == null) ? '' : data.image_matches;
      if ($image_suggestions.length == 0)
      {
        $('#limelightSuggest_F .image_suggestions').after('There were <b>NO</b> image matches found!');
      }
      else
      {
        $('#limelightSuggest_F .image_chooser_left, #limelightSuggest_F .image_chooser_right, #limelightSuggest_F .image_chooser_text').fadeIn(300);
        $('#limelightSuggest_F .image_suggestions').html('<img class="rnd_3" height="300" data-on="0" src="'+$image_suggestions[0]+'" alt="if you\'re seeing this text, this image is broken.. skip it!" />');
        var $img = $('#limelightSuggest_F .image_suggestions img');
        $.each($image_suggestions, function(index, val) {
          if (index > 15)
            return false;

          var $target = 'image_choice_'+index;
          $img.attr('data-'+$target, val);
        })
      }
    }, 'json')
  })

  // handle the limelight suggest page type chooser
  $('#limelightSuggest_F .types .right div').click(function() {
    $('#limelightSuggest_F .types .right div').removeClass('on');
    $(this).addClass('on');
    if ($(this).hasClass('product'))
      $('#limelightSuggest_F .item.company').fadeIn(200);
    else
    {
      $('#limelightSuggest_F .item.company').fadeOut(200);
      $('#limelight_company_name').val('');
    }
  })

  // handle the limelight suggest page category chooser
  $('#limelightSuggest_F .category_chooser select').change(function() {
    var $self = $(this);

    if ($self.hasClass('cat1'))
    {
      $('#limelightSuggest_F select.cat2, #limelightSuggest_F select.cat3').val('').hide();
    }
    else if ($self.hasClass('cat2'))
    {
      $('#limelightSuggest_F select.cat3').val('').hide();
    }
    $('#cat_select_'+$self.val()).show();
  })

  // handle the image chooser
  $('.image_chooser_left').click(function() {
    var $self = $(this);
    var $img = $self.next().next().next().children('img');
    var $next = parseInt($img.attr('data-on'))-1;
    if ($next < 0)
      $next = 15;
    $img.attr('src', $img.attr('data-image_choice_'+$next));
    $img.attr('data-on', $next);
  })
  $('.image_chooser_right').click(function() {
    var $self = $(this);
    var $img = $self.next().next().children('img');
    var $next = parseInt($img.attr('data-on'))+1;
    if ($next > 15)
      $next = 0;
    $img.attr('src', $img.attr('data-image_choice_'+$next));
    $img.attr('data-on', $next);
  })

  // handle the limelight suggestion submit
  var limelightSubmit = function()
  {
    var self = $('#limelightSuggest_F .submit');
    self.unbind('click').text('submitting...').addClass('submitting');
    var formData = {};

    $('h2.error').hide();
    $('.error_list').remove();

    // get the info
    formData['limelight[limelight_type]'] = $('#limelightSuggest_F .types .right div.on').text();
    formData['limelight[category_1]'] = $('#limelightSuggest_F .cat1:visible').val();
    formData['limelight[category_2]'] = $('#limelightSuggest_F .cat2:visible').val();
    formData['limelight[category_3]'] = $('#limelightSuggest_F .cat3:visible').val();
    formData[$('#limelight_name').attr('name')] = $('#limelight_name').val();
    formData[$('#limelight_company_name').attr('name')] = $('#limelight_company_name').val();
    formData[$('#limelight_summary').attr('name')] = $('#limelight_summary').val();
    formData['limelight[profile_image]'] = $('#limelightSuggest_F .image_suggestions img').attr('data-image_choice_'+$('#limelightSuggest_F .image_suggestions img').attr('data-on'));
    formData[$('#limelight__csrf_token').attr('name')] = $('#limelight__csrf_token').val();

    $.post(self.metadata().url, formData, function(data) {
      if (data.result == 'error')
      {
        self.bind('click.submit', limelightSubmit).text('suggest limelight').removeClass('submitting');

        // handle the errors
        $('#limelightSuggest_F .error_list').remove();
        $('#limelightSuggest_F .error_on').removeClass('error_on');
        
        $.each(data.info_error, function(index, val) {
          if (val.error != '')
          {
            if (val.error == 'error_on')
              $(val.name).addClass(val.error);
            else
              $(val.name).before(val.error);
          }
        })

        $.scrollTo($('#step1'), 500, {onAfter:function() { $('h2.error').fadeIn(1000); }});
      }
      else if (data.result == 'success')
      {
        window.location = data.url;
      }
      else if (data.result == 'login')
      {
        self.bind('click.submit', limelightSubmit).text('suggest limelight').removeClass('submitting');
        authenticate();
      }
    }, 'json')
  };
  $('#limelightSuggest_F .submit').bind('click.submit', limelightSubmit);

  // manufacturer autocomplete on limelight suggest form
  $('#limelight_company_name').focus(function() {
    var self = $(this);
    if (!self.metadata().searchloaded)
    {
      $.get(self.metadata().searchahead, function(data) {
        self.autocomplete(data, {
          minChars: 0,
          max: 10,
          matchContains: true,
          selectFirst: false
        });
        self.metadata().searchloaded = 1;
      }, 'json');
    }
  });

  // specification autocomplete on specification add form
  $('#specification_F #specification_name').focus(function() {
    var self = $(this);
    if (self.metadata().searchloaded == 0)
    {
      $.get(self.metadata().searchahead, function(data) {
        self.autocomplete(data, {
          minChars: 0,
          max: 10,
          matchContains: true,
          selectFirst: false
        });
        self.metadata().searchloaded = 1;
      }, 'json');
    }
  });

  $('#specification_F').bind('submit', specificationSubmit);

  // handle specification submissions
  function specificationSubmit(event)
  {
    var self = $(event.target);
    // unbind while submitting, and bind new function to catch extra form clicks temporarily
    self.unbind('submit', specificationSubmit).bind('submit', function() {return false;});
    $('#specification_F .submit').text('adding...');
    $.post(self.attr('action'), self.serializeArray(), function(data) {
      if (data.result == 'success')
      {
        $('#specification_F .submit').val('added! reloading...');
        window.location.reload();
      }
      else if (data.result == 'error')
      {
        if (data.text)
        {
          displayNotice(data.text, 0);
        }
        $('#specification_F .error_list, .global_error').remove();
        if (data.global_error)
        {
          $('#specification_F').prepend('<div class="global_error">'+data.global_error+'</div>');
        }
        else if (data.info_error)
        {
          $.each(data.info_error, function(index, val) {
            if ($(val).error != '')
            {
              $('#specification_'+val.name).before(val.error);
            }
          })
        }
        $('#specification_F .submit').val('add specification');
        self.bind('submit', specificationSubmit);
      }
      else if (data.result == 'login')
      {
        $('#specification_F .submit').val('add specification');
        authenticate();
      }
    }, 'json')
    return false;
  }

  // show extra spec content on limelight info pages
  $('.specs li .expand').click(function() {
    var row = $(this).parent().parent();
    $('.specs li .extra').hide();
    row.children('.extra').slideToggle(200);
  })

  // limelight autocomplete on news_add form
  $('#news_limelight').focus(function() {
    var self = $(this);
    if (!self.metadata().searchloaded)
    {
      $.get(self.metadata().searchahead, function(data) {
        self.autocomplete(data, {
          minChars: 0,
          max: 15,
          matchContains: true,
          selectFirst: false,
          formatItem: function(row) {
            return "<div class='bs_result_item'>" + row.image + "<span class='name' data-name='" + row.name + "'>" + row.manufacturer + " " + row.name + "</span><span class='sb_s rnd_3'>" + row.score + "</span></div>";
          },
          formatMatch: function(row) {
            return row.manufacturer + row.name;
          },
          formatResult: function(row) {
            return 'auto';
          }
        }).result(function(event, item) {
          if (!item)
            return false;
          $('.limelight_add_C div:not(.clear)').remove();
          $('#news_limelight').val('');
          $.each($('.limelight_add_C li'), function(index, value) {
            if ($(value).children('.name').metadata().name == item.name)
            {
              $(value).addClass('.on');
              $.stop();
              return false;
            }
          })
          $('.limelight_add_C > div.clear').before('<li id="'+item.id+'" class="on rnd_3">'+ item.image + '<span class="name" data-name="' + item.name + '">' + item.manufacturer + item.name + '</span><span class="sb_s score rnd_3">' + item.score + '</span></li>');
        });
        self.metadata().searchloaded = 1;
      }, 'json');
    }
  });

  // add a limelight (not from autocomplete) on news add form
  $('#news_limelight').keyup(function(e) {
    if(e.keyCode == 13) {
      newsAddLimelight();
    }
  })
  $('#newsAdd_F .limelight_add').click(function() {newsAddLimelight()});
  function newsAddLimelight()
  {
    var self = $('#news_limelight');
    if (self.val() == '')
      $.stop();
    $('.ac_results').hide();
    $('.limelight_add_C div:not(.clear)').remove();
    $.each($('.limelight_add_C li'), function(index, value) {
      if ($(value).children('.name').text() == self.val())
      {
        self.val('');
        $(value).addClass('.on');
        $.stop();
      }
    })
    $('.limelight_add_C > div.clear').before('<li id="0"  class="on rnd_3"><img src="'+ self.metadata().default_image_url + '" alt="" /><span class="name" data-name="' + self.val() + '">' + self.val() + '</span><span class="sb_s score rnd_3">NEW</span></li>');
    self.val('');
  }

  // toggle summary and stats in the limelight head
  $('#ll_head #middle .toggle:not(.on)').live('click', function() {
    var self = $(this);
    var on = $('#ll_head #middle .toggle.on');
    on.removeClass('on');
    self.addClass('on');
    $('#ll_head #middle ' + on.metadata().target + ':not(.toggle)').fadeOut(100, function() {
      $('#ll_head #middle '+self.metadata().target).fadeIn(100);
    });
  })

  // load the limelight wiki editor upon double click, and deal with locking/unlocking editor situations
  $('.wiki .content').live('dblclick', function() {
    var self = $(this);
    $.post(self.metadata().url, function(data) {
      if(data.result == 'success') {
        self.ckeditor( function() {
          self.parent().children('.edit_by').remove();
          self.after('<div class="edit_notice">Don\'t forget to save your changes when finished.  You have '+Math.round(self.metadata().max_time/1000/60)+' minutes to edit this wiki section.  After '+Math.round(self.metadata().inactivity/1000/60)+' minutes of inactivity your unsaved changes will be discarded and this wiki section will be unlocked!</div>')
          var editor = $(self.parent());

          self.parent().find('.controls').show();

          // set the idle timer, after which the wiki section is unlocked
          editor.idleTimer(parseInt(self.metadata().inactivity));
          editor.bind("idle.idleTimer", function(){
            $.post(self.metadata().unload_url, {'code':0}, function() {window.location.reload();} )
          });

          // update the last used field in the DB every once and a while
          editor.everyTime(self.metadata().inactivity/5, function() {
            $.post(self.metadata().update_url, function() { } )
          });

          // notify the user when their editing time is almost up
          editor.oneTime(self.metadata().max_time*.9, function() {
            $('.edit_notice').append('<br><br>You only have about '+Math.round((self.metadata().max_time-(self.metadata().max_time*.9))/1000/60)+' minutes left to edit!');
            displayNotice('You only have about '+Math.round((self.metadata().max_time-(self.metadata().max_time*.9))/1000/60)+' minutes left to edit!', 0);
          });

          // unlock and reload the page if the user exceeds the max editing time limit
          editor.oneTime(self.metadata().max_time, function() {
            $.post(self.metadata().unload_url, {'code':1}, function() {window.location.reload();} )
          });
        });
      } else if (data.result == 'error') {
        displayNotice(data.text, 0);
      } else if (data.result == 'login') {
        authenticate();
      }
    }, 'json')
  })

  // handle the wiki submission
  $('.wikis .wiki .submit').live('click', function() {
    var self = $(this);

    var content = CKEDITOR.instances['editor1'].getData();
    if (content == '' || content == self.parent().parent().children('.content').html())
    {
      displayNotice('You must make changes to the revision before saving!', 0);
      return false;
    }

    var edit_type = self.parent().find('.edit_type > .checked');
    if (edit_type.length == 0)
    {
      displayNotice('Please select an edit type!', 0);
      return false;
    }
    edit_type = edit_type.metadata().value;

    var note = self.parent().find('.note');
    if (note.val() == '' || note.metadata().cleared == 0){
      displayNotice('Please input an edit note!', 0);
      return false;
    }
    note = note.val();

    self.removeClass('submit').addClass('disabled').html('saving...');
    $.post(self.metadata().url, {'content':content, 'edit_type':edit_type, 'note':note}, function(data) {
      if (data.result == 'login') {
        authenticate();
        self.removeClass('disabled').addClass('submit').html('save revision');
      } else if (data.result == 'error') {
        displayNotice(data.text, 0);
        self.removeClass('disabled').addClass('submit').html('save revision');
      } else if (data.result == 'success') {
        window.location.reload();
      }
    }, 'json')
  })

  // handle the wiki cancellation
  $('.wikis .wiki .cancel').live('click', function() {
    var self = $(this);
    $.post(self.metadata().unload_url, function() {
      window.location.reload();
    })
  })

  // slices
  $('.slices .slice').click(function() {
    var $self = $(this);

    if ($self.hasClass('on'))
      return false;

    $('.slice_item').hide();
    $('.slice_'+$self.metadata().id).show();
    $('#specification_slices').val($self.metadata().id);
    $('.procon_C.pros #limelight_procon_slices').val($self.metadata().id);
    $('.procon_C.cons #limelight_procon_slices').val($self.metadata().id);

    $('.slices .slice.on').removeClass('on');
    $self.addClass('on');
  })

  // handle slice submissions
  $('#slice_F').bind('submit', sliceSubmit);
  function sliceSubmit(event)
  {
    var self = $(event.target);
    // unbind while submitting, and bind new function to catch extra form clicks temporarily
    self.unbind('submit', sliceSubmit).bind('submit', function() {return false;});
    $('#slice_F .submit').text('creating...');
    $.post(self.attr('action'), self.serializeArray(), function(data) {
      if (data.result == 'success')
      {
        $('#slice_F .submit').val('created! reloading...');
        window.location.reload();
      }
      else if (data.result == 'error')
      {
        if (data.text)
        {
          displayNotice(data.text, 0);
        }
        $('#slice_F .error_list, .global_error').remove();
        if (data.global_error)
        {
          $('#slice_F').prepend('<div class="global_error">'+data.global_error+'</div>');
        }
        else if (data.info_error)
        {
          $.each(data.info_error, function(index, val) {
            if ($(val).error != '')
            {
              $('#slice_'+val.name).before(val.error);
            }
          })
        }
        $('#slice_F .submit').val('create it');
        self.bind('submit', sliceSubmit);
      }
      else if (data.result == 'login')
      {
        $('#slice_F .submit').val('create');
        authenticate();
      }
    }, 'json')
    return false;
  }

// ************** DEPRECATED WHEN WIKI SEGMENTS WERE REMOVED ********************** //
  // the wiki topics sortable section
//  $(".segment_list.sort").sortable({
//    placeholder: 'ui-state-highlight',
//    update: function(event, ui) {
//      var order = new Array();
//      $.each($('.segment_list.sort > li'), function(key, value) {
//        order[key] = $(this).metadata().id;
//      })
//      $.post($('.segment_list.sort').metadata().url, {'order':order}, function(data) {
//        if (data.result == 'login') {
//          authenticate();
//        } else if (data.result == 'error') {
//          displayNotice(data.text, 0);
//        } else if (data.result == 'success') {
//          $.each($('.segment_list.sort > li'), function(key, value) {
//            $(this).children('span').html(key+1);
//          })
//          $('.segment_list.sort > li > span').effect('highlight', {color:'green'}, 3000);
//        }
//      }, 'json')
//    }
//  });
//
//  // load and show the new wiki segment form
//  $('.wikis h2 .new_segment').live('click', function() {
//    var self = $(this);
//    $.get(self.metadata().url, function(data) {
//      if (data.result == 'login') {
//        authenticate();
//      } else if (data.result == 'error') {
//        displayNotice(data.text, 0);
//      } else if (data.result == 'success') {
//        $('.wikis #new_segment_F').toggle(200).find('textarea').ckeditor();
//      }
//    }, 'json')
//  })
//
//  // check for existing segments matching the topics given by the user
//  $('.wikis #new_segment_F .name').live('blur', function() {
//    var self = $(this);
//    if (self.val() == '') return false;
//    $.get(self.metadata().url, {'q':self.val(), 'll_id':self.metadata().ll_id}, function(data) {
//      $('.wikis #new_segment_F .matches ul').html('');
//      $.each(data, function(key, value) {
//        var link_class;
//        var link_title;
//        if (value.linked != '') {
//          link_class = 'linked';
//          link_title = 'linked';
//          if (value.authorized == 1)
//          {
//            link_class += ' unlinkable';
//            link_title = 'linked - click to unlink this wiki segment';
//          }
//        }
//        else {
//          link_class = 'linkable';
//          link_title = 'unlinked - click to link this wiki segment';
//        }
//        $('.wikis #new_segment_F .old_segments .segment_list').append('<li class="wiki_segment_name" data-url="' + value.url + '" data-my="bottom left" data-at="top left" data-fixed="true" data-type="light"><span class="key rnd_3">' + (key+1) + '</span>' + value.topic + '<span title="' + link_title +'" class="' + link_class + '" data-url="' + value.link_url + '"></span></li>');
//      })
//      $('.wikis #new_segment_F .old_segments').show(200);
//    }, 'json')
//  })

  // handle new segment submissions
//  $('.wikis #new_segment_F').live('submit', function() {
//    var self = $(this);
//    var formData = self.serializeArray();
//    if (formData[0].value == '' || formData[1].value == '')
//    {
//      displayNotice('You cannot leave the name field or the content field blank!', 0);
//      return false;
//    }
//
//    $.post(self.attr('action'), {"name":formData[0].value, "content":formData[1].value}, function(data) {
//      if (data.result == 'login') {
//        authenticate();
//      } else if (data.result == 'error') {
//        displayNotice(data.text, 0);
//      } else if (data.result == 'success') {
//        window.location.reload();
//      }
//    }, 'json')
//    return false;
//  })
//  $('.wikis #new_segment_F .cancel').live('click', function() {$(this).parent().hide(200)})
//
//  // show the link segment search form
//  $('.wikis h2 .link_segment').live('click', function() {$('.link_segment_C').toggle(200);})
//  $('.link_segment_C .submit').live('click', function() {
//    var self = $(this);
//    var data = self.prev().val();
//    $.get(self.metadata().url, {'q':data, 'll_id':self.metadata().id}, function(data) {
//      if (data.result == 'login') {
//        authenticate();
//      } else if (data.result == 'error') {
//        displayNotice(data.text, 0);
//      } else {
//        $('.link_segment_C .segment_list').hide(200, function() {
//          var self = $(this);
//          self.html('');
//          $.each(data, function(key, value) {
//            var link_class;
//            var link_title;
//            if (value.linked != '') {
//              link_class = 'linked';
//              link_title = 'linked';
//              if (value.authorized == 1)
//              {
//                link_class += ' unlinkable';
//                link_title = 'linked - click to unlink this wiki segment';
//              }
//            }
//            else {
//              link_class = 'linkable';
//              link_title = 'unlinked - click to link this wiki segment';
//            }
//            self.append('<li class="wiki_segment_name" data-url="' + value.url + '" data-url="' + value.url + '" data-my="bottom left" data-at="top left" data-fixed="true" data-type="light"><span class="key rnd_3">' + (key+1) + '</span>' + value.topic + '<span title="' + link_title +'" class="' + link_class + '" data-url="' + value.link_url + '"></span></li>');
//          })
//          self.show(200);
//        })
//      }
//    }, 'json')
//  })
//
//  // link or unlink a wiki segment
//  $('.wiki_segment_name .linkable, .wiki_segment_name .unlinkable').live('click', function() {
//    var self = $(this);
//    $.post(self.metadata().url, function(data) {
//      if (data.result == 'login') {
//        authenticate();
//      } else if (data.result == 'error') {
//        displayNotice(data.text, 0);
//      } else if (data.result == 'success') {
//        displayNotice(data.text, 1);
//        if (data.type == 'link')
//          self.removeClass('linkable').addClass('linked');
//        else
//          self.removeClass('linked').addClass('linkable');
//      }
//    }, 'json')
//  })
// ************** end DEPRECATED WHEN WIKI SEGMENTS WERE REMOVED ********************** //

  // limelight summary edit
  $('#ll_head .summary_edit').click(function() {
    var $self = $(this);
    $.get($self.metadata().url, function(data) {
      if (data.result == 'success')
      {
        $('#ll_head .summary:not(.toggle)').append('<div id="summary_length"><span>0</span>/275</div>\
          <textarea class="length_counter rnd_3" maxlength="275" lengthIndicator="#summary_length">////'+$('#ll_head .summary:not(.toggle) p').text()+'</textarea>');
        $('#ll_head .summary:not(.toggle) p').hide();
        $('#ll_head .summary:not(.toggle) textarea').focus();
        $self.hide().next().show().next().show();
      }
      else if (data.result == 'error')
      {
        displayNotice(data.text, 0);
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json');
  })
  $('#ll_head .summary_edit_submit:not(.loaded)').click(function() {
    var $self = $(this);
    var summary = $.trim($('#ll_head .summary:not(.toggle) textarea').val());
    var prev = $.trim($('#ll_head .summary:not(.toggle) p').text());
    if (summary == prev)
    {
      displayNotice('You must make changes to the summary before you can submit it...', 0);
      return false;
    }
    $self.addClass('loaded');
    $.get($self.metadata().url, {'s':summary}, function(data) {
      if (data.result == 'success')
      {
        $self.text('reloading...');
        window.location.reload();
      }
      else if (data.result == 'error')
      {
        $self.removeClass('loaded');
        displayNotice(data.text, 0);
      }
      else if (data.result == 'login')
      {
        authenticate();
      }
    }, 'json');
  })
  $('#ll_head .summary_edit_cancel').click(function() {
    var $self = $(this);
    $('#ll_head .summary:not(.toggle) textarea, #ll_head .summary:not(.toggle) #summary_length').remove();
    $('#ll_head .summary:not(.toggle) p').show();
    $self.hide().prev().hide().prev().show();
  })

  // pro/con submit
  $('#pro_F, #con_F').bind('submit', proconSubmit);
  function proconSubmit(event)
  {
    var $self = $(event.target);
    event.preventDefault();
    // unbind while submitting, and bind new function to catch extra form clicks temporarily
    $self.unbind('submit', proconSubmit).bind('submit', function() {return false;});
    $self.find('.submit').text('adding...');
    $.post($self.attr('action'), $self.serializeArray(), function(data) {
      if (data.result == 'success')
      {
        $self.find('.submit').val('added! reloading...');
        window.location.reload();
      }
      else if (data.result == 'error')
      {
        if (data.text)
        {
          displayNotice(data.text, 0);
        }
        $self.find('.error_list, .global_error').remove();
        if (data.global_error)
        {
          $self.find('textarea').before('<div><ul><li class="global_error">'+data.global_error+'</li></ul></div>');
        }
        else if (data.info_error)
        {
          $.each(data.info_error, function(index, val) {
            if ($(val).error != '')
            {
              $self.find('textarea').before('<div class="global_error">'+val.error+'</div>');
            }
          })
        }
        $self.find('.submit').val('submit');
        $self.bind('submit', proconSubmit);
      }
      else if (data.result == 'login')
      {
        $self.find('.submit').val('submit');
        authenticate();
      }
    }, 'json')
  }
  // END LIMELIGHT MODULE

  // register new user update user URL
  $('#user_username').live('keyup', function() {$('#r_user_url > span').html($(this).val());})

  // sidebar tab switching
  $('.top_list ul li').each(function(key,value) {
    var self = $(this);
    self.click(function() {
      self.parent().children('.on').removeClass('on');
      self.addClass('on');
      self.parent().parent().children('.list.on').removeClass('on').fadeOut(200, function() {
        $(self.attr('alt')).addClass('on').fadeIn(200);
      });
    });
  });

  // show the help boxes on the contribute items forms
  $('.contribute_item').find(':input').focus(function() {
    $('.contribute_item').find('.help:visible').fadeOut(200);
    $(this).parent().next().fadeIn(200)
  });

  // ********************
  // NEWS ADD PAGE
  // ********************

  // get and show the related stories, tags, and limelights on the news add page
  $('.news_add .lookup').click(function() {
    var $self = $(this);
    if ($('#news_source_url').val() == '') return false;

    $self.text('working...');

    // scrape the data and check for possible existing news stories
    $.get($self.metadata().news_url, {'q':$('#news_source_url').val()}, function(data) {
      if (data.result == 'error')
      {
        //displayNotice(data.text, 'Please use a valid URL');
        return false;
      }

      // fade in the form
      $('#newsAdd_F').fadeIn(500);

      // fill in the basic info
      $('#news_title').val(data.info.title);
      $('#news_content').val(data.info.content);
      $('#news_source_name').val(data.info.source);

      // fade in and load the news story matches
      $('#newsAdd_F .matches').fadeOut(200, function() {
        $('#newsAdd_F .matches li:not(.first)').remove();
        $.each(data.stories, function(key, value) {
          if (key == 5) return false;
          $('#newsAdd_F .matches').append('<li class="rnd_3"><a href="'+value.url+'" target="_blank">'+value.title+'</a><div>'+value.content+'</div><div class="date">'+value.date+'</div></li>');
        })
        if (data.stories.length == 0)
          $('#newsAdd_F .matches').append('<li class="rnd_3">There were <b>no</b> news story matches that matched your title, you\'re good to go!');
        $('#newsAdd_F .matches').fadeIn(200);
      })

      // set the related tags
      $('#newsAdd_F .tag_suggest').fadeOut(200, function() {
        $('#newsAdd_F .tag_suggest li, #newsAdd_F .tag_suggest div').remove();
        $.each(data.tags, function(key, value) {
          if (key == 20) return;
          $('#newsAdd_F .tag_suggest').append('<li class="rnd_3" data-tag_id="'+value.tag_id+'">'+value.name+'</li>');
        })
        if (data.tags.length == 0)
          $('#newsAdd_F .tag_suggest').append('<div class="rnd_3">There were <b>no</b> tags we could suggest, try adding your own below!</div>');
        $('#newsAdd_F .tag_suggest').append('<div class="clear"></div>');
        $('#newsAdd_F .tag_suggest').fadeIn(200);
      })

      // set the related limelights
      $('#newsAdd_F .limelight_add_C').fadeOut(200, function() {
        $('.limelight_add_C div:not(.clear)').remove();
        $.each(data.limelights, function(key, value) {
          if (key == 10) return;
          $('.limelight_add_C > div.clear').before('<li id="' + value.id + '" class="rnd_3"><img src="'+ value.profile_image + '" alt="" /><span class="name" data-name="' + value.name + '">' + value.name + '</span><span class="sb_s score rnd_3">' + value.score + '</span></li>');
        })
        if (data.limelights.length == 0)
          $('.limelight_add_C > div.clear').before('<div class="rnd_3">There were <b>no</b> limelights we could suggest, try adding your own below!</div>');
        $('#newsAdd_F .limelight_add_C').fadeIn(200);
      })

      $self.text('look it up');

      $.scrollTo($('#step1'), {speed:500});
      $('#news_title').focus();
    }, 'json')
  })

  // the add button for tags on the news story add page
  $('#newsAdd_F .tag_add').click(function() {news_add_form_add_tag()})
  $('input#news_tag').keyup(function(e) {
    if(e.keyCode == 13) {
      news_add_form_add_tag();
    }
  });

  function news_add_form_add_tag()
  {
    $('input#news_tag').val($.trim($('input#news_tag').val()));
    if ($('input#news_tag').val() == '')
      $.stop();
    var original_val = $('input#news_tag').val();
    var input_val = $('input#news_tag').val().toLowerCase();
    $('input#news_tag').val('');
    $('#newsAdd_F .tag_add_C').fadeIn(200);

    $.each($('#newsAdd_F .tag_suggest li'), function(index, value) {
      if ($(value).text().toLowerCase() == input_val)
      {
        $(value).addClass('on');
        $('.tag_add_C div').before($(value));
        $.stop();
      }
    })

    $.each($('#newsAdd_F .tag_add_C li'), function(index, value) {
      if ($(value).text().toLowerCase() == input_val)
      {
        $.stop();
      }
    })

    $('#newsAdd_F .tag_add_C div').before('<li class="on rnd_3">'+original_val+'</li>');
  }

  $('#news_limelight').focus(function() {$('.limelight_add_C').fadeIn(200)});
  $('#newsAdd_F .tag_suggest li, #newsAdd_F .tag_add_C li, #newsAdd_F .limelight_add_C li').live('click', function() {$(this).toggleClass('on')});

  // adjust the location of the images on the chosen limelights section of the news add page
  $('.limelight_add_C img').livequery(function() {
    var self = $(this);
    var height = (self.parent().height()-$(this).height())/2;
    $(this).css('margin-top', height);
  })

  // handle the news submission form
  var newsSubmit = function()
  {
    var self = $('.news_add .submit');
    self.unbind('click').text('submitting...').addClass('submitting');
    var formData = {};

    $('h2.error').hide();
    $('.error_list').remove();

    // get the basic info
    formData[$('#newsAdd_F #news_title').attr('name')] = $('#newsAdd_F #news_title').val();
    formData[$('#newsAdd_F #news_content').attr('name')] = $('#newsAdd_F #news_content').val();
    formData[$('#newsAdd_F #news_source_name').attr('name')] = $('#newsAdd_F #news_source_name').val();
    formData[$('#news_source_url').attr('name')] = $('#news_source_url').val();
    formData[$('#newsAdd_F #news_image').attr('name')] = $('#newsAdd_F #news_image').val();
    formData[$('#newsAdd_F #news__csrf_token').attr('name')] = $('#newsAdd_F #news__csrf_token').val();

    // get the tag info
    formData['tags'] = {}
    $.each($('.tag_suggest .on, .tag_add_C .on'), function(index, val) {
      formData['tags'][index] = $(val).text();
    })

    // get the limelight info
    formData['limelights'] = {}
    $.each($('.limelight_add_C .on'), function(index, val) {
      formData['limelights'][index] = $(val).children('span.name').metadata().name;
    })

    $.post(self.metadata().url, formData, function(data) {
      if (data.result == 'error')
      {
        self.bind('click.submit', newsSubmit).text('submit news story').removeClass('submitting');

        // handle the basic info errors
        $('.news_add .error_list').remove();
        $.each(data.info_error, function(index, val) {
          if ($(val).error != '')
          {
            $('#news_'+val.name).before(val.error);
          }
        })

        // handle the tag errors
        if (data.tag_error == true)
          $('#news_tag').before('<ul class="error_list tags"><li>You must select between 3 and 10 tags. Selected tags have a solid green background. Click on tags to toggle between selected and deselected, or add new ones in the input box below. You currently have '+ $('.tag_suggest .on, .tag_add_C .on').length +' tags selected.</li></ul>').parent().parent().addClass('tags');
        else
          $('#news_tag').parent().parent().removeClass('tags');

        // handle the limelight errors
        if (data.limelight_error == true)
          $('#news_limelight').before('<ul class="error_list tags"><li>You must select between 1 and 5 limelights. Selected limelights have a solid green border. Click on limelights to toggle between selected and deselected, or add new ones in the input box below. You currently have '+ $('.limelight_add_C .on, .tag_add_C .on').length +' limelights selected.</li></ul>').parent().parent().addClass('limelights');
        else
          $('#news_limelight').parent().parent().removeClass('limelights');

        $.scrollTo($('.news_add .dont'), 500, {onAfter:function() {
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
        self.bind('click.submit', newsSubmit).text('submit news story').removeClass('submitting');
        authenticate();
      }
    }, 'json')
  };
  $('.news_add .submit').bind('click.submit', newsSubmit);

  // news add page image upload
  if ($('#news_add_image').length > 0) {
    $('#news_image').val('');
    $('#news_add_image').uploadify({
      'uploader'    : '/js/uploadify/uploadify.swf',
      'script'      : $('#news_add_image').metadata().url,
      'auto'        : true,
      'fileDesc'    : 'png, jpg, gif, jpeg',
      'fileExt'     : '*.png;*.jpg;*.gif;*.jpeg',
      'buttonImg'   : '/images/news_add_choose_image.gif',
      'width'       : 278,
      'height'      : 40,
      'sizeLimit'   : 2000000,
      'buttonText'  : 'choose image',
      'onComplete'  : function(a,b,c,d) {
        // hack to get around strange uploadify response data
        var data = d.split('$**$');
        data = JSON.parse(data[0]);
        $('#news_add_imageUploader').replaceWith('<img src="' + data.filePath + '" class="news_img rnd_3" />');
        $('#news_image').val(data.fileName);
      }
    });
  }

  // ********************

  // ********************
  // UTILITIES
  // ********************

  // Add title to items that have been dimmed, such as low scoring comments
  $('.dimmed').attr('title', 'This item is dimmed because its score is too low.');

  // Add title to future features
  $('.future_feature').attr('title', 'This feature is not yet implemented.').click(function() {return false;});

  // Add blind class to an element button, and the id of the element you wish
  // to toggle blind to the attribute blindElem.
  $(".blind_new").live('click', function() {
    var self = $(this);
    $(self.metadata().target).toggle('blind', 400);
    if (self.metadata().text) {
      var text = self.text();
      self.text(self.metadata().text);
      self.metadata().text = text;
    }
  });
  $(".blind").live('click', function() {
    var self = $(this);
    var elem = self.attr('blindElem');
    $('#'+elem).toggle('blind', 400);
    if (self.attr('blindText')) {
      var text = self.attr('blindText');
      self.attr('blindText', self.text());
      self.text(text);
    }
  });

  // Clear default values of inputs with input_clear class when focused on
  $('.input_clear').focus(function() {
    var self = $(this);
    if (self.metadata().cleared != 1)
      self.val('').removeClass('input_clear');
    self.metadata().cleared = 1;
  });

  // Length counter for form fields
  $('.length_counter').each(function(index,val) {
    var $self = $(this);
    var $max_length = $self.attr('maxlength');
    var $indicator_span = $($self.attr('lengthIndicator') + ' span');
    var $new_length;
    $indicator_span.text($self.val().length);
    $(val).live('keypress', function() {
      $new_length = $self.val().length;
      if ($new_length > $max_length) {
        $self.val($self.val().substring(0, $max_length));
      } else {
        $indicator_span.text($new_length);
      }
    })
  })
  $('.length_counter').live('keypress', function() {
    var max_length = $(this).attr('maxlength');
    var indicator_id = $(this).attr('lengthIndicator');
    var length = $(this).val().length;
    $(indicator_id).find('span').text(length);
    $(this).keyup(function() {
      var new_length = $(this).val().length;
      if (new_length > max_length) {
        $(this).val($(this).val().substring(0, max_length));
      } else {
        $(indicator_id).find('span').text(new_length);
      }
    });
  });

  // custon 'radio input' type functionality
  $('.radios > .radio').live('click', function() {
    var self = $(this);
    self.parent().children('.checked').removeClass('checked');
    self.addClass('checked');
  })

  // Used to check if the user is still logged in, every 15 min
//  $(this).everyTime(900000, function() {
//    if ($('#authURL').attr('name') == 'logged') {
//      $.ajax({
//        type: 'GET',
//        cache: false,
//        url: $('#authURL').val(),
//        success: function(text) {
//          if(text != 'authenticated') {
//            window.location = '/';
//          }
//        }
//      });
//    }
//  });

  // Pop up limelights feeds when the user hovers over the limelights tab on items
  $('.feed_lls').livequery(function() {$(this).hover(function() {$(this).children('.list').show()}, function() {$(this).children('.list').hide()})});

  // ********************
  // COMMENTS
  // *******************
  $('.addComment').livequery(function() {
    var self = $(this);
    var parent = self.metadata().parent;
    var age = self.metadata().age;
    self.ajaxify({
      form: '#commentAddF',
      target: self.metadata().target,
      onSuccess:function(options,data) {
        data = data.split('**');
        if (age == 0) {
          if (data[0] == 0)
            $('#c_add').html(data[1]);
          else
          {
            $('#c_count').text(parseInt($('#c_count').text()) + 1);
            $('#c_add').hide('blind', 300, function() {
              $(this).empty();
              $('#c_s').show('blind', 300, function() {
                $(this).oneTime(2500, function() {
                  $(this).fadeOut(400);
                });
              });
            });
            if ($('.p_comment').length > 0)
              $('.p_comment:last').after(data[1]);
            else
              $('.comment_list').append(data[1]);
          }
        } else {
          if (data[0] == 0)
            $('#c_reply_'+parent).html(data[1]);
          else
          {
            $('#c_count').text(parseInt($('#c_count').text()) + 1);
            $('#c_reply_'+parent).hide('blind', 300, function() {
              $(this).empty();

              if ($('.comment_child_'+parent).length == 0) {
                $('#c_success_'+parent).after(data[1]);
              } else
                $('.comment_child_'+parent+':last').after(data[1]);

              $('#c_success_'+parent).show('blind', function() {
                $(this).oneTime(2500, function() {
                  $(this).fadeOut(400);
                });
              });

            });
          }
        }
      }
    });
  });
  // END COMMENTS

});

// Show universal notice, type == 0 is bad, type == 1 is good
function displayNotice(text, type) {
  var elem;
  if (type == 0)
    elem = $('#ajax_error');
  else
    elem = $('#ajax_notice')

  elem.html(text).fadeIn(400, function() {
    $(this).oneTime(5000, function() {
      elem.fadeOut(400, function() {
        $(this).html('');
      });
    });
  });
}