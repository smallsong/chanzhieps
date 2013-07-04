$(document).ready(function()
{
    $.ajaxForm('#editForm',
      function(data)
      {
          bootbox.alert(data.message);
          $('.span9').load(createLink('tree', 'managechild', 'tree=article&category='+v.categoryID));
      }
      );
});
