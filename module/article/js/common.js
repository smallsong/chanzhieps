$(document).ready(function()
{
    /* Set the orginal and copySite, copyURL fields. */
    $('#original').change(function()
    {
        $('#copyBox').hide().find(':input').attr('disabled', true);
        if($(this).val() == 0) $('#copyBox').show().find(':input').attr('disabled', false);
    });
    
    /* Set current active mainNav. */
    if(v.categoryPath.length)
    {
        $.each(eval(v.categoryPath), function(index, category) 
        { 
            $('#mainNav .article_' + category).addClass('active');
        })
    }
});
