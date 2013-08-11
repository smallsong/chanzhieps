$(document).ready(function()
{   
    $.setAjaxForm('#slideForm', function(response)
    {
        if(response.result == 'success') 
        {
            location.reload();
        }
        else
        {
            alert(response.message);
        }
    }); 
});
