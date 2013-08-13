$(document).ready(function()
{
    /* Set forbid link options. */
    $('td.operate a').click(function()
    {
        $.getJSON($(this).attr('href'),function(data)
        {
            bootbox.alert(data.message);
        });
        return false;
    });

    $('.form-search').submit(function()
    {
        var inputValue = $(".search-query").val();
        if(inputValue == '')
        {
            alert('请输入用户名');
            return false;
        }
    });
              
});
