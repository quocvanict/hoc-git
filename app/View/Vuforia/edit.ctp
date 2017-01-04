<?php //echo $json_return; ?>

<div class="box">
    <!-- Setting proxy-->
    <div class="box-header">

        <a href="/vuforia/upload" class="btn btn-primary"  style="float: right;height: 40px; line-height: 28px"><i class="glyphicon glyphicon-plus"></i> <?php echo __("Add") ?></a>
    </div>
    <div class="box-content">
        <?php
        echo $this->Form->create('VuforiaTarget', array('type' => 'file', 'class' => 'form-horizontal validation-required'));
        echo $this->Form->input('target_width',array("type"=>"hidden", 'class'=>'form-control','label'=>false, 'value'=> 320.0)) ;
        ?>


            <div class="form-group">
                <label class="col-lg-2 control-label"><?php echo __('Target ID') ?></label>
                <div class="col-lg-5">
                    <div class="form-row-input">
                        <?php
                        echo $this->Form->input('target_id',array("type"=>"text", 'class'=>'form-control','label'=>false,'disabled'=>true));
                        ?>
                    </div>
                </div>
            </div>
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
                            /*echo $this->Form->input('target_image', array(
                                'type' => 'file',
                                'label' => false
                            ));*/
                        ?>
                        <?php
                            $target_image = $this->data['VuforiaTarget']['target_image'];
                            if(!empty($target_image)) {
                                echo '<img style="width: 60px" class="avata" src="'.Router::url('/', true).'uploads/media/'.$target_image.'"/>' ;
                            }
                        ?>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <hr/>

            </div>

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
                        <?php

                        $media_output = $this->data['VuforiaTarget']['media_output'];


                        if($media_output !=''){

                            if($this->data['VuforiaTarget']['media_type'] =='video/mp4') {


                                if (file_exists(WWW_ROOT . 'uploads/media/' . $this->data['VuforiaTarget']['media_output'])) {
                                    echo '<a href="'.Router::url('/', true) . 'uploads/media/' . $this->data['VuforiaTarget']['media_output'].'"><img style="width: 60px" class="avata" src="'.Router::url('/', true).'img/format-video.png"/></a>';
                                }else{
                                    echo "-404-";
                                }


                            }else {
                                echo '<a href="'.Router::url('/', true) . 'uploads/media/' . $this->data['VuforiaTarget']['media_output'].'"><img style="width: 60px" class="avata" src="'.Router::url('/', true) . 'uploads/media/' . $this->data['VuforiaTarget']['media_output'] .'"/></a>';

                            }
                        }
                        ?>
                        <p>ext: jpg, mp4.</p>
                    </div>
                </div>

            </div>




        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-9">
                <button type="submit" class="btn btn-info" id="edit" title="Save"><?php echo __('Save') ?></button>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>



						