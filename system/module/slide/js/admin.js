$(document).ready(function()
{
    $.setAjaxForm('#sortForm', function(response)
    {
        bootbox.alert(response.message);
    });

    $('.icon-arrow-up').click(function()
    {
        $(this).parents('tr').prev().before($(this).parents('tr'));
        sort();
    });

    $('.icon-arrow-down').click(function()
    {
        $(this).parents('tr').next().after($(this).parents('tr'));
        sort();
    });
    
});

function sort()
{
    $('input[name*=order]').each(function(index, obj) { $(this).val(index + 1); });
}
