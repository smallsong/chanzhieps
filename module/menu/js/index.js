$(document).ready(function()
{
    $('ul.menuList a.remove').first().remove(); 
    $(document).on('click', '.shut',
        function()
        {
            $(this).parent().find("ul").toggle();
            if($(this).parent().find('ul li').size() != 0)
            $(this).toggleClass('icon-folder-close').toggleClass('icon-folder-open'); 
        }
    );

    $(document).on('click', '.icon-arrow-up', 
        function()
        {
            $(this).parent().prev().before($(this).parent()); 
        }
    );

    $(document).on('click', '.icon-arrow-down',
        function()
        { 
          if($(this).parent().next().find('input').size()>0)
          $(this).parent().next().after($(this).parent()); 
        }
    );

    $(document).on('click', '.remove', function(){$(this).parent().remove();});

    /* toggle article common selector.*/


    $(document).on('change', '.menuType',
        function() 
        {
            type    = $(this).val();
            grade   = $(this).attr('grade');
            $(this).parent().children(':input[type=text]').val('');
            if(type != 'input')
            {
                $(this).parent().children('.urlInput').hide();
                $(this).parent().children('.menuSelector').hide();
                $(this).parent().children('.menuSelector[name*='+type+']').show();
            }
            else
            {
                $(this).parent().children('.menuSelector').hide();
                $(this).parent().children('.urlInput').show(); 
            }
        }
    );

    $(document).on('change', '.menuSelector',
        function()
        {
            categories = $(this).find(':selected').text().split('/');
            $(this).parent().children('.titleInput').val( categories[categories.length-1] );
        }
    );
  
    /* add memu options */
    $(document).on('click', '.plus1', function() { $(this).parent().after($('#grade1MenuSource').html()); });
    $(document).on('click', '.plus2', 
        function() 
        {
            var container = $(this).parents('.liGrade2');
            if(0 == container.size())
            { 
                if($(this).parents('.liGrade1').find('.liGrade2').size()==0)
                {
                    $(this).parents('.liGrade1').append($('#grade2MenuSource').html());
                }
                else
                {
                    $(this).parents('.liGrade1').find('.ulGrade2').prepend($('#grade2MenuSource ul').html());
                }
            }
            else
            {
                $(this).parent().after($('#grade2MenuSource ul').html()); 
            }
        }
    );

    $(document).on('click', '.plus3', 
        function() 
        {
            var container = $(this).parents('.liGrade3');
            if(0 == container.size())
            { 
                if($(this).parents('.liGrade2').find('.ulGrade3').size() == 0)
                {
                    $(this).parents('.liGrade2').append($('#grade3MenuSource').html());
                }
                else
                {
                    $(this).parents('.liGrade2').find('.ulGrade3').prepend($('#grade3MenuSource ul').html());
                }
            }
            else
            {
                $(this).parent().after($('#grade3MenuSource ul').html()); 
            }
        }
    );
    
    $.ajaxForm('#menuForm',function(data){ bootbox.alert(data.message); });
});
 
function menuSelector(grade, type)
{
  return $('#' + type + 'Selector').html().replace('grade', grade);   
}

function submitForm()
{
    $('.menuList .grade1key').each(function(index,obj) { $(this).val(index); });
    $('.menuList .grade2key').each(function(index){ $(this).val(1000+(parseInt(index))); })
    $('.menuList .grade2parent').each(function(index){ $(this).val( $(this).parents('.liGrade1').children('.grade1key').val()); });
    $('.menuList .grade3parent').each(function(i){ p = $(this).parents('.liGrade2').children('.grade2key').val(); $(this).val(p); });
    $('#menuForm').submit();
}
