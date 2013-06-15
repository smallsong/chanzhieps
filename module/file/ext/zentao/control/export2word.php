<?php
class file extends control
{
    /**
     * Init for word 
     * 
     * @access public
     * @return void
     */
    public function init()
    {
        // post content: kind(string), exportFields(array), fields(array), rows(array), tableName(string), style(array), header(array).
        $this->app->loadClass('phpword', true);
        $this->kind         = $this->post->kind;
        $this->modules      = $this->post->modules;
        $this->phpWord      = new PHPWord();
        $this->htmlDom      = new simple_html_dom();
        $this->section      = $this->phpWord->createSection();
        $this->exportFields = $this->config->word->{$this->kind}->exportFields;
        $this->host         = 'http://' . $this->server->http_host;
        foreach($this->config->word->titles as $id => $title) $this->addTitleStyle($id);
        $this->filePath = $this->app->getBasePath() . 'www/';
        $this->phpWord->addParagraphStyle('pStyle', array('spacing'=>100));
        $this->initialState = array(
            'phpword_object' => &$this->phpWord, 
            'base_root' => $this->host, 
            'base_path' => '/', 

            'current_style' => array('size' => '11'), 
            'parents' => array(0 => 'body'), 
            'list_depth' => 0, 
            'context' => 'section',
            'pseudo_list' => TRUE,
            'pseudo_list_indicator_font_name' => 'Wingdings',
            'pseudo_list_indicator_font_size' => '7',
            'pseudo_list_indicator_character' => 'l ',
            'table_allowed' => TRUE,
            'treat_div_as_paragraph' => TRUE,

            'style_sheet' => htmltodocx_styles_example()
        );    
    }

