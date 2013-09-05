<?php
/**
 * The model file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class blockModel extends model
{
    /**
     * Get block by id.
     * 
     * @param string $blockId 
     * @access public
     * @return object   the block.
     */
    public function getById($blockId)
    {
        return $this->dao->findById($blockId)->from(TABLE_BLOCK)->fetch();
    }

    /**
     * Get block list of one site.
     * 
     * @access public
     * @return array    the block lists.
     */
    public function getList()
    {
        return $this->dao->select('*')->from(TABLE_BLOCK)->orderBy('id')->fetchAll('id');
    }

    /**
     * Get block id => title pairs.
     * 
     * @access public
     * @return void
     */
    public function getPairs()
    {
        return $this->dao->select('id, title')->from(TABLE_BLOCK)->orderBy('id')->fetchPairs();
    }

    /**
     * Get the layous of one page.
     * 
     * @param string $page          the page
     * @param string $includeAll    include the blocks for all pages or not
     * @access public
     * @return array                the layouts of the page.
     */
    public function getLayouts($page, $includeAll = true)
    {
        if($includeAll) $page .= ', all';

        /* Fetch all blocks first. */
        $layouts = $this->dao->select('region, blocks')->from(TABLE_LAYOUT)->where('page')->in($page)->fetchpairs();

        /* Get all block id list, then fetch their full records. */
        $blocks = '';
        foreach($layouts as $regionBlocks) $blocks .= ',' . $regionBlocks;
        $blocks = $this->dao->select()->from(TABLE_BLOCK)->where('id')->in($blocks)->fetchAll('id');

        /* Group them by region. */
        foreach($layouts as $region => $regionBlocks)
        {
            $regionBlocks = explode(',', $regionBlocks);
            unset($layouts[$region]);
            foreach($regionBlocks as $block) $layouts[$region][$block] = $blocks[$block];
        }

        return $layouts;
    }

    /**
     * Get the regin => blocks pairs of one page.
     * 
     * @param string $page 
     * @param string $includeAll 
     * @access public
     * @return void
     */
    public function getLayoutPairs($page, $includeAll = true)
    {
        if($includeAll) $page .= ', all';
        return $this->dao->select('region, blocks')->from(TABLE_LAYOUT)->where('page')->in($page)->fetchpairs();
    }

    /**
     * Create a block.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $block = fixer::input('post')->get();
        $this->dao->insert(TABLE_BLOCK)->data($block)->autoCheck()->exec();
        return;
    }

    /**
     * Update  block.
     * 
     * @param string $blockId 
     * @access public
     * @return void
     */
    public function update($blockId)
    {
        $block = fixer::input('post')->get();
        $this->dao->update(TABLE_BLOCK)->data($block)->autoCheck()->where('id')->eq($blockId)->exec();
        return;
    }

    /**
     * Set one page's layout.
     * 
     * @param string $page 
     * @access public
     * @return void
     */
    public function setPage($page)
    {
        $layouts = array();

        foreach($_POST as $region => $regionBlocks)
        {
            $region = str_replace('region', '', $region);
            $layout = new stdclass();
            foreach($regionBlocks as $block)
            {
                if(!$block) continue;
                $layout->page     = $page;
                $layout->region   = $region;
                $layout->blocks[] = $block;
            }
            if(isset($layout->blocks)) $layouts[] = $layout;
        }

        $this->dao->delete()->from(TABLE_LAYOUT)->where('page')->eq($page)->exec();
        foreach($layouts as $layout)
        {
            $layout->blocks = join(',', $layout->blocks);
            $this->dao->insert(TABLE_LAYOUT)->data($layout)->exec();
        }
    }

    /**
     * Print the blocks of one region.
     * 
     * @param string $blocks        the blocks
     * @param string $region        the region 
     * @param string $showBoard     where print the order or not
     * @access public
     * @return void
     */
    public function printBlock($blocks, $region, $showBoard = true)
    {
        if(!isset($blocks[$region])) return;
        $blocks = $blocks[$region];
        foreach($blocks as $block)
        {
            if($showBoard)
            {
                echo "<div class='box-title'>$block->title</div>";
                echo '<div class="box-content">';
                $this->parseBlockContent($block);
                echo '</div>';
            }
            else
            {
                echo "<div>" . $this->parseBlockContent($block) . "</div>";
            }
        }
    }

    /**
     * Parse the content of one block.
     * 
     * @param string $block 
     * @access private
     * @return void
     */
    private function parseBlockContent($block)
    {
        if($block->type == 'html' )
        {
            echo $block->content;
        }
        elseif($block->type == 'php')
        {
            eval($block->content);
        }
        /* If the type is system, every line will be the param, first is module, second is method, last are params of the method. */
        elseif($block->type == 'system')
        {
            $params = explode("\n", trim($block->content));
            if(count($params) < 2) return;
            $module = trim($params[0]);
            $method = trim($params[1]);
            unset($params[0]);
            unset($params[1]);
            echo $this->app->control->fetch($module, $method, $params);
        }
    }
}
