<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="home">
<div class="users form ">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Ajouter un utilisateur') ?></legend>
        <?= $this->Form->control('username', ['label' => 'Email']) ?>
        <?= $this->Form->control('password') ?>
        <?= $this->Form->control('role', [
            'options' => ['admin' => 'Employeur', 'author' => 'Employé']
        ]) ?>
    </fieldset>
    <?= $this->Form->button(__('Ajouter')); ?>
    <?= $this->Form->end() ?>
</div>
</div>