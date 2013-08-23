<?php
/**
 * The model file of product category of xirangEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class productModel extends model
{
    /** 
     * Get an product by id.
     * 
     * @param  int      $productID 
     * @access public
     * @return bool|object
     */
    public function getByID($productID)
    {   
        /* Get product self. */
        $product = $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->eq($productID)->fetch();
        if(!$product) return false;

        /* Get it's categories. */
        $product->categories = $this->dao->select('t2.*')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('t1.type')->eq('product')
            ->andWhere('t1.id')->eq($productID)
            ->fetchAll('id');

        /* Get product path to highlight main nav. */
        $path = '';
        foreach($product->categories as $category) $path .= $category->path;
        $product->path = explode(',', trim($path, ','));

        /* Get it's files. */
        $product->files = $this->loadModel('file')->getByObject('product', $productID);

        $product->images = $this->file->getByObject('product', $productID, $isImage = true );

        return $product;
    }   

    /** 
     * Get product list.
     * 
     * @param  array   $categories 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($categories, $orderBy, $pager = null)
    {
        /* Get products(use groupBy to distinct products).  */
        $products = $this->dao->select('t1.*, t2.category')->from(TABLE_PRODUCT)->alias('t1')
            ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
            ->where('1 = 1')
            ->beginIF($categories)->andWhere('t2.category')->in($categories)->fi()
            ->groupBy('t2.id')
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        if(!$products) return array();

        /* Get categories for these products. */
        $categories = $this->dao->select('t2.id, t2.name, t1.id AS product')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('1 = 1')
            ->beginIF($categories)->andWhere('t1.category')->in($categories)->fi()
            ->fetchGroup('product', 'id');

        /* Assign categories to it's product. */
        foreach($products as $product) $product->categories = $categories[$product->id];

        /* Get images for these products. */
        $images = $this->loadModel('file')->getByObject('product', array_keys($products), $isImage = true);

        /* Assign images to it's product. */
        foreach($products as $product)
        {
            if(empty($images[$product->id])) continue;

            $product->image = new stdclass();
            $product->image->list    = $images[$product->id];
            $product->image->primary = $product->image->list[0];
        }
        
        /* Assign summary to it's product. */
        foreach($products as $product) $product->summary = empty($product->summary) ? substr(strip_tags($product->content), 0, 300) : $product->summary;

        return $products;
    }

    /**
     * get latest products. 
     *
     * @param array      $categories
     * @param int        $count
     * @access public
     * @return array
     */
    public function getLatest($categories, $count)
    {
        return $this->dao->select('t1.id, t1.title')
            ->from(TABLE_PRODUCT)->alias('t1')
            ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
            ->beginIF($categories)->andWhere('t2.category')->in($categories)->fi()
            ->orderBy('id_desc')
            ->limit($count)
            ->fetchPairs('id', 'title');
    }

    /**
     * Create a product.
     * 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $product = fixer::input('post')
            ->join('categories', ',')
            ->add('author', $this->app->user->account)
            ->add('addedDate', helper::now())
            ->get();

        $this->dao->insert(TABLE_PRODUCT)
            ->data($product, $skip = 'categories')
            ->autoCheck()
            ->batchCheck($this->config->product->create->requiredFields, 'notempty')
            ->exec();

        if(dao::isError()) return false;

        $productID = $this->dao->lastInsertID();
        $this->processCategories($productID, $this->post->categories);
        return $productID;
    }

    /**
     * Update a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function update($productID)
    {
        $product = fixer::input('post')
            ->remove('categories')
            ->add('editor', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_PRODUCT)
            ->data($product)
            ->autoCheck()
            ->batchCheck($this->config->product->edit->requiredFields, 'notempty')
            ->where('id')->eq($productID)
            ->exec();

        if(!dao::isError()) $this->processCategories($productID, $this->post->categories);
        return;
    }
        
    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID, $null = null)
    {
        $product = $this->getByID($productID);
        if(!$product) return false;

        $this->dao->delete()->from(TABLE_RELATION)->where('id')->eq($productID)->andWhere('type')->eq('product')->exec();
        $this->dao->delete()->from(TABLE_PRODUCT)->where('id')->eq($productID)->exec();

        return !dao::isError();
    }

    /**
     * Process categories for a product.
     * 
     * @param  int    $productID 
     * @param  array  $categories 
     * @access public
     * @return void
     */
    public function processCategories($productID, $categories = array())
    {
       if(!$productID) return false;
       $type = 'product'; 

       /* First delete all the records of current product from the releation table.  */
       $this->dao->delete()->from(TABLE_RELATION)
           ->where('type')->eq($type)
           ->andWhere('id')->eq($productID)
           ->autoCheck()
           ->batchCheck('type, id', 'notempty')
           ->exec();

       /* Then insert the new data. */
       foreach($categories as $category)
       {
           if(!$category) continue;

           $data = new stdclass();
           $data->type     = $type; 
           $data->id       = $productID;
           $data->category = $category;

           $this->dao->insert(TABLE_RELATION)->data($data)->exec();
       }
    }

    /**
     * Create preview link. 
     * 
     * @param  int    $productID 
     * @param  string $type         product|help
     * @access public
     * @return string
     */
    public function createPreviewLink($productID, $type = 'product')
    {
        $module = $type == 'product' ? 'product' : 'help';
        $method = $type == 'product' ? 'view'    : 'read';

        return commonModel::createFrontLink($module, $method, "productID=$productID");
    }
}
