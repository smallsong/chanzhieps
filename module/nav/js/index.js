$(document).ready(function()
{
    /* add grade1 memu options */
    $(document).on('click', '.plus1', function() { $(this).parent().after($('#grade1NavSource').html());});

    /* add grade2 memu options */
    $(document).on('click', '.plus2', 
        function() 
        {
            var container = $(this).parents('.liGrade2');
            if(0 == container.size())
            { 
                if($(this).parents('.liGrade1').find('.liGrade2').size()==0)
                {
                    $(this).parents('.liGrade1').append($('#grade2NavSource').html());
                }
                else
                {
                    $(this).parents('.liGrade1').find('.ulGrade2').prepend($('#grade2NavSource ul').html());
                }
            }
            else
            {
                $(this).parent().after($('#grade2NavSource ul').html()); 
            }
        }
    );

    /* add grade3 memu options */
    $(document).on('click', '.plus3', 
        function() 
        {
            var container = $(this).parents('.liGrade3');
            if(0 == container.size())
            { 
                if($(this).parents('.liGrade2').find('.ulGrade3').size() == 0)
                {
                    $(this).parents('.liGrade2').append($('#grade3NavSource').html());
                }
                else
                {
                    $(this).parents('.liGrade2').find('.ulGrade3').prepend($('#grade3NavSource ul').html());
                }
            }
            else
            {
                $(this).parent().after($('#grade3NavSource ul').html()); 
            }
        }
    );

    /* toggle children nav. */
    $(document).on('click', '.shut',
        function()
        {
            $(this).parent().find("ul").toggle();
            if($(this).parent().find('ul li').size() != 0)
            $(this).toggleClass('icon-folder-close').toggleClass('icon-folder-open'); 
        }
    );

    /* sort up. */
    $(document).on('click', '.icon-arrow-up', 
        function()
        {
            $(this).parent().prev().before($(this).parent()); 
        }
    );

    /* sort down. */
    $(document).on('click', '.icon-arrow-down',
        function()
        { 
          if($(this).parent().next().find('input').size()>0)
          $(this).parent().next().after($(this).parent()); 
        }
    );

    /* delete nav. */
    $(document).on('click', '.remove', function(){
        
        if($(this).parent().is('.liGrade1') && $('.navList .liGrade1').size() ==1)
        {
            bootbox.alert(v.lang.canNotRemoveAllNav);
        }
        else 
        {
            $(this).parent().remove();
        }
    });

    /* toggle article common selector.*/
    $(document).on('change', '.navType',
        function() 
        {
            type    = $(this).val();
            grade   = $(this).attr('grade');
            $(this).parent().children(':input[type=text]').val('');
            if(type != 'input')
            {
                $(this).parent().children('.urlInput').hide();
                $(this).parent().children('.navSelector').hide();
                $(this).parent().children('.navSelector[name*='+type+']').show();
            }
            else
            {
                $(this).parent().children('.navSelector').hide();
                $(this).parent().children('.urlInput').show(); 
            }
        }
    );

    $('a[class*=plus]').click(function(){ $('.navType').change();});  

    /* set default nav title when selector changed. */
    $(document).on('change', '.navSelector',
        function()
        {
            categories = $(this).find(':selected').text().split('/');
            $(this).parent().children('.titleInput').val( categories[categories.length-1] );
        }
    );
    
    $.setAjaxForm('#navForm',function(data){ bootbox.alert(data.message); });

});

/**
 * group navs and submit form
 *
 * @return void 
 */
function submitForm()
{
    $('.navList .grade1key').each(function(index,obj) { $(this).val(index); });
    $('.navList .grade2key').each(function(index){ $(this).val(1000+(parseInt(index))); })
    $('.navList .grade2parent').each(function(index){ $(this).val( $(this).parents('.liGrade1').children('.grade1key').val()); });
    $('.navList .grade3parent').each(function(i){ p = $(this).parents('.liGrade2').children('.grade2key').val(); $(this).val(p); });
    $('#navForm').submit();
}
