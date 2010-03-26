<?php

require_once 'Net/UserAgent/Mobile/Capability/Exception.php';


class Net_UserAgent_Mobile_Capability
{
    private $_useragent;


    function __construct(Net_UserAgent_Mobile_Common $useragent)
    {
        $this->_useragent = $useragent;
    }

    /**
     * @throws Net_UserAgent_Mobile_Capability_Exception
     */
    public function get($name)
    {
        $ua = $this->_useragent;
        $carrier = $ua->getCarrierShortName();

        switch ($name) {
        case 'browser.html.table':
            switch ($carrier) {
            case 'I':
                return (float)$ua->getHTMLVersion() >= 6.0 || (float)$ua->getBrowserVersion() >= 2.0;

            case 'S':
                return true;

            case 'E':
                return $ua->isWAP2() === true;
            }
            return null;

        case 'browser.css':
            switch ($carrier) {
            case 'I':
                return ((float)$ua->getHTMLVersion() >= 4.0 || (float)$ua->getBrowserVersion() >= 2.0)
                        && $ua->isFOMA();

            case 'S':
                return $ua->isType3GC();

            case 'E':
                return $ua->isWAP2() === true;
            }
            return null;

        case 'browser.css.external':
            switch ($carrier) {
            case 'I':
                return (float)$ua->getBrowserVersion() >= 2.0;

            case 'S':
                return $ua->isType3GC();

            case 'E':
                return $ua->isWAP2() === true;
            }
            return null;

        case 'browser.vga':
            switch ($carrier) {
            case 'I':
                // iモードブラウザ2.0のVGAモードは無視
                return false;

            case 'S':
                return $ua->getDisplay()->getWidth() >= 480;

            case 'E':
                return false;
            }
            return null;

        case 'device.flash':
            // @see http://ke-tai.org/blog/2008/03/18/flashfunc/
            switch ($carrier) {
            case 'I':
                if ($ua->isFOMA()) {
                    if ($ua->getSeries() === 'FOMA') {
                        return false;
                    }
                    if (in_array($ua->getModel(), array('NM850iG', 'F880iES', 'N600i', 'L600i', 'L601i', 'L602i'))) {
                        return false;
                    }
                    return true;
                } else {
                    return in_array($ua->getSeries(), array('505i', '506i'));
                }

            case 'S':
                if ($ua->isType3GC()) {
                    if ($ua->getName() === 'Vodafone') {
                        return in_array($ua->getVendor(), array('SH', 'SE'));
                    }
                    if ($ua->getName() === 'SoftBank') {
                       return $ua->getVendor() !== 'SC';
                    }
                }
                return false;

            case 'E':
                return (int)substr($ua->getHeader('X-UP-DEVCAP-MULTIMEDIA'), 12, 1) >= 1;
            }
            return null;

        default:
            throw new Net_UserAgent_Mobile_Capability_Exception("no property: $name");
        }

        return null;
    }
}


/**

   $ua = & Net_UserAgent_Mobile::factory();
   $cap = new Net_UserAgent_Mobile_Capability($ua);

   $cap->get('browser.html.table');     // tableタグ対応(true/false)
   $cap->get('browser.css');            // CSS対応(true/false)
   $cap->get('browser.css.external');   // 外部CSS対応(true/false)
   $cap->get('device.flash');           // Flash対応(true/false)
   $cap->get('device.gps);              // GPS対応(true/false)
 */
