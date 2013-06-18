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
     * Get the site list.
     * 
     * @access public
     * @return array    the sites.
     */
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_SITE)->orderBy('id')->fetchAll();
    }

    /**
     * Get the key => value site pairs.
     * 
     * @access public
     * @return array 
     */
    public function getPairs()
    {
        $account = ',' . $this->app->user->account . ',';
        return $this->dao->select('id, name')
            ->from(TABLE_SITE)
            ->beginIF(!$this->app->user->isSuper)->where('admins')->like("%$account%")->fi()
            ->orderBy('id')
            ->fetchPairs();
    }

    /**
     * Get the first site.
     * 
     * @access public
     * @return object   site.
     */
    public function getFirst()
    {
        $site = $this->dao->select('*')->from(TABLE_SITE)->orderBy('id')->limit(1)->fetch();
        if(!$site) return false;
        $this->processSite($site);
        return $site;
    }
    
    /**
     * Get site by the domain.
     * 
     * @param string $domain    the domain
     * @access public
     * @return object   the site.
     */
    public function getByDomain($domain = '')
    {
        if(empty($domain)) $domain = $this->getDomainWithLang();   // Get the domain with lang path like www.xirang.biz/en/
        $site = $this->dao->findByDomain($domain)->from(TABLE_SITE)->fetch();
        if(!$site) return false;
        $this->processSite($site);
        return $site;
    }

     /**
     * Get site by the id.
     * 
     * @param int $id    the site id
     * @access public
     * @return object   the site.
     */
    public function getByID($siteID = '')
    {
        $site = $this->dao->findById((int)$siteID)->from(TABLE_SITE)->fetch();
        $this->processSite($site);
        return $site;
    }

    /**
     * Get the option menu of modules of the link sites.
     * 
     * @param  string $linkSites 
     * @param  string $tree 
     * @access public
     * @return array
     */
    public function getLinkSitesOptionMenu($linkSites, $tree)
    {
        $this->loadModel('tree');
        $sites     = $this->getPairs();
        $siteTrees = array();
        if(!empty($linkSites))
        {
            $linkSites = explode(',', trim($linkSites, ','));
            foreach($linkSites as $siteID)
            {
                $siteTree           = $this->tree->getOptionMenu($tree, 0, $siteID);
                if($siteID) $siteTree[0] = $sites[$siteID];
                $siteTrees[$siteID] = $siteTree;
            }
        }
        return $siteTrees;
    }

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
        /* Already in session, check it and load site config. */
        if($this->session->site !== false)
        {
            if(RUN_MODE == 'admin' or $this->session->site->domain == $this->getDomainWithLang())
            {
                $this->app->site = $this->session->site;
                return;
            }
        }

        /* Search from database again. */
        $site = $this->getByDomain();
        if(!$site and isset($this->config->default->domain)) $site = $this->getByDomain($this->config->default->domain);
        if(!$site) $site = $this->getFirst();
        if(!$site) $this->app->error(sprintf($this->lang->error->siteNotFound, $_SERVER['HTTP_HOST']), __FILE__, __LINE__, $exit = true);
        $this->session->set('site', $site);
        $this->app->site  = $site;
    }

    /**
     * Load the config file of site.
     * 
     * @param mixed $site 
     * @access public
     * @return void
     */
    public function loadSiteConfig($siteCode)
    {
        $siteConfigFile = $this->app->getConfigRoot() . 'sites/' . $siteCode . '.php';
        if(file_exists($siteConfigFile)) 
        {
            global $config;
            include $siteConfigFile;
        }
    }

    /**
     * Create a site.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $site = fixer::input('post')->join('linkSites', ',')->get();
        $this->dao->insert(TABLE_SITE)
            ->data($site)
            ->autoCheck()
            ->batchCheck($this->config->site->create->requiredFields, 'notempty')
            ->batchCheck('name,pms', 'unique')
            ->exec();
        $this->saveCodes();
    }

    /**
     * Update s site.
     * 
     * @access public
     * @return void
     */
    public function update($siteID)
    {
        $site = fixer::input('post')->setDefault('linkSites', '')->join('linkSites', ',')->get();
        $this->dao->update(TABLE_SITE)
            ->data($site)
            ->autoCheck()
            ->batchCheck($this->config->site->edit->requiredFields, 'notempty')
            ->batchCheck('name, domain', 'unique', "id != '$siteID'")
            ->where('id')->eq($siteID)
            ->exec();
        $this->saveCodes();
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

    /**
     * Save the codes of all sites in to a cache file.
     * 
     * @access public
     * @return void
     */
    public function saveCodes()
    {
        $codes = $this->dao->select('domain, code')->from(TABLE_SITE)->fetchPairs();
        $content = "<?php\n";
        foreach($codes as $domain => $code)
        {
            $content .= "\$config->sites['$domain'] = '$code';\n";
        }
        $siteConfig = $this->app->getTmpRoot() . 'sites.php';
        file_put_contents($siteConfig, $content);
    }
   
    /**
     * Delete a site.
     * 
     * @param  mixed $siteID 
     * @access public
     * @return void
     */
    public function delete($siteID)
    {
        return $this->dao->delete()->from(TABLE_SITE)->where('id')->eq((int)$siteID)->limit(1)->exec();
    }

    /**
     * Process a site, get the fullLogURL and menus.
     * 
     * @param  mixed $site 
     * @access private
     * @return void
     */
    private function processSite($site)
    {
        $site->fullLogoURL = $this->app->getWebRoot() . "data/site/{$site->id}/{$site->logo}";
        $menus = explode(',', $site->menus);

        foreach($menus as $menu)
        {
            if(is_numeric($menu))
            {
                $menuName = $this->dao->findById($menu)->from(TABLE_MODULE)->fields('name')->fetch('name');
                $menuLink = html::a(helper::createLink('article', 'browse', "moduleID=$menu", 'html'), $menuName);
            }
            else
            {
                @list($menuName, $url, $target) = explode('|', $menu);
                $menuLink = html::a($url, $menuName, $target);
            }
            $menuLinks[] = $menuLink;
        }
        $site->menuLinks = $menuLinks;
    }

    /**
     * Get domain with lang, for example www.xirang.biz/en/.
     * 
     * @access public
     * @return string
     */
    public function getDomainWithLang()
    {
        $langPath = '';
        if($this->server->request_uri and $slashPositon = strpos($this->server->request_uri, '/', 1)) $langPath = substr($this->server->request_uri, 0, $slashPositon + 1);

        $domainWithLang = $this->server->server_name . $langPath;
        return isset($this->config->sites[$domainWithLang]) ? $domainWithLang : $this->server->server_name;
    }
}
