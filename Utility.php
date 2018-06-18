<?php
namespace WPAskAQuestion;

class Utility
{
    /**
     * @param $templateFile
     * @param array $args
     * @return string
     * @throws \Exception
     */
    public static function populateTemplateFile($templateFile, $args = [])
    {
        ob_start();
        $templateDirectory = dirname(__FILE__) . '/Templates';
        $templateFile = $templateFile . '.template.php';
        if(file_exists($templateDirectory . '/' . $templateFile)){
            extract($args);
            include $templateDirectory . '/' . $templateFile;
        } else {
            error_log('Template file does not exist');
            throw new \Exception('Template file does not exist');
        }
        return ob_get_clean();
    }

    /**
     * @param $imageURL
     * @param bool $alt
     * @param bool $class
     * @return string
     */
    public static function generalImageCreator($imageURL,$alt = false,$class = false)
    {
        return '<img src='.$imageURL.' alt='.$alt.' class='.$class.' />';
    }

    /**
     * @return bool
     */
    public static function getUserIp()
    {
        $ip = false;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip != false) {
                array_unshift($ips, $ip);
                $ip = false;
            }
            $count = count($ips);
            // Exclude IP addresses that are reserved for LANs
            for ($i = 0; $i < $count; $i++) {
                if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        //use the standard variable is others don't pan out
        if (false == $ip && isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * @return false|string
     */
    public static function getCurrentTime()
    {
        return date('Y-m-d H:i:s');
    }

    public static function return_calendar_date($date)
    {
        return date('n-d-Y', strtotime($date));
    }
}