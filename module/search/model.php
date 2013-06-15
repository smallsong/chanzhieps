<?php
/**
 * The model file of search module of XiRangBPS.
 *
 * @copyright   Copyright 2012-2013 QingDao XiRang Network Infomation Co,LTD (www.xirang.biz)
 * @license     LGPL (http://www.gnu.org/licenses/lgpl.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     search
 * @version     $Id$
 * @link        http://www.xirang.biz
 */
class searchModel extends model
{
    public function getBingResult($key)
    {
        $query = urlencode("site:{$this->config->bing->site} $key");
        $api   = 'http://api.search.live.net/json.aspx?sources=web&web.count=50';
        $api  .= "&Appid={$this->config->bing->appID}";
        $api  .= "&query=$query";
        $response = file_get_contents($api);
        $results  = json_decode($response);
        if($results->SearchResponse->Web->Total == 0) return array();
        return $results->SearchResponse->Web->Results;
    }

    /**
     * Process docs.
     * 
     * @param  array    $docs 
     * @param  object   $search 
     * @access public
     * @return array.
     */
    public function processDocs($docs, $search) 
    {
        $results = array();
        if(!$docs) return $results;

        $url     = "http://" . $this->config->default->domain . "/";
        foreach($docs as $doc)
        {
            $title = $doc->title ? $doc->title : '';

            if($doc->objectType == 'extension')     $results[$doc->id]->url = $url . "extension-viewExt-$doc->objectID.html";
            else if($doc->objectType == 'faq')      $results[$doc->id]->url = $url . "ask-faq.html#faq$doc->objectID";
            else if($doc->objectType == 'gift')     $results[$doc->id]->url = $url . "gift-exchange-$doc->objectID.html";
            else if($doc->objectType == 'question') $results[$doc->id]->url = $url . "ask-view-$doc->objectID.html";
            else if($doc->objectType == 'article')  
            {
                $article = $this->dao->select('*')->from(TABLE_ARTICLE)->alias('t1')
                    ->leftJoin(TABLE_ARTICLEMODULE)->alias('t2')
                    ->on('t1.id = t2.article')
                    ->where('t1.id')->eq($doc->objectID)
                    ->andWhere('t2.site')->eq($this->app->site->id)
                    ->fetch('', false);
                if(!$article) continue;

                $results[$doc->id]->url = $url . "article-view-$doc->objectID.html";
            }
            else if($doc->objectType == 'answer') 
            {
                $question = $this->dao->select('t1.id, t1.title')->from(TABLE_QUESTION)->alias('t1')
                    ->leftJoin(TABLE_ANSWER)->alias('t2')
                    ->on('t1.id = t2.question')
                    ->where('t2.id')->eq($doc->objectID)
                    ->fetch('', false);
                if(!$question) continue;

                $title = $question->title;
                $results[$doc->id]->url = $url . "ask-view-$question->id.html";
            }
            else if($doc->objectType == 'thread')
            {
                $thread = $this->dao->select('*')->FROM(TABLE_THREAD)->where('id')->eq($doc->objectID)->fetch('', false);
                if(!$this->loadModel('tree')->getById($thread->module)) continue;
                $results[$doc->id]->url = $url . "$doc->objectType-view-$doc->objectID.html";
            }
            else if($doc->objectType == 'reply')
            {
                $threadID = $this->dao->select('thread')->from(TABLE_REPLY)->where('id')->eq($doc->objectID)->fetch('thread', false);
                $thread   = $this->dao->select('*')->FROM(TABLE_THREAD)->where('id')->eq($threadID)->fetch('', false);
                if(!$this->loadModel('tree')->getById($thread->module)) continue;
                $title = $thread->title;
                $results[$doc->id]->url = $url . "thread-view-$threadID.html#$doc->objectID";
            }
            else if($doc->objectType == 'comment')
            {
                $comment = $this->dao->select('*')->from(TABLE_COMMENT)->where('id')->eq($doc->objectID)->fetch('', false);
                if($comment->objectType == 'answer') 
                {
                    $question = $this->dao->select('t1.id, t1.title')->from(TABLE_QUESTION)->alias('t1')
                        ->leftJoin(TABLE_ANSWER)->alias('t2')
                        ->on('t1.id = t2.question')
                        ->where('t2.id')->eq($comment->objectID)
                        ->fetch('', false);
                    if(!$question) continue;

                    $title = $question->title;
                    $results[$doc->id]->url = $url . "ask-view-$question->id.html";
                }
                else if($comment->objectType == 'doc' or $comment->objectType == 'article')
                {
                    $article = $this->dao->select('*')->from(TABLE_ARTICLE)->alias('t1')
                        ->leftJoin(TABLE_ARTICLEMODULE)->alias('t2')
                        ->on('t1.id = t2.article')
                        ->where('t1.id')->eq($comment->objectID)
                        ->andWhere('t2.site')->eq($this->app->site->id)
                        ->fetch('', false);
                    if(!$article) continue;
                    $title = $article->title;

                    $results[$doc->id]->url = $url . "article-view-$comment->objectID.html";
                }
                else if($comment->objectType == 'usercase')
                {
                    $title = $this->dao->select('company')->from(TABLE_USERCASE)->where('id')->eq($comment->objectID)->fetch('company', false);
                    $results[$doc->id]->url = $url . "usercase-view-$comment->objectID.html";
                }
            }
            else
            {
                $results[$doc->id]->url = $url . "$doc->objectType-view-$doc->objectID.html";
            }

            $results[$doc->id]->objectType = $doc->objectType;
            $results[$doc->id]->title      = $search->highlight(strip_tags($title));
            $results[$doc->id]->content    = $search->highlight(strip_tags($doc->content));
        }

        return $results;
    }
}
