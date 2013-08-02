<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php
/* Get current module and method. */
$module = $this->moduleName;
$method = $this->methodName;
if(!isset($config->$module->editor->$method)) return;

/* Export $jsRoot var. */
js::set('jsRoot', $jsRoot);

/* Get editor settings for current page. */
$editors = $config->$module->editor->$method;
$editors['id'] = explode(',', $editors['id']);
js::set('editors', $editors);

/* Get current lang. */
$editorLangs = array('en' => 'en', 'zh-cn' => 'zh_CN', 'zh-tw' => 'zh_TW');
$editorLang  = isset($editorLangs[$app->getClientLang()]) ? $editorLangs[$app->getClientLang()] : 'en';
js::set('editorLang', $editorLang);

/* Import css and js for kindeditor. */
css::import($jsRoot . 'kindeditor/themes/default/default.css');
js::import($jsRoot  . 'kindeditor/kindeditor-min.js');
js::import($jsRoot  . 'kindeditor/lang/' . $editorLang . '.js');
?>

<script language='javascript'>
var simpleTools = 
[ 'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic','underline', '|', 
'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', '|',
'emoticons', 'image', 'code', 'link', '|', 'removeformat','undo', 'redo', 'fullscreen', 'source', 'about'];

var fullTools = 
[ 'formatblock', 'fontname', 'fontsize', 'lineheight', '|', 'forecolor', 'hilitecolor', '|', 'bold', 'italic','underline', 'strikethrough', '|',
'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', '|',
'insertorderedlist', 'insertunorderedlist', '|',
'emoticons', 'image', 'insertfile', 'hr', '|', 'link', 'unlink', '/',
'undo', 'redo', '|', 'selectall', 'cut', 'copy', 'paste', '|', 'plainpaste', 'wordpaste', '|', 'removeformat', 'clearhtml','quickformat', '|',
'indent', 'outdent', 'subscript', 'superscript', '|',
'table', 'code', '|', 'pagebreak', 'anchor', '|', 
'fullscreen', 'source', 'preview', 'about'];

$(document).ready(function() 
{
    $.each(v.editors.id, function(key, editorID)
    {
        editorTool = eval(v.editors.tools);

        KindEditor.ready(function(K)
        {
            keEditor = K.create('#' + editorID,
            {
                items:editorTool,
                filterMode:true, 
                cssPath:[v.jsRoot + 'kindeditor/plugins/code/prettify.css'],
                urlType:'relative', 
                uploadJson: createLink('file', 'ajaxUpload'),
                allowFileManager:true,
                langType:v.editorLang,
                afterBlur: function(){this.sync(); },
                afterChange: function(){$('#' + editorID ).change().hide();},
            });
        });
    });
})
</script>
