<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php if (isset($user->id)): ?>
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $user->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']
                ) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend>
                    <?php
                        if (isset($user->id)) {
                            echo __('Edit User');
                        } else {
                            echo __('Add User');
                        }
                    ?>
                </legend>
                <?php
                    echo $this->Form->control('email');
                    // Show the password field for 'add' action only
                    if (!isset($user->id)) {
                        echo $this->Form->control('password');
                    }
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
