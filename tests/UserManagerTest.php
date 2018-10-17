<?php

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '../../src/Classes/UserManager.php';
require __DIR__ . '../../src/Classes/DbManager.php';

use App\Classes\UserManager;
use App\Classes\DbManager;

class UserManagerTest extends TestCase
{
    /**
     * @var db
     * db connection mocked
     */
    protected $db;

    protected $userManager;

    /**
     * @var const
     * list of testing messages to match with the ones returned by UserManager
     */
    const PLEASE_CHOOSE_A_PASSWORD_LONGER_THAN_5_CHARS = 'Please, choose a password longer than 5 chars.';

    const PASSWORD_UPDATED = 'Password updated!';

    const USER_NOT_EXISTING_PLEASE_INSERT_A_REGISTERED_USERNAME = 'User not existing. Please, insert a registered username.';

    const USER_DELETED = 'User deleted!';

    const USERNAME_NOT_FOUND = 'Username not found!';

    public function setUp()
    {
        $this->userManager = new UserManager();
        $this->dbManager = new DbManager();

        $this->db = $this->getMockBuilder('DbManager')
            ->setMethods(['insert', 'delete', 'update', 'get'])
            ->getMock();
    }

    public function testCreateUser()
    {
        $username = 'johnTen';
        $password = 'pass1234';
        $name = 'JoeTwo';
        $lastName = 'RossTwo';

        $response = $this->userManager->CreateUser($username, $password, $name, $lastName);

        $this->db->expects($this->once())->method('insert')->with($username, $password, $name, $lastName)->willReturn(true);

        $this->assertSame(true, $this->db->insert($username, $password, $name, $lastName));
        $this->assertSame(true, $response['result']);
        $this->assertSame('User added successfully!', $response['message']);
    }


    public function testCreateUserWithShortPassword()
    {
        // If password is shorter than 6 chars, the user should not be created
        $username = 'john';
        $password = 'p123';
        $name = 'Joe';
        $lastName = 'Ross';

        $response = $this->userManager->CreateUser($username, $password, $name, $lastName);

        $this->assertSame(false, $response['result']);
        $this->assertSame(self::PLEASE_CHOOSE_A_PASSWORD_LONGER_THAN_5_CHARS, $response['message']);
    }

    public function testChangePassword()
    {
        $username = 'johnTen1';
        $password = 'N3wpass!9';

        $response = $this->userManager->ChangePassword($username, $password);
        $this->db->expects($this->once())->method('update')->with($username, $password)->willReturn(true);

        $this->assertSame(true, $this->db->update($username, $password));
        $this->assertSame(true, $response['result']);
        $this->assertSame(self::PASSWORD_UPDATED, $response['message']);

    }

    public function testChangePasswordWithShortPassword()
    {
        // If the new password is shorter than 6 chars, it shouldn't be updated
        $username = 'john';
        $password = 'N3w';

        $response = $this->userManager->ChangePassword($username, $password);

        $this->assertSame(false, $response['result']);
        $this->assertSame(self::PLEASE_CHOOSE_A_PASSWORD_LONGER_THAN_5_CHARS, $response['message']);
    }


    public function testChangePasswordOfNonExistingUser()
    {
        // If user doesn't exist, the password should not be changed
        $username = 'FFFF';
        $password = 'N3wsdfwe';

        $response = $this->userManager->ChangePassword($username, $password);
        $this->db->expects($this->once())->method('update')->with($username, $password)->willReturn(false);

        $this->assertSame(false, $this->db->update($username, $password));
        $this->assertSame(false, $response['result']);
        $this->assertSame(self::USER_NOT_EXISTING_PLEASE_INSERT_A_REGISTERED_USERNAME, $response['message']);
    }

    public function testDeleteUser()
    {
        $username = 'johnTen';

        $response = $this->userManager->DeleteUser($username);
        $this->db->expects($this->once())->method('delete')->with($username)->willReturn(true);

        $this->assertSame(true, $this->db->delete($username));
        $this->assertSame(true, $response['result']);
        $this->assertSame(self::USER_DELETED, $response['message']);
    }

    public function testDeleteNonExistingUser()
    {
        // If user doesn't exist, we shouldn't try to delete it
        $username = 'johnTwelve';

        $response = $this->userManager->DeleteUser($username);
        $this->db->expects($this->once())->method('delete')->with($username)->willReturn(false);

        $this->assertSame(false, $this->db->delete($username));
        $this->assertSame(false, $response['result']);
        $this->assertSame(self::USERNAME_NOT_FOUND, $response['message']);
    }

    public function testUserDoesntExists()
    {
        // If we get no data about the user, assume it doesn't exist
        $username = 'johnny';

        $response = $this->dbManager->getUser($username);

        $this->assertSame(true, empty($response));
    }
}

