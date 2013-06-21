KE.util.pluginLang('code', document);
KE.plugin['code'] = {
  click : function(id) {
    KE.util.selection(id);
    this.dialog = new KE.dialog({
      id : id,
      cmd : 'code',
      file : 'code.html',
      width : 500,
      height : 350,
      loadingMode : true,
      title : KE.lang['code'],
      yesButton : KE.lang['yes'],
      noButton : KE.lang['no']
    });
    this.dialog.show();
  },
  escape : function( value ) {
    return value.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\"/g, '&quot;').replace(/\'/g, '&#39;');
  },
  check : function(id) {
    var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
    var lang = KE.$('lang', dialogDoc).value;
    if (!lang) {
      alert(KE.lang['invalidLang']);
      return false;
    }
    return true;
  },
  exec : function(id) {
    var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
    var lang = KE.$('lang', dialogDoc).value;
    var code = KE.$('code', dialogDoc).value;
    if (!this.check(id)) return false;
    KE.util.insertHtml(id, "<pre class=\"brush:" + lang + ";\">" + this.escape(code) + "</pre><p></p>");
    this.dialog.hide();
    KE.util.focus(id);
  }
};
