<?php
namespace PMVC\PlugIn\session;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\curl';

class curl extends BaseSession
{
    private $_api;

    public function __invoke()
    {
        if (empty($this->caller['api'])) {
            return !trigger_error(
                'Need set session api url',
                E_USER_WARNING
            );
        } else {
            $this->_api = $this->caller['api'];
        }
        return $this;
    }

    public function destroy( $session_id )
    {
        $curl = \PMVC\plug('curl');
        $url = $this->_api.$session_id;
        $curl->delete($url);
        $curl->process();
    }

    public function read( $session_id )
    {
        $curl = \PMVC\plug('curl');
        $url = $this->_api.$session_id;
        $return = '';
        $curl->get($url, function($serverRespond) use (&$return, $url){
            $arr = json_decode($serverRespond->body); 
            if (!$arr) {
                return !trigger_error(
                    "Get Session fail\n".
                    $url."\n".
                    $serverRespond->body
                );
            }
            $return = \PMVC\get($arr, 'session');
        });
        $curl->process();
        return $return;
    }

    public function write($session_id , $session_data )
    {
        $curl = \PMVC\plug('curl');
        $url = $this->_api.$session_id;
        $curl->post($url, null, array('data'=>$session_data));
        $curl->process();
    }

}
