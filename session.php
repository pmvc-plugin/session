<?php
namespace PMVC\PlugIn\session;

use PMVC\PlugIn; 

\PMVC\l(__DIR__.'/src/BaseSession.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\session';

class session extends PlugIn
{
    private $_sessionId;

    /**
     * Session config http://php.net/manual/en/session.configuration.php
     */
    public function init()
    {
        if ($this['saveHandler']) {
            session_set_save_handler($this->{$this['saveHandler']}(), true);
        }
        $this['cookie'] = array_replace(
            \PMVC\plug('cookie')['params'],
            \PMVC\toArray($this['cookie'])
        );
        $sessionId = $this->getSessionId();
        if (!empty($sessionId)) {
            $this->start();
        }
    }

    public function getName($new = null)
    {
        if (!empty($new)) {
            $this['name'] = session_name($new);
        } else {
            $this['name'] = session_name();
        }
        return $this['name'];
    }

    public function getSessionId()
    {
        if (empty($this->_sessionId)) {
            $name = $this->getName($this['name']);
            $this->_sessionId = \PMVC\plug('cookie')->get($name);
        }
        return $this->_sessionId;
    }
    
    public function start()
    {
        if (empty($this['disableStart'])) {
            $cParams = $this['cookie'];
            call_user_func_array(
                'session_set_cookie_params',
                $cParams 
            );
            $name = $this->getName();
            $value = $this->getSessionId(); 
            if (empty($value)) {
                $value = session_id();
            }
            $this->setCookie($name, $value);
            session_start();
            $this['disableStart'] = true;
        }
        return $this[\PMVC\THIS];
    }

    public function setCookie($key, $val)
    {
        \PMVC\plug('cookie')->
            set($key, $val, $this['cookie']);
    }

    public function getLifeTime()
    {
        return \PMVC\get($this['cookie'], 'lifetime');
    }
}
