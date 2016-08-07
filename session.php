<?php
namespace PMVC\PlugIn\session;

use PMVC\PlugIn; 
use SessionHandlerInterface;

\PMVC\l(__DIR__.'/src/BaseSession.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\session';

class session extends PlugIn
{
    public function init()
    {
        if (empty($this['api'])) {
            $api = \PMVC\plug('url')->realUrl();
            $api = str_replace('index.php','api.php', $api); 
            $this['api'] = $api.'/session/';
        }
        session_set_save_handler($this->curl(), true);
        if (empty($this['disable_start'])) {
            session_start();
        }
    }
}
