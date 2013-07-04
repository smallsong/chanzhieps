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
     * @access public
     * @return void
     */
    public function setSite()
    {
        if(!isset($this->config->site))           $this->config->site           = new stdclass();
        if(!isset($this->config->site->name))     $this->config->site->name     = $this->lang->xirangEPS;
        if(!isset($this->config->site->keywords)) $this->config->site->keywords = '';
        if(!isset($this->config->site->slogan))   $this->config->site->slogan   = '';
        if(!isset($this->config->site->desc))     $this->config->site->desc     = '';
    }

    /**
     * Save the settings of the site.
     * 
     * @param object $settings
     * @access public
     * @return void
     */
    public function saveSetting($settings)
    {
        $path  = "common.site"; 
        return $this->loadModel('setting')->setItems($path, $settings);
    }

}
