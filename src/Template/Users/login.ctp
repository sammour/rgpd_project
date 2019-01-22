
<div class="users form">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __("Merci de rentrer vos nom d'utilisateur et mot de passe") ?></legend>
        <?= $this->Form->control('username', ['label' => 'Email']) ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Se Connecter')); ?>
    <?= $this->Form->end() ?>
</div>

<?= $this->Html->link(
    'Je n\'ai pas de compte',
    'users/add'
);?></div>