<?php
PMVC\Load::plug();
PMVC\addPlugInFolders(['../']);
class SessionTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'session';

   /**
    * @runInSeparateProcess
    */
    public function testPlugin()
    {
        set_error_handler( function (){ });
        ob_start();
        print_r(PMVC\plug($this->_plug, array('disableStart'=>true)));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    public function testGetSessionId()
    {
        $p = \PMVC\plug($this->_plug);
        $this->assertNull($p->getSessionId());
    }



}
