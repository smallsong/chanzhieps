<form method='post' id="childForm" action='<?php echo $this->inlink('children', "tree=$tree");?>'>
  <table class='table table-bordered table-form'>
    <caption><?php echo $parent ? $lang->$tree->children : $lang->$tree->common;?></caption>
    <tr>
      <td class="w-p10">
        <nobr>
        <?php
        $chevron = ' <i class="icon-chevron-right"></i> ';
        foreach($origins as $origin)
        {
            echo html::a($this->inlink('browse', "tree=$tree&category=$origin->id"), $origin->name . $chevron);
        }
        ?>
        </nobr>
      </td>
      <td> 
        <?php
        $maxOrder = 0;
        foreach($children as $child)
        {
            if($child->order > $maxOrder) $maxOrder = $child->order;
            echo '<p>' . html::input("children[$child->id]", $child->name) . '</p>';
            echo html::hidden("mode[$child->id]", 'update');
        }

        for($i = 0; $i < TREE::NEW_CHILD_COUNT ; $i ++)
        {
            echo '<p>' . html::input("children[]") . '</p>';
            echo html::hidden('mode[]', 'new');
        }

        echo html::submitButton();
        echo html::hidden('parent',   $parent);
        echo html::hidden('maxOrder', $maxOrder);
        ?>      
      </td>
    </tr>
  </table>
</form>
<?php if(isset($pageJS)) js::execute($pageJS);?>
