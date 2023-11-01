<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\EntityInterface;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{
    /**
     * Initialize method.
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /**
     * Index method.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $articles = $this->Paginator->paginate($this->Articles->find());
        $this->set(compact('articles'));
    }

    /**
     * View method.
     *
     * @param string|null $slug Article slug
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function view($slug = null)
    {
        $article = $this->Articles->find()
            ->where(['slug' => $slug])
            ->firstOrFail();
        $this->set(compact('article'));
    }

    /**
     * Add method.
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add
     */
    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            // @TODO: Hardcoding the user_id is temporary and will be removed later
            if (property_exists($article, 'user_id')) {
                $article->user_id = 1;
            }

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);
    }

    /**
     * Edit method.
     *
     * @param string $slug Article slug
     * @return \Cake\Http\Response|null|void Redirects on successful edit
     */
    public function edit($slug)
    {
        $article = $this->Articles->find()
            ->where(['slug' => $slug])
            ->firstOrFail();

        if (!$article instanceof EntityInterface) {
            $this->Flash->error(__('Article not found.'));

            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $this->set('article', $article);
    }

    /**
     * Delete method.
     *
     * @param string $slug Article slug
     * @return \Cake\Http\Response|null|void Redirects to index
     */
    public function delete($slug)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->find()
            ->where(['slug' => $slug])
            ->firstOrFail();
        if ($article instanceof EntityInterface) {
            $articleTitle = $article->get('title');
            if ($this->Articles->delete($article)) {
                $this->Flash->success(__('The {0} article has been deleted.', $articleTitle));

                return $this->redirect(['action' => 'index']);
            }
        }
    }
}
