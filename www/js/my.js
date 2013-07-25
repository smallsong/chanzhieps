/**
 * Create link. 
 * 
 * @param  string $moduleName 
 * @param  string $methodName 
 * @param  string $vars 
 * @param  string $viewType 
 * @access public
 * @return string
 */
function createLink(moduleName, methodName, vars, viewType)
{
    if(!viewType) viewType = config.defaultView;
    if(vars)
    {
        vars = vars.split('&');
        for(i = 0; i < vars.length; i ++) vars[i] = vars[i].split('=');
    }
    if(config.requestType == 'PATH_INFO')
    {
        link = config.webRoot + moduleName + config.requestFix + methodName;
        if(vars)
        {
            if(config.pathType == "full")
            {
                for(i = 0; i < vars.length; i ++) link += config.requestFix + vars[i][0] + config.requestFix + vars[i][1];
            }
            else
            {
                for(i = 0; i < vars.length; i ++) link += config.requestFix + vars[i][1];
            }
        }
        link += '.' + viewType;
    }
    else
    {
        link = config.router + '?' + config.moduleVar + '=' + moduleName + '&' + config.methodVar + '=' + methodName + '&' + config.viewVar + '=' + viewType;
        if(vars) for(i = 0; i < vars.length; i ++) link += '&' + vars[i][0] + '=' + vars[i][1];
    }
    return link;
}

/**
 * Set the ping url to keep the session.
 * 
 * @access public
 * @return void
 */
function setPing()
{
    $('#hiddenwin').attr('src', createLink('misc', 'ping'));
}

/**
 * Set required fields, add star class to them.
 *
 * @access public
 * @return void
 */
function setRequiredFields()
{
    if(!config.requiredFields) return false;
    requiredFields = config.requiredFields.split(',');
    for(i = 0; i < requiredFields.length; i++)
    {
        $('#' + requiredFields[i]).after('<span class="star"> * </span>');
    }
}

/**
 * Set the max with of image.
 * 
 * @access public
 * @return void
 */
function setImageSize(image, maxWidth)
{
    $(image).css('border', '1px solid gray');    // add a border to it.

    if(!maxWidth) maxWidth = 700;   // In the page js, should define the maxWidth in int.
    if($(image).width() > maxWidth) $(image).attr('width', maxWidth);
    $(image).wrap('<a href="' + $(image).attr('src') + '" target="_blank"></a>')
}

/**
 * Set the leftmenu for admin.
 * 
 * @access public
 * @return void
 */
function setAdminLeftMenu()
{
    if($('ul.leftmenu').find('a').size()==1)
    {
        $('ul.leftmenu').find('a').addClass('radius');
        return ;
    }
    $('ul.leftmenu').find('a').last().addClass('radius-bottom');
    $('ul.leftmenu').find('a').first().addClass('radius-top');
}
 
/**
 * reloadAjaxModal.
 *
 * @access public
 * @return void
 */
function reloadAjaxModal()
{
    $('#ajaxModal').load($('#ajaxModal').attr('rel'));
}

$(document).ready(function() 
{
    setRequiredFields();
    needPing = config.runMode == 'admin' ? true : false;
    if(needPing) setTimeout('setPing()', 100 * 60 * 5);

    setAdminLeftMenu();

    /* ajax delete. */
    $(document).on('click', 'a.delete', 
      function(element)
      {
        if(confirm(v.lang.confirmDelete))
        {
            delUrl = $(this).attr('href');
            $(this).text(v.lang.deleteing);
            $.getJSON(delUrl,function(data) 
            {
                if(data.result=='success')
                {
                    if($(element.target).is('#ajaxModal a.delete'))
                    {
                        reloadAjaxModal();
                    }
                    else
                    {
                        location.reload();
                    }
                }
                else
                {
                    alert(data.message);
                }
            });
        }
        return false;
    });

    $('a.ajaxLink').click(function()
    {
        url = $(this).attr('href');
        $.getJSON(url, function(data) 
        {
            if(data.result=='success')
            {
                location.reload();
            }
            else
            {
                alert(data.message);
            }
        });
        return false;
    });
   
    /**
     * add ajaxModal container if there'are ajax modal a button.
     * bind click option to a[data-toggle=moadl.
     * record modal's location to modal's rel attribut.
     * resize and adjust modal position.
     */
    if($('a[data-toggle=modal]').size())
    {
        var div = $('<div id="ajaxModal" name="ajaxModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >kjgbkjjkg</div>');
        div.appendTo('body');
        $('a[data-toggle=modal]').attr('data-target', '#ajaxModal');
        $('a[data-toggle=modal]').click(function()
        {
            modalWidth      = 580; //extends bootstrap default modal width.
            modalMarginLeft = 280; //extends bootstrap default modal margin-left value.
            url = $(this).attr('href');
            if($(this).attr('w'))
            {
                modalWidth  = $(this).attr('w'); 
                modalMarginLeft = parseInt($(this).attr('w')-580)/2 + 280;
            }
            $('#ajaxModal').attr('rel', url);                                //set rel for reloadAjaxModal. 
            $('#ajaxModal').css('width',modalWidth);                         //resize modal width. 
            $('#ajaxModal').css('margin-left', '-' + modalMarginLeft + 'px') //fix modal margin-left.
            $('#ajaxModal').load(url); 
        });  
    }
})
