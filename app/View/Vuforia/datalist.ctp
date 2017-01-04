
<div class="clearfix" style="margin-bottom: 7px"></div>
<div class="box">

    <div class="box-header">
        <h2><?php echo __('List'); ?></h2>

        <a href="/vuforia/upload" class="btn btn-primary"  style="float: right;height: 40px; line-height: 28px"><i class="glyphicon glyphicon-plus"></i> <?php echo __("Add") ?></a>
    </div>

        <div class="box-content" id="table-container">
            <?php if(!empty($data)){ ?>

            <table class="table table-striped"  id="maintable">
                <thead >
					<tr>
						<th>
							ID
						</th>
						<th>
							<?php echo __('Target ID') ?>
						</th>
                        <th>
                            <?php echo __('Target image') ?>
						</th>
                        <th>
                            <?php echo __('Target name') ?>
						</th>
						<th>
                            <?php echo __('Media output') ?>
						</th>
						<th>
							<?php echo __('Type') ?>
						</th>
                        <th>
							<?php echo __('School') ?>
						</th>

						<th>

						</th>
						
						
					</tr>
                </thead>
                <tbody>
                    <?php foreach($data as $_item){
					?>
                        <tr>

							<td><?php echo $_item['VuforiaTarget']['id']  ?></td>
							<td><?php echo '<a href="'.$this->webroot.'api/get_by_target_id/'.$_item['VuforiaTarget']['target_id'].'">'.$_item['VuforiaTarget']['target_id'].'</a>'; ?></td>

                            <td>
                                <?php
                                     if($_item['VuforiaTarget']['target_image'] !=''){
                                         echo '<a href="'.Router::url('/', true).'uploads/media/'. $_item['VuforiaTarget']['target_image'].'"><img style="width: 60px" class="avata" src="'.Router::url('/', true).'uploads/media/'. $_item['VuforiaTarget']['target_image'] .'"/></a>';

                                     }



                                ?>
                            </td>
                            <td><?php echo $_item['VuforiaTarget']['target_name']; ?></td>
                            <td>
                                <?php
                                if($_item['VuforiaTarget']['media_output'] !=''){

                                    if($_item['VuforiaTarget']['media_type'] =='video/mp4') {


                                        if (file_exists(WWW_ROOT . 'uploads/media/' . $_item['VuforiaTarget']['media_output'])) {
                                            echo '<a href="'.Router::url('/', true) . 'uploads/media/' . $_item['VuforiaTarget']['media_output'].'"><img style="width: 60px" class="avata" src="'.Router::url('/', true).'img/format-video.png"/></a>';
                                        }else{
                                            echo "-404-";
                                        }


                                    }else {
                                        echo '<a href="'.Router::url('/', true) . 'uploads/media/' . $_item['VuforiaTarget']['media_output'].'"><img style="width: 60px" class="avata" src="'.Router::url('/', true) . 'uploads/media/' . $_item['VuforiaTarget']['media_output'] .'"/></a>';

                                    }
                                }
                                ?>

                            </td>


                            <td><?php echo $_item['VuforiaTarget']['media_type']; ?></td>
                            <td><?php echo (!empty($_item['Admin']['School'])) ? $_item['Admin']['School']['school_name'] : ''; ?></td>

                            <td>
                                <a title="Edit this user" href="/vuforia/edit/<?php echo $_item['VuforiaTarget']['id']; ?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-edit icon-white" title="Edit this user"></i></a>

                                <a onclick="return confirm('<?php __('Are you sure you want to delete this item?') ?>');" href="/vuforia/delete/<?php echo $_item['VuforiaTarget']['id']; ?>" data-toggle="modal" class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-ban-circle icon-white" title="<?php echo __('Delete this user') ?>"></i></a>
                            </td>
                        </tr>
					<?php } ?>
                </tbody>
            </table>
            <?php echo $this->element('pagination'); ?>

            <?php }else{ ?>
                <h2><?php echo __('Empty data'); ?></h2>

            <?php } ?>
        </div>


</div>
