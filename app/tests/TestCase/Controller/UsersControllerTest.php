<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Users',
        'app.Articles',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\UsersController::index()
     */
    public function testIndex(): void
    {
        $this->get('/users');
        $this->assertResponseOk();
        $this->assertResponseContains('List of Users');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\UsersController::view()
     */
    public function testView(): void
    {
        $this->get('/users/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('User Details');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\UsersController::add()
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'username' => 'newuser',
            'password' => 'password123',
        ];

        $this->post('/users/add', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains('The user has been saved.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\UsersController::edit()
     */
    public function testEdit(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'username' => 'updateduser',
        ];

        $this->post('/users/edit/1', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains('The user has been updated.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\UsersController::delete()
     */
    public function testDelete(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/users/delete/1');
        $this->assertResponseSuccess();
        $this->assertResponseContains('The user has been deleted.');
    }
}
