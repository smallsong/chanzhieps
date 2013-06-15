$(function()
{
    if(config.runMode == 'admin')
    {
        $('#account').focus();
    }
})

successFun = function(data)
{
     if(data.status = 1)
     {
          alert(data.message);
     }
     else
     {
          location.href = data.locateTo;
     }
}

$.ajaxForm('.form-signin', {success:successFun, validate:true, dataType: 'json'});

