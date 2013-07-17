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
        if(!isset($this->config->site))                 $this->config->site                 = new stdclass();
        if(!isset($this->config->site->name))           $this->config->site->name           = $this->lang->xirangEPS;
        if(!isset($this->config->site->keywords))       $this->config->site->keywords       = '';
        if(!isset($this->config->site->slogan))         $this->config->site->slogan         = '';
        if(!isset($this->config->site->copyrightStart)) $this->config->site->copyrightStart = date('Y')-1;
        if(!isset($this->config->site->icp))            $this->config->site->icp            = '';
        if(!isset($this->config->site->desc))           $this->config->site->desc           = '';
        if(!isset($this->config->site->menu))           $this->config->site->menu           = json_encode(array());

        if(!isset($this->config->company))        $this->config->company              = new stdclass();
        if(!isset($this->config->company->name))  $this->config->company->name        = '';
        if(!isset($this->config->company->desc))  $this->config->company->desc        = '';
        if(!isset($this->config->company->content))  $this->config->company->content  = '';
        if(!isset($this->config->company->contact))  $this->config->company->contact  = json_encode(array());
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
