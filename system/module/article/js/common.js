$(document).ready(function()
{
    /* Set the orginal and copySite, copyURL fields. */
    $('#original').change(function()
    {
        $('#copyBox').hide().find(':input').attr('disabled', true);
        if($(this).val() == 0) $('#copyBox').show().find(':input').attr('disabled', false);
    });
    
    /* Set current active topNav. */
    if(v.path && v.path.length)
    {
        $.each(eval(v.path), function(index, category) 
        { 
            $('.nav-article-' + category).addClass('active');
        })
    }
});
