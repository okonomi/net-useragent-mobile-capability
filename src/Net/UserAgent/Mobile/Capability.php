<?php


class Net_UserAgent_Mobile_Capability
{
    private $_useragent;


    function __construct(Net_UserAgent_Mobile &$useragent)
    {
        $this->_useragent = & $useragent;
    }

    public function get($name)
    {
        switch ($name) {
        case 'browser.html.table':
            switch (true) {
            case $this->_useragent->isDoCoMo():
                return (float)$this->_useragent->getHTMLVersion() >= 6.0;

            case $this->_useragent->isSoftBank():
                return false;

            case $this->_useragent->isEZweb():
                return false;
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
