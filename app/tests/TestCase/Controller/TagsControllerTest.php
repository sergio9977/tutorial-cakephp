<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TagsController Test Case
 *
 * @uses \App\Controller\TagsController
 */
class TagsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Tags',
        'app.Articles',
        'app.ArticlesTags',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\TagsController::index()
     */
    public function testIndex(): void
    {
        $this->get('/tags');
        $this->assertResponseOk();
        $this->assertResponseContains('List of Tags');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\TagsController::view()
     */
    public function testView(): void
    {
        $this->get('/tags/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Tag Details');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\TagsController::add()
     */
    public function testAdd(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'title' => 'New Tag',
        ];

        $this->post('/tags/add', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains('The tag has been saved.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\TagsController::edit()
     */
    public function testEdit(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $data = [
            'title' => 'Updated Tag',
        ];

        $this->post('/tags/edit/1', $data);
        $this->assertResponseSuccess();
        $this->assertResponseContains('The tag has been updated.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\TagsController::delete()
     */
    public function testDelete(): void
    {
        $this->enableCsrfToken();
        $this->enableSecurityToken();

        $this->post('/tags/delete/1');
        $this->assertResponseSuccess();
        $this->assertResponseContains('The tag has been deleted.');
    }
}
