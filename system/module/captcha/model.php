<?php
/**
 * The model file of captcha module of chanzhiEPS.
 *
 * @copyright   Copyright 2013-2013 青岛息壤网络信息有限公司 (QingDao XiRang Network Infomation Co,LTD www.xirangit.com)
 * @license     LGPL
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     captcha
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class captchaModel extends model
{
    /**
     * Check something is evil or not.
     * 
     * @param  string $content 
     * @access public
     * @return bool
     */
    public function isEvil($content = '')
    {
        $isEvil = false;
        if(strpos($content, 'http://') !== false) return true;

        $lineCount = preg_match_all('/(?<=href=)([^\>]*)(?=\>)/ ', $content, $out);
        if($lineCount > 1) $isEvil = true;

        if($lineCount > 5) die();
        if(preg_match('/\[url=.*\].*\[\/url\]/U', $content)) die();

        return false;
    }

    /**
     * Create captcha for comment.
     * 
     * @access public
     * @return string
     */
    public function create4Comment()
    {
        $captcha = $this->create();
        return <<<EOT
<th>{$this->lang->captcha->common}</th>;
<td>
  <div class="col-lg-6">
  <h4><span class='label label-danger'>{$captcha->first} {$captcha->operator} {$captcha->second}</span>&nbsp;&nbsp;
  {$this->lang->captcha->equal} &nbsp;&nbsp;
  <input type='text' name='captcha' id='captcha' class='w-60px a-center' placeholder='{$this->lang->captcha->placeholder}' />
  </h4>
  </div>
</td>;
EOT;
    }

    /**
     * Create captcha.
     * 
     * @access public
     * @return object.
     */
    public function create()
    {
        /* Get random two numbers and random operator. */
        $operators      = array_keys($this->lang->captcha->operators);
        $firstRand      = mt_rand(0, 10);
        $secondRand     = mt_rand(0, 10);
        $randomOperator = $operators[array_rand($operators)];

        /* Compute the result and save it to session. */
        $expression = "\$captcha = $firstRand $randomOperator $secondRand;";
        eval($expression);
        $this->session->set('captcha', $captcha);

        /* Return the captcha data. */
        $captcha = new stdclass();
        $captcha->first    = $this->lang->captcha->numbers[$firstRand];
        $captcha->second   = $this->lang->captcha->numbers[$secondRand];
        $captcha->operator = $this->lang->captcha->operators[$randomOperator];

        return $captcha;
    }
}
