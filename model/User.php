<?php

/**
 * Class User
 *
 * Working with DB Table users
 */


class User extends CoreData
{
    public $id;
    public $token;
    public $email;
    public $password;
    public $registered;
    public $lastlogin;

    protected $db_table = 'users';


    function __construct($id, $caching = false)
    {
        parent::__construct($id, $caching);
    }

    /**
     * Update last login date
     */
    public function setLastLogin()
    {
        $dba = DB::getAdaptor();
        $this->lastlogin = date('Y-m-d H:i:s');
        $dba->update('users',array('lastlogin'=>$this->lastlogin),array('id'=>$this->id));
    }
    // STATIC FUNCTIONS

    /**
     * Get registered User by given email
     *
     * @param string $email user email
     * @return bool|User
     */
    public static function getUserByEmail($email)
    {
        $dba = DB::getAdaptor();
        $iUID = $dba->getOneValue('SELECT id FROM users WHERE email='.$dba->quote($email));
        if(!intval($iUID))
            return FALSE;
        return new User($iUID);
    }


    /**
     * Register new User
     *
     * @param string $email
     * @param string $password
     * @return bool|User
     * @throws Exception
     */
    public static function addUser($email, $password)
    {
        $oCUser = User::getUserByEmail($email);
        if($oCUser)
            throw new Exception('Email is already have registered');
        $aUser = array(

            'email' => $email,
            'password' => md5($password),
            'token'=>Utility::generateTicket()
        );

        $oUser = self::newItem('users',$aUser);
        if($oUser && $oUser->id)
            return $oUser;
        else
            throw new Exception('Something went wrong during registration');
        return FALSE;
    }
}