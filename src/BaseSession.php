<?php
namespace PMVC\PlugIn\session;

use SessionHandlerInterface;

abstract class BaseSession
    //http://php.net/manual/en/class.sessionhandlerinterface.php 
    implements SessionHandlerInterface
{
    public function close() { }

    abstract public function destroy( $sessionId );

    public function gc( $maxLifeTime )
    {
        return true;
    }

    public function open( $savePath, $sessionName ) { }

    abstract public function read( $sessionId );

    abstract public function write( $sessionId, $sessionData );
}
