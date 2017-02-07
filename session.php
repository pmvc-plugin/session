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
            $option = \PMVC\getOption('PLUGIN');
            $this['api'] = \PMVC\value($option, [$this[\PMVC\NAME],'api']); 
        }
        if (empty($this['api'])) {
            return !trigger_error(
                'Need set session api url',
                E_USER_WARNING
            );
        }
        session_set_save_handler($this->curl(), true);
        if (empty($this['disable_start'])) {
            session_start();
        }
    }
}
