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
                'useragent' => 'DoCoMo/1.0/D501i',
                'property'  => array(
                    'browser.html.table'        => false,
                    'browser.html.css'          => false,
                    'browser.html.css.external' => false,
                    'device.flash'              => false,
                ),
            ),
        );

        foreach ($fixture as $data) {
            $_SERVER['HTTP_USER_AGENT'] = $data['useragent'];

            $ua = Net_UserAgent_Mobile::factory();
            $cap = new Net_UserAgent_Mobile_Capability($ua);

            foreach ($data['property'] as $name => $value) {
                $this->assertEquals($cap->get($name), $value);
            }
        }
    }
}
