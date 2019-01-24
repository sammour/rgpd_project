<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$title = 'Connexion';
?>


<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>


    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('home.css') ?>
</head>
<body class="home">
<?php if (!isset($user)) :?>
<div class="users form">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create(new \App\Model\Entity\User(), ['url' => '/users/login']) ?>
    <fieldset>
        <legend><?= __("Merci de rentrer vos nom d'utilisateur et mot de passe") ?></legend>
        <?= $this->Form->control('username', ['label' => 'Email']) ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Se Connecter')); ?>
    <?= $this->Form->end(); ?>

</div>

<div class="connection-links">
<?= $this->Html->link(
    'Je n\'ai pas de compte',
    'users/add'
);?>
    <?= $this->Html->link(
        'Mot de passe oublié',
        'users/password'
    );?>
</div>

<?php else : ?>
    <?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\User $user
     */
    ?>
    <nav class="large-3 medium-4 columns" id="actions-sidebar">
        <ul class="side-nav">
            <li class="heading"><?= __('Actions') ?></li>
            <li><?= $this->Html->link(__('Modifier mes informations'), '/users/edit/'. $user->id) ?> </li>
            <li><?= $this->Form->postLink(__('Se désinscrire'), '/users/delete/'. $user->id, ['confirm' => __('Voulez vous vraiment vous désinscrire ?', $user->id)]) ?> </li>
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

<?php endif; ?>
</body>
