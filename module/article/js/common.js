$(document).ready(function()
{
  $(v.currentMenu).parent('li').addClass('active');

  $('#original').change(function()
  {
      $('#copyBox').hide().find(':input').attr('disabled', true);
      if($(this).val() == 0) $('#copyBox').show().find(':input').attr('disabled', false);
  });

  $('#original').change();
});
