<?php
/**
 * Created by William Armillei.
 * UserManager
 * Date: 18/09/2018
 * Time: 14:49
 */

namespace App\Classes;

use App\Classes\DbManager;

class UserManager
{
    const USER_ADDED_SUCCESSFULLY = 'User added successfully!';
    const USER_NOT_ADDED_FOR_UNKNOWN_REASONS_PLEASE_CONTACT_THE_ADMINISTRATOR = 'User not added for unknown reasons. 
            Please, contact the administrator.';
    const USER_DELETED = 'User deleted!';
    const USER_NOT_DELETED_FOR_UNKNOWN_REASONS = 'User not deleted for unknown reasons!';
    const PASSWORD_UPDATED = 'Password updated!';
    const USER_NOT_EXISTING_PLEASE_INSERT_A_REGISTERED_USERNAME = 'User not existing. Please, insert a registered username.';
    const WRONG_DB_MANAGER_INSTANCE = 'Wrong DbManager instance!';
    const NO_USER = 'NoUser';
    const USERNAME_NOT_FOUND = 'Username not found!';
    const PLEASE_CHOOSE_A_PASSWORD_LONGER_THAN_5_CHARS = 'Please, choose a password longer than 5 chars.';

    /**
     * @var DbManager
     */
    private $db;

    /**
     * @var array
     * messages to return to user confirming the operation success
     */
    private $response = array('result' => false, 'message' => '');

    public function __construct()
    {
        $this->db = new DbManager();
    }

    public function CreateUser(String $username, String $password, String $name, String $lastName): array
    {
        if (!$this->checkIfInstanceOfDbManager($this->db)) {
            return false;
        }

        // verify the password is at least 6 chars
        if (strlen(trim($password)) > 5) {
            $this->response['result'] = $this->db->insert($username, $password, $name, $lastName);
            if ($this->response['result']) {
                $this->response['message'] = self::USER_ADDED_SUCCESSFULLY;
            } else {
                $this->response['message'] = self::USER_NOT_ADDED_FOR_UNKNOWN_REASONS_PLEASE_CONTACT_THE_ADMINISTRATOR;
            }
            return $this->response;
        }
        $this->response['message'] = self::PLEASE_CHOOSE_A_PASSWORD_LONGER_THAN_5_CHARS;
        return $this->response;
    }

    public function DeleteUser(String $username): array
    {
        if (!$this->checkIfInstanceOfDbManager($this->db)) {
            return false;
        }
        $result = $this->db->delete($username);

        // check if user exists
        if ($result['message'] == self::NO_USER) {
            $this->response['message'] = self::USERNAME_NOT_FOUND;
            $this->response['result'] = $result['result'];
        } else {

            // check if deleted successfully
            if ($result['result']) {
                $this->response['message'] = self::USER_DELETED;
            } else {
                $this->response['message'] = self::USER_NOT_DELETED_FOR_UNKNOWN_REASONS;
            }
            $this->response['result'] = $result['result'];
        }
        return $this->response;
    }

    public function ChangePassword(String $username, String $password): array
    {
        if (!$this->checkIfInstanceOfDbManager($this->db)) {
            return false;
        }

        //check if password is at least 6 chars
        if (strlen(trim($password)) > 5) {
            $this->response['result'] = $this->db->update($username, $password);
            if ($this->response['result']) {
                $this->response['message'] = self::PASSWORD_UPDATED;
            } else {
                $this->response['message'] = self::USER_NOT_EXISTING_PLEASE_INSERT_A_REGISTERED_USERNAME;
            }
            return $this->response;
        }
        $this->response['message'] = self::PLEASE_CHOOSE_A_PASSWORD_LONGER_THAN_5_CHARS;
        return $this->response;
    }

    public function UserExists(String $username): bool
    {
        if ($this->checkIfInstanceOfDbManager($this->db)) {
            $user = $this->db->getUser($username);
            return !empty($user);
        }
    }

    public function checkIfInstanceOfDbManager($dbInstance): ?bool
    {
        if ($dbInstance instanceof DbManager) {
            return true;
        }
        throw new \Exception(self::WRONG_DB_MANAGER_INSTANCE);
    }
}
