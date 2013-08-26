$(document).ready(function()
{
   	$('a.little-image').click(function()
    {
        $('a.big-image').html($(this).html());
        $('a.big-image img').resizeImage(280, 280);
        return false;
   	});

    $('a.big-image img').resizeImage(280, 280);
    $('a.little-image img').resizeImage(66, 66);

    $('#commentBox').load( createLink('comment', 'show', 'objectType=product&objectID=' + v.productID) );  
})
