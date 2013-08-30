<?php
class help extends control
{
    public function proxy($url = '', $domain = '')
    {
        $cachePath = $this->app->getTmpRoot() . 'cache/5upm/help/';
        if(!is_dir($cachePath)) mkdir($cachePath, 0777, true);

        $url     = empty($url) ? '/help-book-zentaopmshelp.html?onlybody=yes' : helper::safe64Decode($url);
        $domain  = empty($domain) ? 'http://www.zentao.net' : helper::safe64Decode($domain);
        $this->post->set('domain', $domain);
        $this->post->set('url', $url);
        $this->post->set('title', $this->lang->common->title);
        $fullUrl = $domain . $url;

        if(strpos($url, '/?onlybody=yes') === 0)die(js::locate('http://' . $this->server->http_host, 'top'));

        $cacheFile = $cachePath . ltrim($url, '/') . date('Y-m-d', strtotime('+1 day'));
        if(file_exists($cacheFile))
        {
            $helpContent = file_get_contents($cacheFile);
        }
        else
        {
            $http = $this->app->loadClass('http');
            $helpContent = $http->get($fullUrl);
            $helpContent = preg_replace_callback("/<a (.*)href=(['\"])(.+)['\"](.*)>(.*)<\/a>/Ui", "replace", $helpContent);
            $md5Content  = md5($helpContent);

            foreach(glob($cachePath . ltrim($url, '/') . '*') as $file)
            {
                if(md5_file($file) == $md5Content)
                {
                    rename($file, $cacheFile);
                    $rename = true;
                }
                else
                {
                    unlink($file);
                }
            }
            if(empty($rename)) file_put_contents($cacheFile, $helpContent);
        }

        echo $helpContent;
    }
}

function replace($matches)
{
    $domain = $_POST['domain'];
    $url    = $_POST['url'];
    $url    = strpos($url, '#') === false ? $url : substr($url, 0, strpos($url, '#'));
    $matches[3] = preg_match('/^#[0-9]+$/', trim($matches[3])) == 1 ?  $url. $matches[3] : $matches[3];
    $matches[5] = strpos($matches[3], '/?onlybody=yes') === 0 ? $_POST['title'] : $matches[5];
    return "<a {$matches[1]}href={$matches[2]}" . inlink('proxy', 'url=' . helper::safe64Encode($matches[3]) . '&domain=' . helper::safe64Encode($domain)) . "{$matches[2]}{$matches[4]}>{$matches[5]}</a>";
}
