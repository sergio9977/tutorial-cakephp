<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'email' => 'cakephp@example.com',
                'password' => 'secret',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('users');

        foreach ($data as $userData) {
            $existingUser = $this->fetchRow("SELECT * FROM users WHERE email = '" . $userData['email'] . "'");
    
            if (!$existingUser) {
                $table->insert($userData);
            }
        }
    
        $table->saveData();
    }
}
