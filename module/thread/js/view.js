function checkGarbage(id)
{
  yzm     = $('#yzm').val();
  content = $('#' + id).val();
  $.post(createLink('comment', 'isGarbage'), {content:content, yzm:yzm}, function(data)
      {
          if(data == 1)
          {
            $('#yz').empty();
            $('#yz').html($('#zbyz').html() + '<br />');
          }
      });
}

$(document).ready(function()
{
    $.ajaxForm('#reply');   
});
