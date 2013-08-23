$(document).ready(function() 
{
    setRequiredFields();
    setAdminLeftMenu();

    $('img.adaptive').resizeImage();
    $.setAjaxModal();
    $.setAjaxForm('#ajaxForm');
    $.setAjaxDeleter('.deleter');
});
