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
        <li><?= $this->Html->link(__('Modifier mes informations'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Se désinscrire'), ['action' => 'delete', $user->id], ['confirm' => __('Voulez vous vraiment vous désinscrire ?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('Liste des utilisateurs'), ['action' => 'all']) ?> </li>

    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3>Mon compte</h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
    </table>
</div>
</div>