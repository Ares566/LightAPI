<?php
/**
 * Created by PhpStorm.
 * User: ares
 * Date: 11.08.2019
 * Time: 16:45
 */

use PHPUnit\Framework\TestCase;

// Test server URL
define('JSON_API_SERVER_URL','http://df.abaidulin.com');

class TestLoginUser extends TestCase
{
    public function testLogin()
    {

        echo $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/login/?w',array('pass'=>''));

        $this->assertEquals($answer['result'], "OK");
    }

    /**
     * Return JSON API server response
     *
     * @param String $url JSON API server URL
     * @param array $data array of post fields
     * @return array JSON decoded server response
     */
    private function sendPost(String $url, array $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        return $server_output;
    }
}
