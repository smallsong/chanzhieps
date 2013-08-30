<?php include '../../../../common/view/header.html.php';?>
<iframe id='zentaopmhelp' name='zentaopmhelp' src='http://www.zentao.com/help-book-zentaopmshelp.html?extra=zentaopm' frameborder='0' width='100%'></iframe>
<script type='text/javascript'>
$(function(){
    var winHeight = $(window).height();
    var headerH   = $('#header').height();
    var footerH   = $('#footer').height();

    var outerH = winHeight - headerH - footerH - 105;
    $('#zentaopmhelp').height(outerH);
})
</script>
<?php include '../../../../common/view/footer.html.php';?>
