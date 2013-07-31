$(document).ready(function()
{
    $.ajaxLoad('#treeMenuBox a[class!=delete]', '#categoryBox');

    if(v.action == 'children') var link = createLink('tree', 'children', 'treeType=' + v.treeType + '&root=' + v.root);
    if(v.action == 'edit')     var link = createLink('tree', 'edit',     'category=' + v.root);
    $('#categoryBox').load(link);
})

