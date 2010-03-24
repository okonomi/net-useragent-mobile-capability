<?php

require_once 'PHPUnit/Framework.php';
require_once 'Net/UserAgent/Mobile/Capability.php';

require_once 'Net/UserAgent/Mobile.php';


class Net_UserAgent_Mobile_CapabilityTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $fixture = array(
            array(
                'device'    => 'D501i',
                'server'    => array(
                    'HTTP_USER_AGENT' => 'DoCoMo/1.0/D501i',
                ),
                'property'  => array(
                    'browser.html.table'   => false,
                    'browser.css'          => false,
                    'browser.css.external' => false,
                    'browser.vga'          => false,
                    'device.flash'         => false,
                ),
            ),
            array(
                'device'    => 'P906i',
                'server'    => array(
                    'HTTP_USER_AGENT' => 'DoCoMo/2.0 P906i(c100;TB;W24H15)',
                ),
                'property'  => array(
                    'browser.html.table'   => true,
                    'browser.css'          => true,
                    'browser.css.external' => false,
                    'browser.vga'          => false,
                    'device.flash'         => true,
                ),
            ),
            array(
                'device'    => 'P-07A',
                'server'    => array(
                    'HTTP_USER_AGENT' => 'DoCoMo/2.0 P07A3(c500;TB;W24H15)',
                ),
                'property'  => array(
                    'browser.html.table'   => true,
                    'browser.css'          => true,
                    'browser.css.external' => true,
                    'browser.vga'          => false,
                    'device.flash'         => true,
                ),
            ),
            array(
                'device'    => '943SH',
                'server'    => array(
                    'HTTP_USER_AGENT'       => 'SoftBank/1.0/943SH/SHJ001 Browser/NetFront/3.5 Profile/MIDP-2.0 Configuration/CLDC-1.1',
                    'HTTP_X_JPHONE_MSNAME'  => '943SH',
                    'HTTP_X_JPHONE_DISPLAY' => '480*854',
                    'HTTP_X_JPHONE_COLOR'   => 'C16777216',
                ),
                'property'  => array(
                    'browser.html.table'   => true,
                    'browser.css'          => true,
                    'browser.css.external' => true,
                    'browser.vga'          => true,
                    'device.flash'         => true,
                ),
            ),
            array(
                'device'    => 'K002',
                'server'    => array(
                    'HTTP_USER_AGENT'               => 'KDDI-KC3O UP.Browser/6.2.0.15.1.1 (GUI) MMP/2.0',
                    'HTTP_X_UP_DEVCAP_SCREENDEPTH'  => '16,RGB565',
                    'HTTP_X_UP_DEVCAP_SCREENPIXELS' => '240,348',
                    'HTTP_X_UP_DEVCAP_ISCOLOR'      => '1',
                    'HTTP_X_UP_DEVCAP_MULTIMEDIA'   => 'A300961223402120',
                ),
                'property'  => array(
                    'browser.html.table'   => true,
                    'browser.css'          => true,
                    'browser.css.external' => true,
                    'browser.vga'          => false,
                    'device.flash'         => true,
                ),
            ),
        );

        foreach ($fixture as $data) {
            $server_ = $_SERVER;

            $_SERVER = $data['server'];

            $ua = Net_UserAgent_Mobile::factory();
            $cap = new Net_UserAgent_Mobile_Capability($ua);

            foreach ($data['property'] as $name => $value) {
                try {
                    $this->assertEquals($cap->get($name), $value);
                } catch (PHPUnit_Framework_ExpectationFailedException $e) {
                    echo "{$data['device']} $name", PHP_EOL;
                    throw $e;
                }

            }

            $_SERVER = $server_;
        }
    }

    /**
     * @expectedException Net_UserAgent_Mobile_Capability_Exception
     */
    public function testGetThrowException()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'DoCoMo/1.0/D501i';
        $ua = Net_UserAgent_Mobile::factory();
        $cap = new Net_UserAgent_Mobile_Capability($ua);

        $ret = $cap->get('aaa');
    }
}
