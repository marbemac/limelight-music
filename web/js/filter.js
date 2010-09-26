$(document).ready(function(){
  // Color category expanders if a child category is selected
  $('.fltr_cat_child').each(function() {
    if ($(this).hasClass('selected'))
      $(this).parent().parent().addClass('fltr_cat_expand_on');
  });

  // ********************
  // FEED SHOW MORE
  // ********************
  $('#feed_more').live('click', function() {
    var self = $(this);
    var section = $(this).attr('section');
    $.ajax({
      type: 'GET',
      url: $('.fltr_button').attr('link'),
      data: "section="+section,
      beforeSend: function() { self.find('div').show(100); },
      complete: function() { self.find('div').hide(100); },
      success: function(html) {
        if (html != 0) {
          $('.feed_list').append('<span class="hide">' + html + '</span>');
          $('.feed_list > span:hidden').show('blind', 600)
          self.attr('section', parseInt($('#feed_more').attr('section'))+1);
        } else {
          self.unbind('click').attr('cursor', 'default').text('there are no more items that match the filters chosen');
        }
      }
    });
  });

  // ********************
  // FEED PROGRESS BAR
  // ********************
  $(document).bind("idle.idleTimer", function(){
    var pb = $('#feedProgressBar');
    var pb_width = pb.parent().width();
    if (pb.hasClass('feedProgressBarOn')) {
      pb.animate({width: 0}, 240000);
      pb.everyTime(240000, function() {
        $.ajax({
          type: 'GET',
          url: $('#ajaxFeedURL').val(),
          beforeSend: function() {
            $('#feed_ajax_spinner').show();
          },
          complete: function() {
            $('#feed_ajax_spinner').hide();
          },
          success: function(html) {
           $('#feed_more').attr('section', 1);
           $('#feed_content').fadeOut(600, function() {
             $(this).html(html);
             $(this).fadeIn(600);
           });
           pb.stop().animate({width: pb_width}, 1000).animate({width: 0}, 230000);
          }
        });
      });
    }
  });

  $(document).bind("active.idleTimer", function(){
    var pb = $('#feedProgressBar');
    pb.stopTime();
    pb.stop().animate({width: '100%'}, 700)
  });
  // END FEED PROGRESS BAR

  // ********************
  // FILTER FUNCTIONALITY
  // ********************
  function getSliderData (uiValue, days) {
    var tp;
    if (uiValue == 1 || days == 1) {
      uiValue = 1;
      tp = 'day';
      days = 1;
    } else if ((uiValue > 1 && uiValue < 7) || (uiValue == null && days < 7)) {
      if (uiValue)
      {
        tp = uiValue + ' days';
        days = uiValue;
      }
      else
      {
        tp = days + ' days';
        uiValue = days;
      }
    } else if (uiValue == 7 || (uiValue == null && days == 7)) {
      uiValue = 7;
      tp = '1 week';
      days = 7;
    } else if (uiValue == 8 || (uiValue == null && days <= 14)) {
      uiValue = 8;
      tp = '2 weeks';
      days = 14;
    } else if (uiValue == 9 || (uiValue == null && days <= 30)) {
      uiValue = 9;
      tp = '1 month';
      days = 30;
    } else if (uiValue == 10 || (uiValue == null && days <= 60)) {
      uiValue = 10;
      tp = '2 months';
      days = 60;
    } else if (uiValue == 11 || (uiValue == null && days <= 90)) {
      uiValue = 11;
      tp = '3 months';
      days = 90;
    } else if (uiValue == 12 || (uiValue == null && days <= 180)) {
      uiValue = 12;
      tp = '6 months';
      days = 180;
    } else if (uiValue == 13 || (uiValue == null && days <= 365)) {
      uiValue = 13;
      tp = '1 year';
      days = 365;
    } else if (uiValue == 14 || (uiValue == null && days == -1)) {
      uiValue = 14;
      tp = 'all time';
      days = -1;
    }
    var data = { "uiValue" : uiValue,
                 "tp" : tp,
                 "days" : days};

    return data;
  };

  $(".ci_slider").slider({
      value: $(".ci_slider").attr('name'),
      min: 1,
      max: 14,
      step: 1,
      slide: function(event, ui) {
        var data = getSliderData(ui.value, 0);
        $('.fltr_button').fadeTo(300, 1);
        $(this).prev().find('.fltr_text').text(data['tp']);
        $(this).attr('id', 'ci='+data['days']);
      }
  });
  $(".tp_slider").slider({
      value: $(".tp_slider").attr('name'),
      min: 1,
      max: 14,
      step: 1,
      slide: function(event, ui) {
        var data = getSliderData(ui.value, 0);
        $('.fltr_button').fadeTo(300, 1);
        $(this).prev().find('.fltr_text').text(data['tp']);
        $(this).attr('id', 'tp='+data['days']);
      }
  });

  $('.fltr_item').click(function() {
    $('.fltr_button').fadeTo(300, 1);
    if($(this).hasClass('fltr_type')) {
      if ($(this).hasClass('fltr_a')) {
        if ($('.fltr_a_c').hasClass('hide')) {
          if (!$('.fltr_ll_c').hasClass('hide')) {
            $('.fltr_ll_c').slideUp(350, function() {
              $('.fltr_a_c').slideDown(350).removeClass('hide');
            }).addClass('hide');
          } else if (!$('.fltr_n_c').hasClass('hide')) {
            $('.fltr_n_c').slideUp(350, function() {
              $('.fltr_a_c').slideDown(350).removeClass('hide');
            }).addClass('hide');
          }
          $('.fltr_item_a:first').addClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
          $('.fltr_item_ll, .fltr_item_n').removeClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
        }
      }
      if ($(this).hasClass('fltr_ll')) {
        if ($('.fltr_ll_c').hasClass('hide')) {
          if (!$('.fltr_a_c').hasClass('hide')) {
            $('.fltr_a_c').slideUp(350, function() {
              $('.fltr_ll_c').slideDown(350).removeClass('hide');
            }).addClass('hide');
          } else if (!$('.fltr_n_c').hasClass('hide')) {
            $('.fltr_n_c').slideUp(350, function() {
              $('.fltr_ll_c').slideDown(350).removeClass('hide');
            }).addClass('hide');
          }
          $('.fltr_item_ll:first').addClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
          $('.fltr_item_a, .fltr_item_n').removeClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
        }
      }

      if ($(this).hasClass('fltr_n')) {
        if ($('.fltr_n_c').hasClass('hide')) {
          if (!$('.fltr_a_c').hasClass('hide')) {
            $('.fltr_a_c').slideUp(350, function() {
              $('.fltr_n_c').slideDown(350).removeClass('hide');
            }).addClass('hide');
          } else if (!$('.fltr_ll_c').hasClass('hide')) {
            $('.fltr_ll_c').slideUp(350, function() {
              $('.fltr_n_c').slideDown(350).removeClass('hide');
            }).addClass('hide');
          }
          $('.fltr_item_n:first').addClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
          $('.fltr_item_a, .fltr_item_ll').removeClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
        }
      }

      $('.fltr_type').removeClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
      $(this).addClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
      if ($('#tp_filter').hasClass('hide'))
        $('#tp_filter').slideDown(300).removeClass('hide');
    }
    if($(this).hasClass('fltr_sb')) {
      $('.fltr_sb').removeClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
      $(this).addClass('fltr_item_bg rnd3_10 ie_g_3_10 selected');
      if ($(this).hasClass('fltr_date')) {
        $('#tp_filter').slideUp(300).addClass('hide');
      } else {
        if ($('#tp_filter').hasClass('hide'))
          $('#tp_filter').slideDown(300).removeClass('hide');
      }
    }
  });

  // Category Filters
  $('.fltr_cat_all_C').click(function() {
    $('.fltr_button').fadeTo(300, 1);
    if (!$(this).hasClass('selected')) {
      $(this).addClass('fltr_cat_all_bg ie_7 selected');
      $('.fltr_cat_parent, .fltr_cat_child').removeClass('fltr_cat_parent_bg fltr_cat_child_bg ie_7 selected');
      $('.fltr_cat_expand').removeClass('fltr_cat_expand_on');
    }
  });
  $('.fltr_cat_parent').click(function() {
    $('.fltr_button').fadeTo(300, 1);
    $('.fltr_cat_all_C').removeClass('fltr_cat_all_bg ie_7 selected');
    if ($(this).hasClass('selected')) {
      $(this).removeClass('fltr_cat_parent_bg ie_7 selected');
      $(this).next().removeClass('fltr_cat_expand_on').find('.fltr_cat_child').removeClass('fltr_cat_child_bg ie_7 selected');
    } else {
      $(this).addClass('fltr_cat_parent_bg ie_7 selected');
      $(this).next().addClass('fltr_cat_expand_on').find('.fltr_cat_child').addClass('fltr_cat_child_bg ie_7 selected');
    }
  });
  $('.fltr_cat_child').click(function() {
    $('.fltr_button').fadeTo(300, 1);
    $('.fltr_cat_all_C').removeClass('fltr_cat_all_bg ie_7 selected');
    $(this).parent().parent().addClass('fltr_cat_expand_on');
    if ($(this).hasClass('selected')) {
      $(this).removeClass('fltr_cat_child_bg ie_7 selected');
      $(this).parent().parent().prev().removeClass('fltr_cat_parent_bg ie_7 selected');
      if (!$(this).siblings().hasClass('selected'))
        $(this).parent().parent().removeClass('fltr_cat_expand_on');
    } else {
      $(this).addClass('fltr_cat_child_bg ie_7 selected');
      if (!$(this).siblings('.fltr_cat_child:not(.selected)').length)
        $(this).parent().parent().prev().addClass('fltr_cat_parent_bg ie_7 selected');
    }
  });
  $('.fltr_cat_expand').hover(function() {
    $(this).stopTime();
    $(this).find('.fltr_cat_child_C').fadeIn(130);
  }, function() {
    $(this).oneTime(500, function() {
      $(this).find('.fltr_cat_child_C').fadeOut(130);
    });
  });

  // Filter ajax function, to update session and reload page
  $('#fltr_button').livequery(function() {
    $(this).ajaxify({
      fade: true,
      fadeOut: 0,
      fadeSpeed: 200,
      single: false,
      show_loader: true,
      target: '#feed_content',
      params: function() {
      var fltrs = $('.fltr_item').filter('.selected');
      var catfltrs = $('.fltr_cat_parent, .fltr_cat_child').filter('.selected');
      var cifltr = $('.ci_slider').attr('id');
      var tpfltr = $('.tp_slider').attr('id');

      var filterString = '';
      $.each(fltrs, function(i, val) {
        filterString += val.id + '&';
      });

      var catString = '';
      var tempCat;
      $.each(catfltrs, function(i, val) {
        tempCat = val.id.split('_');
        catString += tempCat[1] + '-';
      });
      if (catString == '') catString = 0;
      filterString += 'c=' + catString + '&' + cifltr + '&' + tpfltr;
      return filterString;
    }
    });
  });
  // END FILTER FUNCTIONALITY
});