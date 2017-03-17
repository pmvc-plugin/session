<?php
namespace PMVC\PlugIn\session;

use PMVC\PlugIn; 

\PMVC\l(__DIR__.'/src/BaseSession.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\session';

class session extends PlugIn
{
    public function init()
    {
        if ($this['saveHandler']) {
            session_set_save_handler($this->{$this['saveHandler']}(), true);
        }
        if ($this['name']) {
            session_name($this['name']);
        }
        $cookie = \PMVC\get($_COOKIE,$this['name']);
        if (!empty($cookie)) {
            $this->start();
        }
    }
    
    public function start()
    {
        if (empty($this['disableStart'])) {
            session_start();
            $this['disableStart'] = true;
        }
    }
}
