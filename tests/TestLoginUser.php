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



    // Try to reg
    public function testRegDbl()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/register/',array('email'=>'ares566@ya.ru'));
        $this->assertEquals($answer['result'], "ERR");
    }

    // Try to login default user
    public function testLogin()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/login/',array('email'=>''));
        $this->assertEquals($answer['result'], "ERR");
    }
    public function testLogin2()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/login/',array('email'=>'ares566@ya.ru'));
        $this->assertEquals($answer['result'], "ERR");
    }
    public function testLogin3()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/login/',array('email'=>'ares566@ya.ru','pass'=>'12345'));
        $this->assertEquals($answer['result'], "ERR");
    }

    public function testLogin4()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/login/',array('email'=>'ares566@ya.ru','pass'=>'66614'));
        $this->assertEquals($answer['result'], "OK");
    }

    // Try to upload image
    public function testUpload1()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/uploadimage/',array('token'=>'','image'=>''));
        $this->assertEquals($answer['result'], "ERR");
    }

    public function testUpload2()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/uploadimage/',array('token'=>'wewew','image'=>''));
        $this->assertEquals($answer['result'], "ERR");
    }

    public function testUpload3()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/uploadimage/',array('token'=>'','image'=>'wewwe'));
        $this->assertEquals($answer['result'], "ERR");
    }

    public function testUploadSuc()
    {
        $answer = $this->sendPost(JSON_API_SERVER_URL.'/user/uploadimage/',array('token'=>'er','image'=>'wewwe'));
        $this->assertEquals($answer['result'], "OK");
    }

    /**
     * Return JSON API server response
     *
     * @param String $url JSON API server URL
     * @param array $data array of post fields
     * @return array JSON decoded server response
     */
    private function sendPost(String $url, array $data): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        return json_decode($server_output, TRUE);
    }
}
