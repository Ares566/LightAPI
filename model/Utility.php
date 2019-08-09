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
}