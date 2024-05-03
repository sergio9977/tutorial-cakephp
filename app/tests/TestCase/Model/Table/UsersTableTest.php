<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * @var UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.Articles',
    ];

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::getTableLocator()->get('Users', $config);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        // Test a valid user
        $data = [
            'username' => 'new_user',
            'email' => 'new_user@example.com',
            'password' => 'new_password',
        ];
        $user = $this->Users->newEntity($data);
        $this->assertEmpty($user->getErrors());

        // Test an invalid user with a duplicate username
        $data = [
            'username' => 'user1', // Assumes 'user1' already exists in fixtures
            'email' => 'new_user@example.com',
            'password' => 'new_password',
        ];
        $user = $this->Users->newEntity($data);
        $this->assertNotEmpty($user->getErrors());

        // Test an invalid user with an invalid email
        $data = [
            'username' => 'new_user',
            'email' => 'invalid_email',
            'password' => 'new_password',
        ];
        $user = $this->Users->newEntity($data);
        $this->assertNotEmpty($user->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        // Test a valid rule
        $data = [
            'username' => 'new_user',
            'email' => 'new_user@example.com',
            'password' => 'new_password',
        ];
        $user = $this->Users->newEntity($data);
        $this->assertTrue($this->Users->checkRules($user));

        // Test a rule with a duplicate username
        $data = [
            'username' => 'user1', // Assumes 'user1' already exists in fixtures
            'email' => 'new_user@example.com',
            'password' => 'new_password',
        ];
        $user = $this->Users->newEntity($data);
        $this->assertFalse($this->Users->checkRules($user));

        // Test a rule with an invalid email
        $data = [
            'username' => 'new_user',
            'email' => 'invalid_email',
            'password' => 'new_password',
        ];
        $user = $this->Users->newEntity($data);
        $this->assertFalse($this->Users->checkRules($user));
    }
}
