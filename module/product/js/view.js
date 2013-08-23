$(document).ready(function()
{
   	$('a.little-picture').click(function()
    {
        $('a.main-picture').html($(this).html());
        $('a.main-picture img').resizeImage(280, 280);
        return false;
   	});
    $('a.main-picture img').resizeImage(280, 280);
    $('a.little-picture img').resizeImage(66, 66);
})
