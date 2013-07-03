$(document).ready(function()
{
    $.ajaxForm('#treeForm');
    $.ajaxLink('#treeForm a[class!=delete]', '.span9');
    $('.span9').load(createLink('tree', 'managechild', 'tree=article&category='+v.categoryID));
})

