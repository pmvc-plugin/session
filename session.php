<?php
namespace PMVC\PlugIn\session;

use PMVC\PlugIn; 

\PMVC\l(__DIR__.'/src/BaseSession.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\session';

class session extends PlugIn
{
    public function init()
    {
        \PMVC\set(
            $this,
            \PMVC\get(
                \PMVC\getOption('PLUGIN'),
                $this[\PMVC\NAME]
            )
        );
        if ($this['saveHandler']) {
            session_set_save_handler($this->{$this['saveHandler']}(), true);
        }
        if ($this['name']) {
            session_name($this['name']);
        }
        if (empty($this['disableStart'])) {
            session_start();
        }
    }
}
