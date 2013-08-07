$(document).ready(function()
{
    $('td.operate a').click(function()
    {
        $.getJSON($(this).attr('href'),function(data)
        {
            bootbox.alert(data.message);
        });
        return false;
    });
});
