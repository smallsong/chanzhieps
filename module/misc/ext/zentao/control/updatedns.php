<?php
class misc extends control
{
    public function updateDNS()
    {
        if($this->get->key != $this->config->dns->key) die("key error\n");
        $this->dao->update($this->config->dns->table)
            ->set('content')->eq($this->server->remote_addr)
            ->where('id')->in($this->config->dns->records)->exec(false);
        die(date('Y-m-d H:i:s') . " updated to {$this->server->remote_addr}\n");
    }
}
