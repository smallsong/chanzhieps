$(document).ready(function() 
{
    setRequiredFields();
    setAdminLeftMenu();

    $.setAjaxModal();
    $.setAjaxForm('#ajaxForm');
    $.setAjaxDeleter('.deleter');
});
