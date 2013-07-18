<?php
/**
 * The common simplified chinese file of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     xirangEPS
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->xirangEPS      = 'xirangEPS';
$lang->poweredBy      = "由 <a href='http://www.xirang.biz' target='_blank'>{$lang->xirangEPS} %s</a> 强力驱动！";

$lang->colon        = '::';
$lang->arrow        = '>'; 

$lang->welcome        = "欢迎您, <strong>%s</strong> ";
$lang->todayIs        = '今天是%s，';
$lang->aboutUs        = '关于我们';
$lang->frontHome      = '前台首页';
$lang->dashboard      = '用户中心';
$lang->register       = '免费注册';
$lang->logout         = '退出';
$lang->login          = '登录';
$lang->account        = '帐号';
$lang->password       = '密码';
$lang->forgotPassword = '忘记密码?';

$lang->currentPos   = '当前位置';
$lang->categoryMenu = '分类导航';
$lang->reset        = '重填';
$lang->edit         = '编辑';
$lang->copy         = '复制';
$lang->hide         = '隐藏';
$lang->delete       = '删除';
$lang->close        = '关闭';
$lang->save         = '保存';
$lang->confirm      = '确认';
$lang->preview      = '预览';
$lang->goback       = '返回';
$lang->search       = '搜索';
$lang->more         = '更多';
$lang->actions      = '操作';
$lang->feature      = '未来';
$lang->year         = '年';
$lang->submitting   = '稍候...';
$lang->saveSuccess  = '保存成功';
$lang->setSuccess   = '设置成功';
$lang->fail         = '失败';


/* for javascript */
$lang->js->confirmDelete = '确认删除?';
$lang->js->deleteing     = '正在删除...';
$lang->js->doing         = '正在处理...';

/* contact fields*/
$lang->company = new stdClass();
$lang->company->contactUs   = "联系我们";
$lang->company->address = "地址";
$lang->company->phone   = "电话";
$lang->company->email   = "Email";
$lang->company->fax     = "传真";
$lang->company->qq       = "QQ";
$lang->company->weibo    = "微博";
$lang->company->weixin   = "微信";
$lang->company->wangwang = "阿里旺旺";



/* Front menus.*/
$lang->frontMenu = new stdClass();
$lang->frontMenu->home     = '首页|index|index';
$lang->frontMenu->about    = '关于我们|company|index';
$lang->frontMenu->forum    = '论坛|forum|index';

/* The main menus. */
$lang->menu = new stdclass();
$lang->menu->admin    = '首页|admin|index|';
$lang->menu->article  = '文章|article|browseadmin|';
$lang->menu->comment  = '评论|comment|browseadmin|';
$lang->menu->forum    = '论坛|thread|browseadmin|';
$lang->menu->site     = '站点|site|setbasic|';
$lang->menu->company  = '公司|company|setbasic|';
$lang->menu->user     = '会员|user|forbid|';

/* The menus of article module. */
$lang->article = new stdclass();
$lang->article->menu = new stdclass();

$lang->article->menu->browse   = '文章列表|article|browseadmin|';
$lang->article->menu->create   = '发布文章|article|create|';
$lang->article->menu->tree     = '类目管理|tree|browse|tree=article';

/* The menus of forum module. */
$lang->forum       = new stdclass();
$lang->forum->menu = new stdclass();

$lang->forum->menu->browse   = '主题列表|thread|browseadmin|';
$lang->forum->menu->tree     = '版块管理|tree|browse|tree=forum';

$lang->thread = $lang->forum;

/* The menus of site module. */
$lang->site = new stdclass();
$lang->site->menu = new stdclass();

$lang->site->menu->basic   = '站点设置|site|setbasic|';
$lang->site->menu->logo    = 'LOGO设置|site|setlogo|';
$lang->site->menu->menu    = '导航设置|menu|index|';

/* The menus of company module. */
if(!isset($lang->company)) $lang->company = new stdclass();
$lang->company->menu = new stdclass();

$lang->company->menu->basic = '公司信息|company|setbasic|';
$lang->company->menu->contact  = '联系方式|company|setcontact|';


/* The error messages. */
$lang->error = new stdclass();
$lang->error->length       = array("『%s』长度错误，应当为『%s』", "『%s』长度应当不超过『%s』，且不小于『%s』。");
$lang->error->reg          = "『%s』不符合格式，应当为:『%s』。";
$lang->error->unique       = "『%s』已经有『%s』这条记录了。";
$lang->error->notempty     = "『%s』不能为空。";
$lang->error->equal        = "『%s』必须为『%s』。";
$lang->error->int          = array("『%s』应当是数字。", "『%s』最小值为%s",  "『%s』应当介于『%s-%s』之间。");
$lang->error->float        = "『%s』应当是数字，可以是小数。";
$lang->error->email        = "『%s』应当为合法的EMAIL。";
$lang->error->date         = "『%s』应当为合法的日期。";
$lang->error->account      = "『%s』应当为字母和数字的组合，至少三位";
$lang->error->passwordsame = "两次密码应当相等。";
$lang->error->passwordrule = "密码应该符合规则，长度至少为六位。";
$lang->error->captcha      = "请输入正确的验证码";

/* The pager items. */
$lang->pager = new stdclass();
$lang->pager->noRecord  = "暂时没有记录";
$lang->pager->digest    = "共<strong>%s</strong>条记录,每页 <strong>%s</strong>条，页面：<strong>%s/%s</strong> ";
$lang->pager->first     = "首页";
$lang->pager->pre       = "上页";
$lang->pager->next      = "下页";
$lang->pager->last      = "末页";
$lang->pager->locate    = "GO!";

/* The datetime settings. */
define('DT_DATETIME1',  'Y-m-d H:i:s');
define('DT_DATETIME2',  'y-m-d H:i');
define('DT_MONTHTIME1', 'n/d H:i');
define('DT_MONTHTIME2', 'n月d日 H:i');
define('DT_DATE1',     'Y年m月d日');
define('DT_DATE2',     'Ymd');
define('DT_DATE3',     'Y年m月d日');
define('DT_DATE4',     'Y-m-d');
define('DT_TIME1',     'H:i:s');
define('DT_TIME2',     'H:i');
