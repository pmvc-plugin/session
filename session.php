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
            $name = session_name($this['name']);
        } else {
            $name = session_name();
        }
        $this['cookie'] = array_replace(
            $this->defaultCookie(),
            \PMVC\get($this, 'cookie', [])
        );
        $cookie = \PMVC\get($_COOKIE, $name);
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
            $name = session_name();
            $value = \PMVC\get($_COOKIE, $name);
            if (empty($value)) {
                $value = session_id();
            }
            $this->setCookie($name, $value);
            session_start();
            $this['disableStart'] = true;
        }
    }

    public function setCookie($key, $val)
    {
        $cParams = $this['cookie'];
        setcookie(
            $key,
            $val,
            time()+$cParams['lifetime'],
            $cParams['path'],
            $cParams['domain'],
            $cParams['secure'],
            $cParams['httponly']
        );
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
