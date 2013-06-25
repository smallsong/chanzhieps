$.extend(
{
    ajaxForm: function(formID, callback)
    {
        form = $(formID); 
        var options = 
        {
            target  : null,
            timeout : 30000,
            dataType:'json',

            success:function(response)
            {
                $.enableForm(formID);

                if($.type(response) == 'object')
                {
                    if(response.result == 'success')
                    {
                        if($.isFunction(callback)) return callback(response);
                        if(response.locate) location.href = response.locate;
                    }
                    else
                    {
                        alert(response.message);
                    }
                }
                else
                {
                    if(response) return alert(response);
                    return alert(v.lang.noResponse);
                }
            },

            error:function(jqXHR, textStatus, errorThrown)
            {
                $.enableForm(formID);
                alert(a.responseText + textStatus + errorThrown);
            }

        };

        form.submit(function()
        { 
             $(this).ajaxSubmit(options);
             return false; 
         });
    },

    disableForm:function(formID)
    {
        $(formID).find(':submit').attr('disabled', true);
    },
    
    enableForm:function(formID)
    {
        $(formID).find(':submit').attr('disabled', false);
    }
});

$(document).ready(function()
{
    $.ajaxForm('#ajaxForm')
})
