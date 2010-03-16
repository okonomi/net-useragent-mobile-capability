<?php

require_once 'PHPUnit/Framework.php';
require_once 'Net/UserAgent/Mobile/Capability.php';

require_once 'Net/UserAgent/Mobile.php';


class Net_UserAgent_Mobile_CapabilityTest extends PHPUnit_Framework_TestCase
{
    public function testGetBrowserHtmlTable()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'DoCoMo/2.0 P906i(c100;TB;W24H15)';
        $ua = Net_UserAgent_Mobile::factory();
        $cap = new Net_UserAgent_Mobile_Capability($ua);

        $this->assertEquals($cap->get('browser.html.table'), true);
    }
}
