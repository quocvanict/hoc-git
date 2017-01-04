<div id="bz" script="admin.edit()" data-id="<?php echo issetor($d['Admin']['id']); ?>"></div>
<div class="box">
    <div class="box-header">
        <h2><?php echo __('Edit') ?></h2>
        <a href="<?php echo $this->Html->url(array('controller' => 'admin', 'action' => 'index'), true); ?>"
           class="btn btn-primary" style="float: right;height: 40px; line-height: 28px"><?php echo __('List') ?></a>
    </div>
    <div class="box-content">

        <?php
        echo $this->Form->create('Admin', array('type' => 'file', 'class' => 'form-horizontal validation-required'));

        echo $this->Form->input('id',array("type"=>"hidden", 'class'=>'form-control','label'=>false)) ;
        ?>
            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Email') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php

                        echo $this->Form->input('email',array("type"=>"text", 'class'=>'form-control','label'=>false,'required' => true, 'disabled'=> (!empty($this->request->data['Admin']['id'] )) ? 'disabled' : '' ));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Fullname') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        echo $this->Form->input('name',array("type"=>"text", 'class'=>'form-control','label'=>false,'required' => true));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Password') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        echo $this->Form->input('password',array("type"=>"text", 'class'=>'form-control','label'=>false, 'value'=>''));
                        ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('School name') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php

                        echo $this->Form->input("school_id",array("type"=>"select",'class'=>'form-control','label'=>false,"options"=>$school_list));
                        ?>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Rule') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        $options = array(''=>"",'1'=>__('Admin'),'2'=>__('User'));
                        echo $this->Form->input("level",array("type"=>"select",'class'=>'form-control','label'=>false,"options"=>$options,'required' => true));
                        ?>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label"><?php  __('Status')?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">



                        <?php
                        $options = array("1"=>__("Active"),"2"=>__('Inactive'));
                        echo $this->Form->input("status",array("type"=>"select",'class'=>'form-control','label'=>false,"options"=>$options,'required' => true));
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