<?php $this->assign('title', 'Demande de réinitialisation de mot de passe'); ?><div class="users content">
    <h3><?php echo __('Mot de passe oublié'); ?></h3>
    <?php
    echo $this->Form->create();
    echo $this->Form->input('username', ['autofocus' => true, 'label' => 'Email', 'required' => true]);
    echo $this->Form->button('Request reset email / link');
    echo $this->Form->end();
    ?>
</div>