<?php


class Net_UserAgent_Mobile_Capability
{
    private $_useragent;


    function __construct(Net_UserAgent_Mobile_Common $useragent)
    {
        $this->_useragent = $useragent;
    }

    public function get($name)
    {
        switch ($name) {
        case 'browser.html.table':
            switch (true) {
            case $this->_useragent->isDoCoMo():
                return (float)$this->_useragent->getHTMLVersion() >= 6.0;

            case $this->_useragent->isSoftBank():
                return true;

            case $this->_useragent->isEZweb():
                return $this->_useragent->isWAP2() === true;
            }
            return null;

        case 'browser.css':
            switch (true) {
            case $this->_useragent->isDoCoMo():
                return (float)$this->_useragent->getHTMLVersion() >= 4.0 && $this->_useragent->isFOMA();

            case $this->_useragent->isSoftBank():
                return $this->_useragent->isType3GC();

            case $this->_useragent->isEZweb():
                return $this->_useragent->isWAP2() === true;
            }
            return null;

        case 'browser.css.external':
            switch (true) {
            case $this->_useragent->isDoCoMo():
                return (float)$this->_useragent->getBrowserVersion() >= 2.0;

            case $this->_useragent->isSoftBank():
                return $this->_useragent->isType3GC();

            case $this->_useragent->isEZweb():
                return $this->_useragent->isWAP2() === true;
            }
            return null;

        case 'device.flash':
            // @see http://ke-tai.org/blog/2008/03/18/flashfunc/
            switch (true) {
            case $this->_useragent->isDoCoMo():
                if ($this->_useragent->isFOMA()) {
                    if ($this->_useragent->getSeries() === 'FOMA') {
                        return false;
                    }
                    if (in_array($this->_useragent->getModel(), array('NM850iG', 'F880iES', 'N600i', 'L600i', 'L601i', 'L602i'))) {
                        return false;
                    }
                    return true;
                } else {
                    return in_array($this->_useragent->getSeries(), array('505i', '506i'));
                }

            case $this->_useragent->isSoftBank():
                if ($this->_useragent->isType3GC()) {
                    if ($this->_useragent->getName() === 'Vodafone') {
                        return in_array($this->_useragent->getVendor(), array('SH', 'SE'));
                    }
                    if ($this->_useragent->getName() === 'SoftBank') {
                       return $this->_useragent->getVendor() !== 'SC';
                    }
                }
                return false;

            case $this->_useragent->isEZweb():
                return substr($this->_useragent->getHeader('X-UP-DEVCAP-MULTIMEDIA'), 12, 1) === '1';
            }
            return null;
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
