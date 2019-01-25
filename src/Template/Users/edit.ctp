<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="home">
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Mon compte'), ['action' => 'index', '?' => ['token' => $token]]) ?></li>
        <li><?= $this->Form->postLink(
                __('Se désinscrire'),
                ['action' => 'delete', $user->id, '?' => ['token' => $token]],
                ['confirm' => __('Voulez vous vraiment vous désinscrire ?', $user->id)]
            )
        ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->control('username', ['label' => 'Email']);
            echo $this->Form->control('password');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
</div>