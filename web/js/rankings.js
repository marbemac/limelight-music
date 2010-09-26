$(document).ready(function(){
  // How often to check for new rankings for 1 day boxes? 25 seconds
  $('#timer_1').everyTime(25000, function() {
    var self = $(this);
    $.ajax({
      type: 'GET',
      dataType: 'json',
      cache: false,
      url: self.attr('link'),
      success: function(data) {
        updateRankings(data['users'], 'users', self.attr('period'));
        updateRankings(data['limelights'], 'limelights', self.attr('period'));
        updateRankings(data['news'], 'news', self.attr('period'));
      }
    });
  });

  // How often to check for new rankings for 1 day boxes? 1 minute 15 seconds
  $('#timer_7').everyTime(75000, function() {
    var self = $(this);
    $.ajax({
      type: 'GET',
      dataType: 'json',
      cache: false,
      url: self.attr('link'),
      success: function(data) {
        updateRankings(data['users'], 'users', self.attr('period'));
        updateRankings(data['limelights'], 'limelights', self.attr('period'));
        updateRankings(data['news'], 'news', self.attr('period'));
      }
    });
  });

  // How often to check for new rankings for 1 day boxes? 5 minutes
  $('#timer_30').everyTime(300000, function() {
    var self = $(this);
    $.ajax({
      type: 'GET',
      dataType: 'json',
      cache: false,
      url: self.attr('link'),
      success: function(data) {
        updateRankings(data['users'], 'users', self.attr('period'));
        updateRankings(data['limelights'], 'limelights', self.attr('period'));
        updateRankings(data['news'], 'news', self.attr('period'));
      }
    });
  });

  function updateRankings(data, type, period)
  {
    $('#'+type+'_'+period).find('li').each( function(i) {
      var li = $(this);
      if (li.attr('id') != data[i]['id'] || (li.attr('id') == data[i]['id'] && li.find('.change').text() != data[i]['change']))
      {
        if (li.find('.change').text() != data[i]['change'])
        {
          li.fadeOut(200, function() {
            li.replaceWith(data[i]['item']).fadeIn(200);
          });
        }
        else
          li.replaceWith(data[i]['item']);
      }
    });
  }

});