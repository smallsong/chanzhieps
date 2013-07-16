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
    $('ul.leftmenu').find('a').last().addClass('radius-bottom');
    $('ul.leftmenu').find('a').first().addClass('radius-top');
}

$(document).ready(function() 
{
    setRequiredFields();
    needPing = config.runMode == 'admin' ? true : false;
    if(needPing) setTimeout('setPing()', 100 * 60 * 5);

    setAdminLeftMenu();

    /* ajax delete. */
    $('a.delete').click(function()
    {
        if(confirm(v.lang.confirmDelete))
        {
            delUrl = $(this).attr('href');
            $(this).text(v.lang.deleteing);
            $.getJSON(delUrl,function(data) 
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

    if($('a[data-toggle=modal]').size())
    {
        var div = $('<div id="ajaxWin" name="ajaxWin" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >kjgbkjjkg</div>');
        div.appendTo('body');
        $('a[data-toggle=modal]').attr('data-target', '#ajaxWin').click(function()
        {
            winWidth      = 580;
            winMarginLeft = 280;

            if($(this).attr('w'))
            {
                winWidth  = $(this).attr('w'); 
                winMarginLeft = parseInt($(this).attr('w')-580)/2 + 280;
            }
            $('#ajaxWin').css('width',winWidth).css('margin-left', '-' + winMarginLeft + 'px').load($(this).attr('href'));
        });
    }
})