    /**
     * Export to Word 
     * 
     * @access public
     * @return void
     */
    public function export2Word()
    {
        $this->init();
        $headerName = $this->post->fileName;

        $treeMenu = array();
        foreach($this->modules as $id => $module)
        {
            if(empty($module->id)) continue;

            if(isset($treeMenu[$module->id]) and !empty($treeMenu[$module->id]))
            {
                if(!isset($treeMenu[$module->parent])) $treeMenu[$module->parent] = array();
                $treeMenu[$module->parent][$module->id] = $module->id;
                $treeMenu[$module->parent][$module->id] = $treeMenu[$module->id];
                unset($treeMenu[$module->id]);
            }
            else
            {
                    $treeMenu[$module->parent][$module->id] = $module->id;
            }
        }
        ksort($treeMenu[0]);

        if($headerName)
        {
            $this->phpWord->addParagraphStyle('headerStyle', array('align' => 'center'));
            $this->section->addText($headerName, array('bold' => true, 'size' => 22), 'headerStyle');
            $textRun = $this->section->createTextRun('headerStyle');
            $textRun->addText('(' .$this->lang->word->headNotice, array('color' => 'CCCCCC'));
            $textRun->addLink(substr($this->server->http_referer, 0, strpos($this->server->http_referer, '/', 10)), $this->lang->word->visitZentao, array('color'=>'0000FF', 'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE));
            $textRun->addText(')', array('color' => 'CCCCCC'));
            if($this->post->account) $this->section->addText(sprintf($this->lang->word->export->account, $this->post->account), null, 'headerStyle');
            $this->section->addTextBreak(2);
        }

        foreach($treeMenu as $moduleID => $module)
        {
            $this->createWord($module);
        }

        unset($this->htmlDom);
        header('Content-Type: application/vnd.ms-word');
        header("Content-Disposition: attachment;filename=\"{$this->post->fileName}.docx\"");
        header('Cache-Control: max-age=0');

        $wordWriter = PHPWord_IOFactory::createWriter($this->phpWord, 'Word2007');
        $wordWriter->save('php://output');
        exit;
    }

    public function createWord($module, $step = 1, $order = 0)
    {
        if(is_array($module))
        {
            foreach($module as $id => $childModule)
            {
                $order = $this->getNextOrder($order, $step + 1);
                if(is_array($childModule))$this->createTitle($id, $step + 1, $order);
                $this->createWord($childModule, $step + 1, $order);
            }
        }
        else
        {
            $this->createTitle($module, $step, $order);
        }
    }

    public function createTitle($moduleID, $step, $order)
    {
        $moduleName = $this->modules[$moduleID]->name;
        $this->section->addTitle($order . " " . $moduleName, $step);
        $this->section->addTextBreak(1);
        $articles = $this->dao->select('t2.id, t2.title, t2.content')->from(TABLE_ARTICLEMODULE)->alias('t1')
            ->leftJoin(TABLE_ARTICLE)->alias('t2')->on('t2.id=t1.article')
            ->where('t1.module')->eq($moduleID)
            ->orderBy('t2.id')
            ->fetchAll('id');
        foreach($articles as $articleID => $article)
        {
            $order = $this->getNextOrder($order, $step + 1);
            $this->createContent($article, $step + 1, $order);
        }
    }

    public function createContent($article, $step, $order)
    {
        if(empty($article)) return;
        $content  = $article;
        foreach($this->exportFields as $exportField)
        {
            $fieldName = $exportField;
            $style = $this->config->word->{$this->kind}->style[$exportField];
            if($style == 'title')
            {
                $fieldContent = $order . ' ' . $content->$fieldName;
                $this->section->addTitle($fieldContent, $step);
                $this->section->addTextBreak();
            }
            elseif($style == 'showImage')
            {
                $fieldContent = $content->$fieldName;
                $fieldContent = preg_replace_callback('/<img src="(.+)" alt=".*" \/>/U', 'checkFileExist', $content->$fieldName);
                if(preg_match('/^[a-z0-9]+/', $fieldContent)) $fieldContent = "<br />" . $fieldContent;

                $this->htmlDom->load('<html><body>' . $fieldContent . '</body></html>');
                $htmlDomArray = $this->htmlDom->find('html',0)->children();
                htmltodocx_insert_html($this->section, $htmlDomArray[0]->nodes, $this->initialState);
                $this->htmlDom->clear(); 
                $this->section->addTextBreak();
            }
            elseif($fieldName == 'files')
            {
                $this->formatFiles($content);
            }
            else
            {
                $textRun = $this->section->createTextRun('pStyle');
                $textRun->addText($this->fields[$fieldName] . "：", array('bold' => true));
                $textRun->addText($content->$fieldName, null);
            }
        }
        $this->section->addTextBreak();
    }

    public function formatFiles($content)
    {
        if(empty($content->files)) return;
        $this->section->addText($this->fields['files'] . ':', array('bold' => true));
        $fieldContent = explode('<br />', $content->files);
        foreach($fieldContent as $linkHtml)
        {
            if(empty($linkHtml)) continue;
            preg_match("/<a href='([^']+)'[^>]*>(.+)<\/a>/", $linkHtml, $out);
            $linkHref = $out[1];
            $extension = strtolower(trim(strrchr($linkHref, '.'), '.'));
            $linkName = $out[2];
            if(in_array($extension, $this->config->word->imageExtension))
            {
                $linkHref = strstr(strstr($linkHref, $this->server->server_name), '/');
                if(!file_exists($this->filePath . $linkHref)) continue;
                $this->section->addImage($this->filePath . $linkHref);
                $this->section->addTextBreak();
            }
            else
            {
                $this->section->addLink($linkHref, $linkName . ".$extension", array('color'=>'0000FF', 'underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE));
            }
        }
    }

    public function addTitleStyle($step)
    {
        $size = isset($this->config->titles[$step]) ? $this->config->titles[$step]->size : 12;
        $this->phpWord->addTitleStyle($step, array('size'=> $size, 'color'=>'010101', 'bold'=>true));
    }

    public function getNextOrder($order, $step)
    {
        if($step == 1) return 0;
        $orders = explode('.', $order);
        if(count($orders) + 1 == $step -1)
        {
            $order .= '.1';
        }
        else
        {
            $orders[count($orders) -1] = end($orders) + 1;
            $order = join('.', $orders);
        }
        return $order;
    }

}

function checkFileExist($matches)
{
    global $app;
    $filePath = $app->getBasePath() . 'www/';
    return file_exists($filePath . $matches[1]) ? "<img src='$matches[1]' alt='' />" : '';
}

