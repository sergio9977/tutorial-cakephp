<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ArticlesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ArticlesTable Test Case
 */
class ArticlesTableTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Articles',
        'app.Tags',
        'app.ArticlesTags',
    ];

    /**
     * @var ArticlesTable
     */
    public $Articles;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Articles') ? [] : ['className' => ArticlesTable::class];
        $this->Articles = TableRegistry::getTableLocator()->get('Articles', $config);
    }

    /**
     * Test beforeSave method
     *
     * @return void
     */
    public function testBeforeSave(): void
    {
        // Create a new article entity
        $data = [
            'title' => 'Test Article',
            'body' => 'This is a test article body.',
            'tag_string' => 'cakephp, testing',
        ];
        $article = $this->Articles->newEntity($data);

        // Save the article
        $result = $this->Articles->save($article);

        // Check if the slug was generated
        $this->assertNotNull($result->slug);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        // Test an article with a title shorter than 10 characters
        $data = [
            'title' => 'Short',
            'body' => 'This is a test article body.',
        ];
        $article = $this->Articles->newEntity($data);
        $this->assertNotEmpty($article->getErrors());

        // Test an article with a title longer than 255 characters
        $data = [
            'title' => str_repeat('A', 256),
            'body' => 'This is a test article body.',
        ];
        $article = $this->Articles->newEntity($data);
        $this->assertNotEmpty($article->getErrors());

        // Test a valid article
        $data = [
            'title' => 'Valid Title',
            'body' => 'This is a test article body.',
        ];
        $article = $this->Articles->newEntity($data);
        $this->assertEmpty($article->getErrors());
    }

    /**
     * Test findTagged method
     *
     * @return void
     */
    public function testFindTagged(): void
    {
        // Test finding articles with a specific tag
        $query = $this->Articles->find('tagged', ['tags' => ['cakephp']]);
        $this->assertNotEmpty($query->toArray());

        // Test finding articles with multiple tags
        $query = $this->Articles->find('tagged', ['tags' => ['cakephp', 'testing']]);
        $this->assertNotEmpty($query->toArray());

        // Test finding articles with no tags
        $query = $this->Articles->find('tagged', ['tags' => []]);
        $this->assertNotEmpty($query->toArray());
    }
}
