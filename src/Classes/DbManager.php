<?php
/**
 * Created by William Armillei.
 * DbManager
 * Date: 18/09/2018
 * Time: 15:02
 */

namespace App\Classes;
include __DIR__ . "/../configs/config.php";

class DbManager
{
    /*
     * @var $db;
     * db connection
     */
    private $db;

    /*
     * @var localhost, dbname, pass, username
     * database connection parameters
     */
    private $localhost;
    private $dbname;
    private $pass;
    private $username;

    /*
     * @var dbDataPassed
     * it contains global array with Db settings passed by config.php
     */
    private $dbDataPassed;

    /*
     * @array - array of parameters to be processed and verified not empty
     */
    private $usersParameters = array();

    /*
     * @const
     * list of error messages
     */
    const PLEASE_ALL_PARAMS_ARE_REQUIRED_USERNAME = 'Please, all params are required: username.';

    const PLEASE_ALL_PARAMS_ARE_REQUIRED_USERNAME_AND_PASSWORD = 'Please, all params are required: username and password.';

    const PLEASE_USERNAME_IS_REQUIRED = 'Please, username is required';

    const PLEASE_ALL_PARAMS_ARE_REQUIRED = 'Please, all params are required.';

    const ERROR = "Error!: ";

    function __construct (){
        global $dbData;
        $this->dbDataPassed = & $dbData;
        $this->localhost = $this->dbDataPassed['host'];
        $this->dbname = $this->dbDataPassed['db'];
        $this->username = $this->dbDataPassed['user'];
        $this->pass = $this->dbDataPassed['pass'];

        try {
            // db connection
            $this->db = new \PDO('mysql:host=' . $this->localhost . ';dbname='
                . $this->dbname, $this->username, $this->pass);

        } catch (PDOException $e) {
            print self::ERROR . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function insert(String $userName, String $passWord, String $name, String $lastName): ?bool
    {
        $this->usersParameters = array($userName, $passWord, $name, $lastName);
        if ($this->checkNotEmptyValues($this->usersParameters)) {
            try {
                $prep = $this->db->prepare('INSERT INTO Users VALUES(null, :username, :password, :name, :lastName)');
                $success = $prep->execute(array(':username' => $userName, ':password' => password_hash($passWord, PASSWORD_DEFAULT),
                    ':name' => $name, ':lastName' => $lastName));
                return $success;
            } catch (PDOException $e) {
                print self::ERROR . $e->getMessage() . "<br/>";
                die();
            }
        }
        throw new \Exception(self::PLEASE_ALL_PARAMS_ARE_REQUIRED);
    }

    public function delete(String $username): array
    {
        $this->usersParameters = array($username);
        if ($this->checkNotEmptyValues($this->usersParameters)) {
            try {
                if(!empty($this->getUser($username))) {
                    $prep = $this->db->prepare('DELETE FROM Users WHERE username = :username');
                    $success = $prep->execute(array(':username' => $username));
                    return array('result' => $success, 'message' => 'DeleteSucc');
                }
                return array('result' => false, 'message' => 'NoUser');
            } catch (PDOException $e) {
                print self::ERROR . $e->getMessage() . "<br/>";
                die();
            }
        }
        throw new \Exception(self::PLEASE_USERNAME_IS_REQUIRED);
    }

    public function update(String $username, String $password): ?bool
    {
        $this->usersParameters = array($username, $password);
        if ($this->checkNotEmptyValues($this->usersParameters)) {
            try {
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $prep = $this->db->prepare('UPDATE Users SET password = :password WHERE username = :username');
                $success = $prep->execute(array(':password' => $hashPassword, ':username' => $username));
                return $prep->rowCount() ? true : false;
            } catch (PDOException $e) {
                print self::ERROR . $e->getMessage() . "<br/>";
                die();
            }
        }
        throw new \Exception(self::PLEASE_ALL_PARAMS_ARE_REQUIRED_USERNAME_AND_PASSWORD);
    }

    public function getUser(String $username): array
    {
        $this->usersParameters = array($username);
        if ($this->checkNotEmptyValues($this->usersParameters)) {
            try {
                $prep = $this->db->prepare('SELECT id FROM Users WHERE username = :username');
                $prep->execute(array(':username' => $username));
                $userParams = $prep->fetchAll();
                return $userParams;
            } catch (PDOException $e) {
                print self::ERROR . $e->getMessage() . "<br/>";
                die();
            }
        }
        throw new \Exception(self::PLEASE_ALL_PARAMS_ARE_REQUIRED_USERNAME);
    }

    public function checkNotEmptyValues(array $userParams): bool
    {
        foreach ($userParams AS $sP) {
            if (trim($sP) == '' || $sP == NULL)
                return false;
        }
        return true;
    }
}