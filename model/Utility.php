<?php
/**
 * Class Utility
 *
 * User: Renat Abaidulin
 * Date: 09.08.2019
 */

class Utility
{

    /**
     * Singleton: Create a Memcached instance
     * @return Memcached instance
     */
    private static function mc_cache_client()
    {
        static $mcCache = null;
        if(is_null($mcCache)) {
            $mcd = new Memcached;
            //memcache_connect('10.14.126.2', 11211);
            $mcd->addServer('127.0.0.1', 11121);
            $mcCache = $mcd;
        }

        return $mcCache;
    }

    /**
     * Get Data from cache by key
     * @param $id key
     * @return int|mixed
     */
    public static function getMCData($id)
    {
        $client = self::mc_cache_client();
        if($client)
            return $client->get($id);
        else return 0;
    }

    /**
     * Save data to cache by key
     * @param $id key
     * @param $data data to cache
     * @param int $ct expiration time
     */
    public static function setMCData($id,$data,$ct=3600)
    {
        $client = self::mc_cache_client();
        if($client)
            $client->set($id,$data,$ct);
    }

    /**
     * Convert HTTP QUERY string to array
     * @param string $_query
     * @return array
     */
    public static function query2Array($_query = "")
    {
        $query = explode("&", $_query);
        $aRetArray = array();
        foreach($query as $q){
            list($key, $value) = explode("=", $q);
            $aRetArray[$key] = $value;
        }
        return $aRetArray;
    }

    /**
     * Send email
     *
     * @param $to
     * @param $subject
     * @param $body
     * @param null $from
     * @param bool $html
     * @throws Exception
     */
    public static function sendEmail($to, $subject, $body, $from=null, $html=true)
    {

        $eol="\r\n";

        if (!$from) {
            $from = "renat@abaidulin.com";
        }

        $matches = null;
        if (preg_match('/(.*?)\s?<(.*?)>/', $from, $matches) > 0) {
            $from = '=?utf-8?B?' . base64_encode($matches[1]).'?=' . ' <' . $matches[2] . '>';
        }

        if (preg_match('/(.*?)\s?<(.*?)>/', $to, $matches)) {
            $to = '=?utf-8?B?' . base64_encode($matches[1]).'?=' . ' <' . $matches[2] . '>';
        }


        // заголовки
        $msg_id = Utility::microtimestr();

        $headers  = "From: $from" . $eol;
        $headers .= "Reply-To: $from" . $eol;
        $headers .= "Return-Path: $from" . $eol;
        $headers .= "Message-ID: <$msg_id@abaidulin.com>" . $eol;
        $headers .= "X-Mailer: PHP /" . phpversion() . $eol;
        $headers .= "MIME-Version: 1.0". $eol;

        if ($html)
            $headers .= "Content-Type: text/html; charset=UTF-8" . $eol;
        else
            $headers .= "Content-Type: text/plain; charset=UTF-8" . $eol;
        try{
            mail($to, $subject, $body, $headers);

        }
        catch(Exception $ex){
            throw new Exception($ex->getMessage());
        }

    }

    /**
     * Returns string with authTicket
     *
     * @return string
     */
    public static function generateTicket()
    {
        $acceptedChars = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789';
        $max = strlen($acceptedChars)-1;
        $code1 = null;
        for($i=0; $i < 32; $i++) {
            $code1 .= $acceptedChars{mt_rand(0, $max)};
        }
        $ttcode1 = $code1.microtime(true);
        $ttcode2 = md5($ttcode1);

        $ttcode = substr($ttcode2, 0, 32);
        return $ttcode;
    }

    /**
     * Validate email by regular expression
     *
     * @param $email
     * @return bool
     */
    public static function checkEmail($email)
    {
        $ch1 = '[a-zA-Z0-9\-_\.]';
        $ch2 = '[a-zA-Z0-9\-_]';
        if (preg_match("/^$ch1+@$ch2+(\.$ch2+)+$/", $email) == 0) {
            return false;
        }
        return true;
    }

    public static function microtimestr()
    {
        return preg_replace('/[^0-9]/', "", microtime(true));
    }
}