(function($) 
{
    jQuery.fn.fixImage = function(maxWidth, maxHeight)
    { 
        container = $(this).parent();
        parentWidth  = parseInt(container.width());
        parentHeight = parseInt(container.height());

        if(isNaN(maxWidth)) maxWidth   = parentWidth;
        if(isNaN(maxHeight)) maxHeight = parentHeight;
        
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
