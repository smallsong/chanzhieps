<?php include '../../common/view/header.html.php'; ?>
<div class='row'>
  <div class='u-1'>
    <div id="cse-search-results">
      <ol>
      <?php 
      foreach($results as $result)
      {
          echo '<li>';
          echo '<h3 class=f-14px>' . html::a($result->Url, $result->Title, '_blank') . '</h3>';
          echo "<p>$result->Description<br />";
          echo html::a($result->Url, $result->Url, '_blank');
          echo '</p></li>';
      }
      ?>
      </ol>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>
