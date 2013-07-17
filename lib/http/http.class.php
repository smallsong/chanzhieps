<?php
class http
{
    public $app;
    public $config;
    public $snoopy;
    public $logs;

    /**
     * Construct function, init app, config and snoopy.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        global $app, $config;
        $this->app    = $app;
        $this->config = $config;
        $this->snoopy = $this->app->loadClass('snoopy');
    }

    /**
     * Fetch a url by get.
     * 
     * @param  string    $url 
     * @access public
     * @return string
     */
    public function get($url)
    {
        $this->snoopy->fetch($url);
        $results = $this->snoopy->results;
        $this->log($url, $results);
        return $results;
    }

    /**
     * Post a request.
     * 
     * @param  string   $url 
     * @param  array    $vars 
     * @access public
     * @return string
     */
    public function post($url, $vars)
    {
        $this->snoopy->submit($url, $vars);
        $results = $this->snoopy->results;
        $this->log($url, $results);
        return $results;
    }

    /**
     * Log the url and results to a log file.
     * 
     * @param  string    $url 
     * @param  string    $results 
     * @access public
     * @return string
     */
    public function log($url, $results)
    {
        if(!$this->config->debug) return;

        $logFile = $this->app->getLogRoot() . 'saas.'. date('Ymd') . '.log';
        $fh = @fopen($logFile, 'a');
        if(!$fh) return false;

        fwrite($fh, date('Ymd H:i:s') . ": " . $this->app->getURI() . "\n");
        fwrite($fh, "url:    " . $url . "\n");
        fwrite($fh, "results:" . print_r($results, true));
        fwrite($fh, "\n");
        fclose($fh);
    }
}
