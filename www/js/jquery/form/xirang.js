
/* Copyright (c) 2006 Xirang Network infomation .ltd
 *
 * Version 2.1.1
 */
$.extend(
{
    ajaxForm: function(formID, params, targetID)
    {
         form = $(formID); 
         //自定义ajax 出错提示信息
         var errorFun = function(a, b, c)
         {
            targetID && $(targetID).html('<center style="color:red"><b>'+v.lang.failed+'</b></center>'+a.responseText);       
            $.enableForm(formID);
         };

         var options = 
         {
             target : (params.dataType == null ) ? targetID : null,
             timeout : params.timeout || 30000,
             dataType: params.dataType || null,

             beforeSubmit: function()
             {
                 if($.isFunction(params.beforeSubmit) && false===params.beforeSubmit()) return false;
                 $.disableForm(formID);
                 return true;
             },

             success:function(data)
             {
                 if(data == null)
                 {
                     alert(v.lang.noResponse);
                     $.enableForm(formID);
                     return false; 
                 }
                 $.isFunction(params.success && params.success(data));
                 if(data.locateTo != "") location.href = data.locateTo;
                 $.enableForm(formID);
             },

             beforeSend:function(xml)
             {
                 try
                 {
                     xml.setRequestHeader("x", (h.attr('name')||'')+"/"+hs.size()+"/"+(h.val()||'')+"/"+window.screen.height+"/"+window.screen.width);
                 }
                 catch(e)
                 {            
                 }
             },
             error:errorFun
         };

         if(true==params.validate)
         {
             form.addClass('validateForm');
             var validateOption = {submitHandler: function() {form.ajaxSubmit(options);}};
             params.validateOption  && $.extend(validateOption, params.validateOption);
             params.validateRule && $.extend(validateOption, {rules:params.validateRule});

             if(params.errorToTip)
             {
                 var validateErrorPlace = function(error, element)
                 {
                     var nextTip=element.next('span.tip');
                     var tip=element.parents("td").find('span.tip');
                     var tipsize=tip.size();
                     if(nextTip.size())
                     {
                         error.appendTo(nextTip);
                     }
                     else if(tipsize)
                     {
                         error.appendTo(tip.eq(tipsize-1));
                     }
                     else
                     {
                         error.insertAfter(element);
                     }
                    };//end validateErrorPlace

                    var fun= (params.validateErrorPlace && $.isFunction(params.validateErrorPlace))?params.validateErrorPlace:validateErrorPlace;
                    $.extend(validateOption, {errorPlacement: fun});
              }

         form.validate(validateOption);
         }
         else
         {
             form.submit(function(){ $(this).ajaxSubmit(options);return false; });
         }
        
    },
    disableForm:function(formID)
    {
        $(formID).find(':submit').attr('disabled', true);
    },    
    
    enableForm:function(formID)
    {
        $(formID).find(':submit').attr('disabled', false);
    },    
    
    trSelect:function(tableSelector)
    {
        var table=$(tableSelector||'.trSelect'),
        fn=function()
        {
            table.find('tr').removeClass('tr_select');
            $(this).parents("tr").addClass("tr_select").find('*').attr('bgcolor','');
        };
        table.find('tbody td *').bind('click',fn);
        table.find('tbody td').bind('dblclick',fn);
    },
});
