<?php //echo $json_return; ?>

<div class="box">
    <!-- Setting proxy-->
    <div class="box-header">
        <h2><?php echo __('Edit') ?></h2>
        <a href="<?php echo $this->Html->url(array('controller' => 'school', 'action' => 'index'), true); ?>"
           class="btn btn-primary" style="float: right;height: 40px; line-height: 28px"><?php echo __('List') ?></a>
    </div>
    <div class="box-content">
        <?php
        echo $this->Form->create('School', array('type' => 'file', 'class' => 'form-horizontal validation-required'));
        echo $this->Form->input('school_id',array("type"=>"hidden", 'class'=>'form-control','label'=>false)) ;
        ?>



            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('School name') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        echo $this->Form->input('school_name',array("type"=>"text", 'class'=>'form-control','label'=>false));
                        ?>
                    </div>
                </div>
            </div>






        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-9">
                <button type="submit" class="btn btn-info" id="edit"><?php echo __('Save')?></button>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>



						