<?php
namespace Page;

class ApiContent extends ApiBase
{
    // include url of current page
    public static $URL = '/api/contents';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     *
     * @param $param
     * @param bool|false $withEnvironment
     * @param bool|false $withDomain
     * @return string
     */
    public static function route($param = '', $withEnvironment = true, $withDomain = false)
    {
        $route = static::$URL.$param;

        if ($withEnvironment) {
            $route = self::$ENVIRONMENT . $route;
        }

        if ($withDomain) {
            $route = self::$DOMAIN . $route;
        }

        return $route;
    }

    /**
     * Full route is required when the location returns the full url
     * For example, // full route is required when the location returns the full url
     *
     * @param string $param
     * @return string
     */
    public static function fullRoute($param = '')
    {
        return self::route($param, true, true);
    }
}
