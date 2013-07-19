$(document).ready(function()
{
function uuid(){
    if(!v.counter) v.counter = 0;
    return v.counter++;
}

    $(document).on('click', '.shut', function(){$(this).parent().find("ul").hide();});
    $(document).on('click', '.open', function(){$(this).parent().find("ul").show();});

    $(document).on('click', '.up', function() { $(this).parent().prev().before($(this).parent()); });
    $(document).on('click', '.down', function() { if($(this).parent().next().find('input').size()>0) $(this).parent().next().after($(this).parent()); });

    $(document).on('click', '.remove', function(){$(this).parent().remove();});
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
});
 
  function submitForm()
  {
    $('.menuList .grade1key').each(function(index,obj){
      $(this).val(index);
    });
    $('.menuList .grade2key').each(function(index){
      $(this).val(1000+(parseInt(index)));
    })
    $('.menuList .grade2parent').each(function(index){
      p = $(this).parent().parent().parent().find('.grade1key').val();
      $(this).val(p);
    });
    $('.menuList .grade3parent').each(function(i){
      p = $(this).parent().parent().parent().find('.grade2key').val();
      $(this).val(p);
    });
    $('#menuForm').submit();
  }

