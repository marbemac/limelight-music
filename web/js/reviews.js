$(document).ready(function(){

  $('.scoreBar').each(function() {
    $(this).animate({width: $(this).attr('s_score')+'%'}, 1500);
  });

  $('.scoreWeight').live('click', function() {
    var self = $(this);
    var parent = self.parent();
    var sb = parent.find('.scoreBar');
    var sbT = parent.find('.scoreText').text();
    var score;

    if (sbT == sb.attr('s_score')+'%')
      score = sb.attr('w_score');
    else
      score = sb.attr('s_score');

    parent.find('.scoreWeight_on').removeClass('scoreWeight_on').addClass('scoreWeight');
    self.removeClass('scoreWeight').addClass('scoreWeight_on');
    sb.animate({width: score+'%'}, 800);
    parent.find('.scoreText').text(score+'%');
  });

  $(".score_slider").livequery(function() {
    var self = $(this);
    self.slider({
      value:1,
      range: 'min',
      animate: true,
      min: 1,
      max: 100,
      step: 1,
      slide: function(event, ui) {
        self.attr('data-score', ui.value);
        self.next().text(ui.value);
      }
    });
  });

  $(".c_avg,.ll_avg").livequery(function() {
    var self = $(this);
    self.each(function() {
      var average = self.attr('title');
      self.animate({'left': average+'%'}, 1000);
    });
  });

  $(".rvw_S").live('click', function() {
    var self = $(this);
    
    // check for errors
    var title = $('#limelight_user_review_title').val();
    var content = $('#limelight_user_review_content').val();
    var errorFlag = 0;
    var errorText = '';
    if (title.length < 5 || title.length > 50)
    {
      errorFlag = 1;
      errorText += '<div class="error">The title must have between 5 and 50 characters.</div>';
    }
    if (content.length < 20 || content.length > 1000)
    {
      errorFlag = 1;
      errorText += '<div class="error">The content must have between 20 and 1000 characters.</div>';
    }
    if (errorFlag)
    {
      $('.error').remove();
      $('.rvw_S').before(errorText);
      return 0;
    }
    else
      $('.error').remove();

    // check for warnings
    var warnFlag = 0;
    var warnText = '';
    $('.score_slider').each(function() {
      if ($(this).attr('data-score') == 1)
      {
        warnFlag = 1;
        warnText += '<div class="warning">You gave the score category \'' + $(this).prev().text() + '\' a score of 1</div>';
      }
    });
    if (warnFlag && $('.warning').length == 0)
    {
      warnText += '<div class="warning">Did you forget to score the above categories? If this is on purpose, simply press submit again</div>';
      $('.rvw_S').before(warnText);
      return 0;
    }

    // create the json structure to hold the form data
    var scores = '{';
    $('.score_slider').each(function(i) {
      scores += "\"" + $(this).attr('data-cid') + "\":" + $(this).attr('data-score') + ",";
    });
    scores = scores.substring(0, scores.length-1);
    scores += '}'
    var data =
      {
        "title"   : title,
        "content" : content,
        "ll_id"   : $('.rvw_T').attr('data-llid'),
        "overall" : $('#last').find('.score_slider').attr('data-score')
      };
    data['scores'] = scores;

    self.text("submitting your review...")

    $.ajax({
      type: 'POST',
      cache: false,
      url: self.attr('data-action'),
      data: data,
      success: function(text) {
        window.location = text;
      }
    });
  });

  $('.reviewE').livequery(function() {
    $(this).editable(function(){
        // function that will be called when the
        // user finishes editing and clicks outside of editable area
        var self = $(this);

        $.ajax({
          type: "GET",
          url: $('.rvws_uC').attr('data-action'),
          data: "id=" + self.attr('id') + "&content=" + self.html(),
          success: function(){
            self.animate({ borderTopColor: "green", borderLeftColor: "green", borderRightColor: "green", borderBottomColor: "green" }, 500);
          }
        });
    });
  });

  $('.review_sort').click(function() {
    var self = $(this);

    if (self.hasClass('sort_on'))
      return 0;

    $.ajax({
      type: "GET",
      url: self.attr('data-action'),
      success: function(text){
        self.parent().find('.sort_on').removeClass('sort_on');
        self.addClass('sort_on');
        $('.rvws_U').fadeOut(300, function() {
          $(this).html(text).fadeIn(300);
        });
      }
    });
  });

  $('.feed_more').live('click', function() {
    var self = $(this);
    var section = self.attr('data-section');
    $.ajax({
      type: 'GET',
      url: $('.sort_on').attr('data-action'),
      data: "s="+section,
      beforeSend: function() { self.find('div').show(100); },
      complete: function() { self.find('div').hide(100); },
      success: function(html) {
        if (html != 0) {
          self.before('<span class="hide"><div class="divider"></div>' + html + '</span>');
          $('.rvws_U > span:hidden').find('.feed_more').remove();
          $('.rvws_U > span:hidden').show('blind', 600);
          self.attr('data-section', parseInt(self.attr('data-section'))+1);
        } else {
          self.unbind('click').attr('cursor', 'default').text('there are no more reviews');
        }
      }
    });
  });

});