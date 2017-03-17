<?php
namespace PMVC\PlugIn\session;

use SessionHandlerInterface;

abstract class BaseSession
    //http://php.net/manual/en/class.sessionhandlerinterface.php 
    implements SessionHandlerInterface
{
    public function close() { }
    public function open( $savePath, $sessionName ) { }
    public function gc( $maxLifeTime )
    {
        return true;
    }

    abstract public function destroy( $sessionId );
    abstract public function read( $sessionId );
    abstract public function write( $sessionId, $sessionData );
}
