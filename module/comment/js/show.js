$(document).ready(function()
{
    $.setAjaxForm('#commentForm', function(response)
    {
        if(response.result == 'success')
        {
            bootbox.alert(response.message, function()
            {
                var link = createLink('comment', 'show', 'objecType=' + v.objectType + '&objectID=' + v.objectID);
                $('#commentForm').parent().parent().load(link, location.href="#first");
            });   
        }
        else
        {
            if(response.reason == 'needChecking')
            {
                $('#captchaBox').html(response.captcha).show();
            }
        }
    });

    $('#pager').find('a').click(function()
    {
        $('#commentList').parent().load($(this).attr('href'));
        return false;
    });
});
