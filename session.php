<?php
namespace PMVC\PlugIn\session;

use PMVC\PlugIn; 

\PMVC\l(__DIR__.'/src/BaseSession.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\session';

class session extends PlugIn
{
    public function init()
    {
        \PMVC\set($this, \PMVC\value(\PMVC\getOption('PLUGIN'), [$this[\PMVC\NAME]]));
        if ($this['handler']) {
            session_set_save_handler($this->{$this['handler']}(), true);
        }
        if (empty($this['disable_start'])) {
            session_start();
        }
    }
}
