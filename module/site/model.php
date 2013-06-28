<?php
/**
 * The model file of site module of XiRangEPS.
 *
 * @copyright   Copyright 2013-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
?>
<?php
class siteModel extends model
{
    /**
     * Set the site user visiting.
     * 
     * 1. search by domin.
     * 2.if not, then search default domein
     * 3.if not, then search first domain.
     *
     * after get the site, register it to session.
     */
    public function setSite()
    {
        $this->app->site = new stdclass();
        $this->app->site->name     = '';
        $this->app->site->keywords = '';
        $this->app->site->mission  = '';
    }

   /**
     * Save the settings of the site.
     * 
     * @access public
     * @return void
     */
    public function saveSetting()
    {
        $indexModules = join(',', $this->post->indexModules);
        foreach($this->post->menuModules as $key => $moduleID)
        {
            if(empty($moduleID) and empty($this->post->menuLinks[$key])) continue;
            $menus[] = !empty($this->post->menuLinks[$key]) ? $this->post->menuLinks[$key] : $moduleID;
        }
        $site->indexModules = $indexModules;
        $site->menus        = join(',', $menus);
        $this->dao->update(TABLE_SITE)->data($site)->where('id')->eq($this->session->site->id)->exec();
    }

    }
