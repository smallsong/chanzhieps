$.extend(
{
    setAjaxForm: function(formID, callback)
    {
        form = $(formID); 

        var options = 
        {
            target  : null,
            timeout : 30000,
            dataType:'json',
            
            success: function(response)
            {
                $.enableForm(formID);

                /* The response is not an object, some error occers, bootbox.alert it. */
                if($.type(response) != 'object')
                {
                    if(response) return bootbox.alert(response);
                    return bootbox.alert('No response.');
                }

                /* The response.result is success. */
                if(response.result == 'success')
                {
                    if($.isFunction(callback)) return callback(response);
                    if($('#responser').length && response.message && response.message.length)
                    {
                        $('#responser').html(response.message).addClass('text-error f-12px').show().delay(3000).fadeOut(100);
                    }

                    if(response.locate) return location.href = response.locate;
                }

                /**
                 * The response.result is fail. 
                 */

                /* The result.message is just a string. */
                if($.type(response.message) == 'string')
                {
                    if($('#responser').length == 0) return bootbox.alert(response.message);
                    return $('#responser').html(response.message).addClass('text-error f-12px').show().delay(5000).fadeOut(100);
                }

                /* The result.message is just a object. */
                if($.type(response.message) == 'object')
                {
                    $.each(response.message, function(key, value)
                    {
                        /* Define the id of the error objecjt and it's label. */
                        var errorOBJ   = '#' + key;
                        var errorLabel =  key + 'Label';

                        /* Create the error message. */
                        var errorMSG = '<label id="'  + errorLabel + '" for="' + key  + '"  class="text-error">';
                        errorMSG += $.type(value) == 'string' ? value : value.join(';');
                        errorMSG += '</label>';

                        /* Append error message, set style and set the focus events. */
                        $('#' + errorLabel).remove(); 
                        $(errorOBJ).parent().append(errorMSG);
                        $(errorOBJ).css('margin-bottom', 0);
                        $(errorOBJ).css('border-color','#953B39')
                        $(errorOBJ).change(function()
                        {
                            $(this).removeAttr('style')
                            $('#' + errorLabel).remove(); 
                        });
                    })

                    /* Focus the first error field thus to nitify the user. */
                    var firstErrorField = $('#' +$('label.text-error').first().attr('for'));
                    topOffset = parseInt(firstErrorField.offset().top) - 20;   // 20px offset more for margin.

                    /* If there's the navbar-fixed-top element, minus it's height. */
                    if($('.navbar-fixed-top').size())
                    {
                        topOffset = topOffset - parseInt($('.navbar-fixed-top').height());
                    }
                    
                    /* Scroll to the error field and foucus it. */
                    $(document).scrollTop(topOffset);
                    firstErrorField.focus();
                }
            },

            /* When error occers, alert the response text, status and error. */
            error: function(jqXHR, textStatus, errorThrown)
            {
                $.enableForm(formID);
                bootbox.alert(jqXHR.responseText + textStatus + errorThrown);
            }
        };

        /* Call ajaxSubmit to sumit the form. */
        form.submit(function()
        { 
            $.disableForm(formID);
            $(this).ajaxSubmit(options);
            return false;    // Prevent the submitting event of the browser.
        });
    },

    /* Switch the label and disabled attribute for the submit button in a form. */
    setSubmitButton: function(formID, action)
    {
        var submitButton = $(formID).find(':submit');

        label    = submitButton.val();
        loading  = submitButton.data('loading');
        disabled = action == 'disable';

        submitButton.attr('disabled', disabled);
        submitButton.val(loading);
        submitButton.data('loading', label);
    },

    /* Disable a form. */
    disableForm: function(formID)
    {
        $.setSubmitButton(formID, 'disable');
    },
    
    /* Enable a form. */
    enableForm: function(formID)
    {
        $.setSubmitButton(formID, 'enable');
    }
});

$.extend(
{
    /**
     * Set ajax loader.
     * 
     * Bind click event for some elements thus when click them, 
     * use $.load to load page into target.
     *
     * @param string selector
     * @param string target
     */
    setAjaxLoader: function(selector, target)
    {
        var target = $(target);
        if(!target.size()) return false;

        $(document).on('click', selector, function()
        {
            url = $(this).attr('href');
            if(!url) url = $(this).data('rel');
            if(!url) return false;

            target.load(url);

            return false;
        });
    },

    /**
     * Set ajax jsoner.
     *
     * @param string   selector
     * @param object   callback
     */
    setAjaxJSONER: function(selector, callback)
    {
        $(document).on('click', selector, function()
        {
            /* Try to get the href of current element, then try it's data-rel attribute. */
            url = $(this).attr('href');
            if(!url) url = $(this).data('rel');
            if(!url) return false;
            
            $.getJSON(url, function(response)
            {
                /* If set callback, call it. */
                if($.isFunction(callback)) return callback(response);

                /* If the response has message attribute, show it in #responser or alert it. */
                if(response.message)
                {
                    if($('#responser').length)
                    {
                        $('#responser').html(response.message);
                        $('#responser').addClass('text-info f-12px');
                        $('#responser').show().delay(3000).fadeOut(100);
                    }
                    else
                    {
                        bootbox.alert(response.message);
                    }
                }

                /* If target and source returned in reponse, update target with the source. */
                if(response.target && response.source)
                {
                    $(response.target).load(response.source);
                }
            });

            return false;
        });
    },

    /**
     * Set ajax deleter.
     * 
     * @param  string $selector 
     * @access public
     * @return void
     */
    setAjaxDeleter: function (selector)
    {
        $(document).on('click', selector, function()
        {
            if(confirm(v.lang.confirmDelete))
            {
                var deleter  = $(this);
                deleter.text(v.lang.deleteing);

                $.getJSON(deleter.attr('href'), function(data) 
                {
                    if(data.result=='success')
                    {
                        if(deleter.parents('#ajaxModal').size()) return $.reloadAjaxModal();
                        return location.reload();
                    }
                    else
                    {
                        alert(data.message);
                    }
                });
            }
            return false;
        });
    },

    /**
     * Add ajaxModal container if there's an <a> tag with data-toggle=modal.
     * 
     * @access public
     * @return void
     */
    setAjaxModal: function()
    {
        if($('a[data-toggle=modal]').size() == 0) return false;

        /* Addpend modal div. */
        var div = $('<div id="ajaxModal" class="modal hide fade" tabindex="-1"></div>');
        div.appendTo('body');

        /* Set the data target for modal. */
        $('a[data-toggle=modal]').attr('data-target', '#ajaxModal');

        $('a[data-toggle=modal]').click(function()
        {
            /* Save the href to rel attribute thus we can save it. */
            $('#ajaxModal').attr('rel', $(this).attr('href'));

            /* Set the width and margin of modal. */
            modalWidth      = 580;
            modalMarginLeft = 280;
            
            /* User can customize the width by data-width=600. */
            if($(this).data('width'))
            {
                modalWidth  = parseInt($(this).data('width')); 
                modalMarginLeft = (modalWidth - 580) / 2 + 280;
            }

            /* Set the width and margin-left styles. */
            $('#ajaxModal').css('width',modalWidth);
            $('#ajaxModal').css('margin-left', '-' + modalMarginLeft + 'px')

            /* Load the target url in modal. */
            $('#ajaxModal').load($(this).attr('href')); 
        });  
    },

    /**
     * Reload ajax modal.
     *
     * @access public
     * @return void
     */
    reloadAjaxModal: function()
    {
        $('#ajaxModal').load($('#ajaxModal').attr('rel'));
    }
});
