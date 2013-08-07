$(document).ready(function()
{
    $(v.currentMenu).parent('li').addClass('active');
    
    /* Set the orginal and copySite, copyURL fields. */
    $('#original').change(function()
    {
        $('#copyBox').hide().find(':input').attr('disabled', true);
        if($(this).val() == 0) $('#copyBox').show().find(':input').attr('disabled', false);
    });
    $('#original').change();
});
