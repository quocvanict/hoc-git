<div class="box">
    <div class="box-header">
        <h2><?php echo __('Edit') ?></h2>
        <a href="<?php echo $this->Html->url(array('controller' => 'configuration', 'action' => 'index'), true); ?>"
           class="btn btn-primary" style="float: right;height: 40px; line-height: 28px"><?php echo __('List') ?></a>
    </div>
    <div class="box-content">

        <?php
        echo $this->Form->create('Configuration', array('type' => 'file', 'class' => 'form-horizontal validation-required'));

        echo $this->Form->input('id',array("type"=>"hidden", 'class'=>'form-control','label'=>false)) ;
        ?>
            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('License Key') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php

                        echo $this->Form->input('license_key',array("type"=>"textarea", 'class'=>'form-control','label'=>false,'required' => true, 'disabled'=> (!empty($this->request->data['Admin']['id'] )) ? 'disabled' : '' ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Client - Access Key') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        echo $this->Form->input('client_access_key',array("type"=>"text", 'class'=>'form-control','label'=>false,'required' => true));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Client - Secret Key') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        echo $this->Form->input('client_secret_key',array("type"=>"text", 'class'=>'form-control','label'=>false,'required' => true));
                        ?>
                    </div>
                </div>
            </div>
			
			<div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Server - Access Key') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        echo $this->Form->input('server_access_key',array("type"=>"text", 'class'=>'form-control','label'=>false,'required' => true));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Server - Secret Key') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        echo $this->Form->input('server_secret_key',array("type"=>"text", 'class'=>'form-control','label'=>false,'required' => true));
                        ?>
                    </div>
                </div>
            </div>
			
				
 
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-9">
                    <button type="submit" class="btn btn-info" id="edit"><?php echo __('Save') ?></button>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>