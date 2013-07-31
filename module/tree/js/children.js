$(document).ready(function()
{
    $.ajaxForm('#childForm', function()
    {
        $('#treeMenuBox').parent().load(createLink('tree', 'browse', 'tree=' + v.treeType) + ' #treeMenuBox', function()
        {
            $(".tree").treeview({collapsed: false, unique: false});    
        });
    });
});
