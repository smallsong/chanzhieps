<?php
class tree extends control
{
    public function updateOrder($tree)
    {
        if(!empty($_POST))
        {
            if($tree == 'video')
            {
                $this->tree->updateVideoOrder($_POST['orders']); 
                die(js::reload('parent'));
            }
            else
            {
                $this->tree->updateOrder($_POST['orders']);
                die(js::reload('parent'));
            }
        }
    }
}
