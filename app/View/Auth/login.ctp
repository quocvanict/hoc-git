<div class="row">
    <div class="login-box">
        <h2><b>ログイン</b></h2>
        <?php echo $this->Form->create('Admin', array('url' => array('controller' => 'auth', 'action' => 'login'))); ?>
        <fieldset>
            <div class="text-danger"><?php echo $this->Session->flash('auth'); ?></div>

            <?php echo $this->Form->input('email', array('type' => 'text', 'class' => 'input-large col-xs-12', 'placeholder' => 'Email', 'label' => false)); ?>
            <?php echo $this->Form->input('password', array('type' => 'password', 'class' => 'input-large col-xs-12', 'placeholder' => 'Password', 'label' => false)); ?>

            <div class="clearfix"></div>

            <?php echo $this->Form->button('ログイン', array('class' => 'btn btn-primary col-xs-12')); ?>
        </fieldset>

        <?php echo $this->Form->end() ?>
        <hr />

    </div>
</div><!--/row-->
