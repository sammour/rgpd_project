<div class="home">
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
</div>