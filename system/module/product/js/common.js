$(document).ready(function()
{
    /* Set current active topNav. */
    if(v.path && v.path.length)
    {
        $.each(eval(v.path), function(index, category)
        {
            $('.nav-product-' + category).addClass('active');
        })
    }
})
