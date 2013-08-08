(function($) 
{
    jQuery.fn.fixImage = function(maxWidth = 0,  maxHeight = 0)
    { 
        container = $(this).parent();

        parentWidth  = parseInt(container.width());
        parentHeight = parseInt(container.height());

        if(maxWidth <= 0) maxWidth = parentWidth;
        if(maxHeight <= 0) maxHeight = parentHeight;
        
        $(this).css('max-width',  maxWidth);
        $(this).css('max-height', maxHeight);
        
        width  = $(this).width();
        height = $(this).height();
        
        marginY = (maxHeight - height) / 2;
        marginX = (maxWidth  - width) / 2;
        
        $(this).css('margin', marginY + 'px ' + marginX + 'px');

        container.css('padding', 0) ;
    };
})(jQuery);
