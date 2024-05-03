<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 * @var string[]|\Cake\Collection\CollectionInterface $articles
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php if (isset($tag->id)): ?>
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $tag->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id), 'class' => 'side-nav-item']
                ) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tags form content">
            <?= $this->Form->create($tag) ?>
            <fieldset>
                <legend>
                    <?php
                        if (isset($tag->id)) {
                            echo __('Edit Tag');
                        } else {
                            echo __('Add Tag');
                        }
                    ?>
                </legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('articles._ids', ['options' => $articles]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
