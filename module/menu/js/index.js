$(document).ready(function()
{
    $('.menuType').change();
    
    function uuid()
    {
        if(!v.counter) v.counter = 0;
        return v.counter++;
    }

    $(document).on('click', '.shut', function() { $(this).parent().find("ul").toggle(); if($(this).parent().find('ul li').size() != 0) $(this).toggleClass('icon-folder-close').toggleClass('icon-folder-open'); });

    $(document).on('click', '.icon-arrow-up', function() { $(this).parent().prev().before($(this).parent()); });
    $(document).on('click', '.icon-arrow-down', function() { if($(this).parent().next().find('input').size()>0) $(this).parent().next().after($(this).parent()); });
    $(document).on('click', '.remove', function(){$(this).parent().remove();});
    $(document).on('change', '.menuType',
      function() 
      {
          type    = $(this).val();
          grade   = $(this).attr('grade');
          $(this).next('.menuSelector').remove(); 
          $(this).parent().find(':input[type=text]').val('');
          if(type != 'input')
          {
              $(this).parent().find('.urlInput:first').hide().attr('disabled', true); 
          }
          else
          {
              $(this).parent().find('.urlInput:first').attr('disabled', false).show(); 
          }
          menuObj = menuSelector(grade, type);
          $(this).after(menuObj); 
          $(this).next().change();
      });
    $(document).on('change', '.menuSelector',
        function()
        {
            categories = $(this).find(':selected').text().split('/');
            $(this).parent().find('.titleInput:first').val( categories[categories.length-1] );
        }
    );
  
    /* add memu options */
    $(document).on('click', '.plus1', function() { $(this).parent().after($('#menuGrade1').html()); });
    $(document).on('click', '.plus2', 
        function() 
        {
            var container = $(this).parents('.grade2');
            if(0 == container.size())
            { 
                if($(this).parents('.grade1').find('.grade2').size()==0)
                {
                    $(this).parents('.grade1 li').append($('#menuGrade2').html());
                }
                else
                {
                    $(this).parents('.grade1').find('.grade2').append($('#menuGrade2 ul').html());
                }
            }
            else
            {
                $(this).parent().after($('#menuGrade2 ul').html()); 
            }
    });

    $(document).on('click', '.plus3', 
        function() 
        {
            var container = $(this).parents('.grade3');
            if(0 == container.size())
            { 
                if($(this).nextAll('.grade3').size()==0)
                {
                    $(this).parents('.grade2 li').append($('#menuGrade3').html());
                }
                else
                {
                    $(this).nextAll('.grade3').append($('#menuGrade3 ul').html());
                }
            }
            else
            {
                $(this).parent().after($('#menuGrade3 ul').html()); 
            }
    });
    
  $.ajaxForm('#menuForm',function(data){
      bootbox.alert(data.message);
  });
});
 
function menuSelector(grade, type)
{
  return $('#' + type + 'Selector').html().replace('grade',grade);   
}

function submitForm()
{
    $('.menuList .grade1key').each(function(index,obj) { $(this).val(index); });
    $('.menuList .grade2key').each(function(index){ $(this).val(1000+(parseInt(index))); })
    $('.menuList .grade2parent').each(function(index){ $(this).val( $(this).parent().parent().parent().find('.grade1key').val()); });
    $('.menuList .grade3parent').each(function(i){ p = $(this).parent().parent().parent().find('.grade2key').val(); $(this).val(p); });
    $('#menuForm').submit();
}

