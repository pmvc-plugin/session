<?php
namespace PMVC\PlugIn\session;

// \PMVC\l(__DIR__.'/xxx.php');

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\session';

class session extends \PMVC\PlugIn
    implements \SessionHandlerInterface
{
    public function init()
    {
        session_set_save_handler($this, true);
        if (empty($this['disable_start'])) {
            session_start();
        }
    }

    public function open( $save_path , $session_name )
    {
    }

    public function close()
    {
    }

    public function read( $session_id )
    {
        $curl = \PMVC\plug('curl');
        $url = \PMVC\getOption('INTERNAL').'/session/'.$session_id;
        $return = '';
        $curl->get($url, function($serverRespond) use (&$return){
            $arr = json_decode($serverRespond->body); 
            if (!$arr) {
                return !trigger_error($serverRespond->body);
            }
            $return = $arr->session;
        });
        $curl->run();
        return $return;
    }

    public function write($session_id , $session_data )
    {
        $this[$session_id] = $session_data;
        $curl = \PMVC\plug('curl');
        $url = \PMVC\getOption('INTERNAL').'/session/'.$session_id;
        $curl->post($url, null, array('data'=>$session_data));
        $curl->run();
    }

    public function destroy( $session_id )
    {
        $curl = \PMVC\plug('curl');
        $url = \PMVC\getOption('INTERNAL').'/session/'.$session_id;
        $curl->delete($url);
        $curl->run();
    }

    public function gc( $maxlifetime )
    {
        return true;
    }
}
