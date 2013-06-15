$(function(){
    $('#type').change(function(){location.href='/admin.php?m=block&f=create&type=' + $(this).val()})
})
