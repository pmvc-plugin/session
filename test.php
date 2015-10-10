<?php
PMVC\Load::plug();
PMVC\addPlugInFolder('../');
class SessionTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'session';

   /**
    * @runInSeparateProcess
    */
    function testPlugin()
    {
        set_error_handler( function (){ });
        ob_start();
        print_r(PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

}
