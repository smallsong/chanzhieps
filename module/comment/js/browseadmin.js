$(document).ready(function()
{
    $('.deletepre').click(function(){
      var that = $(this);
      bootbox.confirm(v.lang.comment.confirmDeletePre,function(result)
      {
          if(result)
          {
              delUrl = that.attr('href');
              that.text(v.lang.deleteing);
              $.getJSON(delUrl,function(data) 
              {
                  if(data.result=='success')
                  {
                      location.reload();
                  }
                  else
                  {
                      alert(data.message);
                  }
              });
          }
      });
      return false;
    });
    
    $('.pass').click(function(){
      var that = $(this);
      bootbox.confirm(that.attr('confirminfo'),function(result)
      {
          if(result)
          {
              passurl = that.attr('href');
              that.text(v.lang.doing);
              $.getJSON(passurl,function(data) 
              {
                  if(data.result=='success')
                  {
                      location.reload();
                  }
                  else
                  {
                      alert(data.message);
                  }
              });
          }
      });
      return false;
    });


});
