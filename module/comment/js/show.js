$(document).ready(function()
{
    $('#content').change(function()
    {
        $.post(createLink('comment', 'captcha'), {content:$(this).val()}, function(data)
        {
            $('#checkCode').html(data).fadeIn();
        });

    });

    $.setAjaxForm('#commentForm', function(data)
    {
        if(data.result=='success' && $.type(data.message) != 'object')
        {
            bootbox.alert(data.message, function()
            {
                var link = createLink('comment', 'show', 'objecType=' + v.objectType + '&objectID=' + v.objectID);
                $('#commentForm').parent().parent().load(link, location.href="#first");
            });   
        }
        else
        {
            bootbox.alert(data.message.notice, function()
            {
                $('#checkCode').load(createLink('comment', 'checkCode')).show();
            });
        }
    });
    
    $('#pager').find('a').click(function()
    {
        $('#commentList').parent().load($(this).attr('href'));
        return false;
    });
});
