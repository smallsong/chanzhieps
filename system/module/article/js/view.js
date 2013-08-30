$(document).ready(function()
{
    $('#commentBox').load( createLink('comment', 'show', 'objectType=article&objectID=' + v.articleID) );  
});
