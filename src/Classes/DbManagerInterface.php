<?php
/**
 * Created by William Armillei.
 * User: User
 * Date: 18/09/2018
 * Time: 16:38
 */

namespace App\Classes;

/**
 * @author William Armillei armilleiwilliam@gmail.com
 */
interface DbManagerInterface
{
    /**
     * Returns $success = true
     *
     * @param string $username, $password, $name, $lastName
     * @return boolean
     *
     */
    public function insert(String $userName, String $passWord, String $name, String $lastName);

    /**
     * Returns $success = true
     *
     * @param string $username
     * @return boolean
     *
     */
    public function delete(String $username);

    /**
     * Returns $success = true
     *
     * @param string $username, $password
     * @return boolean
     *
     */
    public function update(String $username, String $password);

    /**
     * Returns array with users parameters
     *
     * @param string $username
     * @return boolean
     *
     */
    public function getUser(String $username);

    /**
     * Returns boolean
     *
     * @param array $userParams
     * @return boolean
     *
     */
    public function checkNotEmptyValues(array $userParams);
}
