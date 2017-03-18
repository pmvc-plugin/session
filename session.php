<?php
namespace PMVC\PlugIn\session;

use PMVC\PlugIn; 

\PMVC\l(__DIR__.'/src/BaseSession.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\session';

class session extends PlugIn
{
    /**
     * Session config http://php.net/manual/en/session.configuration.php
     */
    public function init()
    {
        if ($this['saveHandler']) {
            session_set_save_handler($this->{$this['saveHandler']}(), true);
        }
        if ($this['name']) {
            session_name($this['name']);
        }
        $this['cookie'] = array_replace(
            $this->defaultCookie(),
            \PMVC\get($this, 'cookie', [])
        );
        $cookie = \PMVC\get($_COOKIE,$this['name']);
        if (!empty($cookie)) {
            $this->start();
        }
    }
    
    public function start()
    {
        if (empty($this['disableStart'])) {
            $cParams = $this['cookie'];
            call_user_func_array(
                'session_set_cookie_params',
                $cParams 
            );
            session_start();
            setcookie(
                session_name(),
                session_id(),
                time()+$cParams['lifetime'],
                $cParams['path'],
                $cParams['domain'],
                $cParams['secure'],
                $cParams['httponly']
            );
            $this['disableStart'] = true;
        }
    }

    public function defaultCookie()
    {
        return [
            'lifetime'=>86400*7,
            'path'=>'/',
            'domain'=>null,
            'secure'=>false,
            'httponly'=>true
        ];
    }
}
