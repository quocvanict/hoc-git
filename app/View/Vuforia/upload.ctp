<?php //echo $json_return; ?>

<div class="box">
    <!-- Setting proxy-->
    <div class="box-header">

        <a href="<?php echo $this->Html->url(array('controller' => 'artist', 'action' => 'index'), true); ?>"
           class="btn btn-primary" style="float: right;height: 40px; line-height: 28px"><?php __('List') ?></a>
    </div>
    <div class="box-content">
        <?php
        echo $this->Form->create('VuforiaTarget', array('type' => 'file', 'class' => 'form-horizontal validation-required'));
        echo $this->Form->input('target_width',array("type"=>"hidden", 'class'=>'form-control','label'=>false, 'value'=> 320.0)) ;
        ?>



        <div class="form-group">
            <label class="col-lg-2 control-label"><?php echo __('Target name') ?></label>
            <div class="col-lg-5">
                <div class="form-row-input">
                    <?php
                    echo $this->Form->input('target_name',array("type"=>"text", 'class'=>'form-control','label'=>false));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label"><?php echo __('Target image') ?></label>
            <div class="col-lg-5">


                <div class="form-row-input">
                    <?php
                    echo $this->Form->input('target_image', array(
                        'type' => 'file',
                        'label' => false,
                        'required'=>true
                    ));
                    ?>
                </div>


            </div>
        </div>


        <div class="form-group">
            <hr/>

        </div>
        <?php /*
            <div class="form-group">
                <label class="col-lg-2 control-label">Meida type</label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        $options = array(""=>"","jpg"=>"jpg","mp4"=>"mp4");
                        echo $this->Form->input("media_type",array("type"=>"select","options"=>$options, 'label'=> false, 'class'=>'form-control'));
                        ?>
                    </div>
                </div>
            </div> */ ?>

        <div class="form-group">
            <label class="col-lg-2 control-label"><?php echo __('Media output') ?></label>
            <div class="col-lg-5">
                <div class="form-row-input">
                    <?php
                    echo $this->Form->input('media_output', array(
                        'type' => 'file',
                        'label' => false
                    ));
                    ?>
                    <p>ext: jpg, mp4.</p>
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



