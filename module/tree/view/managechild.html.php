    <form method='post' id="childForm" action='<?php echo $this->createLink('tree', 'manageChild', "tree=$tree");?>'>
      <table class='table table-bordered table-form'>
        <caption><?php echo $lang->tree->manageChild;?></caption>
        <tr>
          <td class="w-p10">
            <nobr>
            <?php
            $sp = '<i class="icon-chevron-right"></i>';
            echo html::a($this->createLink('tree', 'browse'), $lang->tree->category);
            foreach($parentCategories as $category)
            {
                echo html::a($this->createLink('tree', 'browse', "tree=$tree&categoryID=$category->id"), $sp . $category->name);
            }
            ?>
            </nobr>
          </td>
          <td> 
            <?php
            $maxOrder = 0;
            foreach($sons as $sonCategory)
            {
                if($sonCategory->order > $maxOrder) $maxOrder = $sonCategory->order;
                echo html::input("categories[id$sonCategory->id]", $sonCategory->name, 'style="margin-bottom:5px"') . '<br />';
            }
            for($i = 0; $i < TREE::NEW_CHILD_COUNT ; $i ++) echo html::input("categories[]", '', 'style="margin-bottom:5px"') . '<br />';
           ?>
          </td>
        </tr>
        <tr>
          <td class='a-center' colspan='2'>
            <?php 
            echo html::submitButton() . html::resetButton();
            echo html::hidden('parentCategoryID', $currentCategoryID);
            echo html::hidden('maxOrder', $maxOrder);
            ?>      
            <input type='hidden' value='<?php echo $currentCategoryID;?>' name='parentCategoryID' />
          </td>
        </tr>
      </table>
    </form>
  <?php if(isset($pageJS)) js::execute($pageJS);?>
