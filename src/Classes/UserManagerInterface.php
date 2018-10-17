<?php
/**
 * Created by William Armillei.
 * User: User
 * Date: 18/09/2018
 * Time: 17:08
 */

namespace App\Classes;

interface UserManagerInterface
{
    /**
     * Returns $success = true
     *
     * @param string $username, $password
     * @return array
     *
     */
    public function CreateUser(String $username, String $password);

    /**
     * Returns $success = true
     *
     * @param string $username
     * @return array
     *
     */
    public function DeleteUser(String $username);

    /**
     * Returns $success = true
     *
     * @param string $username, $password
     * @return array
     *
     */
    public function ChangePassword(String $username, String $password);

    /**
     *
     * @param string $username, $password
     * @return boolean
     *
     */
    public function UserExists(String $username);

    /**
     *
     * @param object $dbInstance
     * @return boolean
     *
     */
    public function checkIfInstanceOfDbManager($dbInstance);
}