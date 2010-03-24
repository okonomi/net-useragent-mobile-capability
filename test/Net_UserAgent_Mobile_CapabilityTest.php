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
