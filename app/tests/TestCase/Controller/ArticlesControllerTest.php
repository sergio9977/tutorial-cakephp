<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

class ArticlesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    protected $fixtures = [
        'app.Articles',
    ];

    public function testIndex(): void
    {
        $this->get('/articles');
        $this->assertResponseOk();
        $this->assertResponseContains('List of Articles');
    }

    public function testView(): void
    {
        $this->get('/articles/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('View Article 1');
    }

    public function testAdd(): void
    {
        $data = [
            'title' => 'Test Article',
            'body' => 'This is a test article body.',
        ];

        $this->post('/articles/add', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Articles', 'action' => 'index']);
    }

    public function testEdit(): void
    {
        $data = [
            'title' => 'Updated Article',
            'body' => 'This is the updated article body.',
        ];

        $this->post('/articles/edit/1', $data);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Articles', 'action' => 'index']);
    }

    public function testDelete(): void
    {
        $this->post('/articles/delete/1');
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Articles', 'action' => 'index']);
    }
}
