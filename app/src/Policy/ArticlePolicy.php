<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Article;
use Authorization\IdentityInterface;

/**
 * Article policy
 *
 * @method bool isAuthor(\Authorization\IdentityInterface $user, \App\Model\Entity\Article $article)
 */
class ArticlePolicy
{
    /**
     * Check if $user can add Article
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Article $article current article.
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Article $article)
    {
        // All logged in users can create articles.
        return true;
    }

    /**
     * Check if $user can edit Article
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Article $article current article.
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Article $article)
    {
        // logged in users can edit their own articles.
        return $this->isAuthor($user, $article);
    }

    /**
     * Check if $user can delete Article
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Article $article current article.
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Article $article)
    {
        // logged in users can delete their own articles.
        return $this->isAuthor($user, $article);
    }

    /**
     * Check if $user is article's author
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Article $article current article.
     * @return bool
     */
    protected function isAuthor(IdentityInterface $user, Article $article): bool
    {
        /** @var \App\Model\Entity\User $userEntity */
        $userEntity = $user->getOriginalData();

        return $article->user_id === $userEntity->id;
    }
}
