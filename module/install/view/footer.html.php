<footer>
  <div class="container">
    <p class="muted credit a-right"><?php printf($lang->poweredBy, $config->version);?></p>
  </div>
</footer>
<?php if(isset($pageJS)) js::execute($pageJS);?>
</body>
</html>
