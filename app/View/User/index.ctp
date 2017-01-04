<div class="clearfix" style="margin-bottom: 7px"></div>
<div class="box">
        <!-- Setting point-->
        <!--<div id="top_anchor"></div>-->
        <div class="box-content" id="table-container">

            <?php
            if(!empty($data)){

            ?>
            <table class="table table-striped" id="maintable">
                <thead>
                <tr>
                    <th>
                        <?php echo __('ID'); ?>
                    </th>
                    <th>
                        <?php echo __('Fullname'); ?>
                    </th>
                    <th>
                        <?php echo __('Email'); ?>
                    </th>
                    <th>
                        <?php echo __('Date of birdth'); ?>
                    </th>

                    <th>
                        <?php echo __('School name'); ?>
                    </th>
                    <th>
                        <?php echo __('Status'); ?>
                    </th>

                    <th>

                    </th>


                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $_item) {  ?>
                    <tr>

                        <td><?php echo $_item['User']['user_id'] ?></td>
                        <td><?php echo $_item['User']['name']; ?></td>
                        <td><?php echo $_item['User']['email']; ?></td>
                        <td><?php echo $_item['User']['dob']; ?></td>
                        <td><?php echo $_item['School']['school_name']; ?></td>
                        <td style="width:100px;"><?php echo ($_item['User']['status'] == 1) ? '<a href="/user/approve/'.$_item['User']['user_id'].'" type="button" class="btn btn-block btn-success btn-default">'.__('Approve').'</button>' : '<a href="/user/approve/'.$_item["User"]["user_id"].'" type="button" class="btn btn-block btn-warning btn-default">'.__('Not approve').'</a>'; ?></td>


                        <td style="width: 200px">

                            <a onclick="return confirm('<?php echo __("Are you sure you want to delete this item?") ?>');"
                               title="Delete" href="/user/delete/<?php echo $_item['User']['user_id']; ?>"
                               data-toggle="modal" class="btn btn-sm btn-danger delete"><i
                                        class="glyphicon glyphicon-ban-circle icon-white"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php echo $this->element('pagination'); ?>
            <?php }else{ ?>
                <h2><?php echo __('Not found item'); ?></h2>

            <?php } ?>
        </div>
</div>
 