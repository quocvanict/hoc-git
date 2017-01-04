<div class="clearfix" style="margin-bottom: 7px"></div>
<div class="box">
    <form method="POST" class="form-list" id="myForm">
        <div class="box-header">
            <h2><?php echo __('List') ?></h2>

            <a href="/school/edit" class="btn btn-primary"  style="float: right;height: 40px; line-height: 28px"><i class="glyphicon glyphicon-plus"></i> <?php echo __("Add") ?></a>
        </div>


        <div class="box-content" id="table-container">
            <table class="table table-striped" id="maintable">
                <thead>
                    <tr>
                        <th style="width: 100px; ">
                            ID
                        </th>
                        <th>
                            <?php echo __('School name'); ?>
                        </th>

                        <th>

                        </th>
                          
                    </tr
                </thead>
                <tbody>
                <?php foreach ($data as $_item) {  ?>
                    <tr>


                        <td><?php echo $_item['School']['school_id'] ?></td>
                        <td><?php echo $_item['School']['school_name']; ?></td>


                        <td style="width: 100px">
                            <a title="Edit this user" href="/school/edit/<?php echo $_item['School']['school_id']; ?>"
                               class="btn btn-sm btn-success"><i class="glyphicon glyphicon-edit icon-white"></i></a>

                            <a onclick="return confirm('<?php echo __("Are you sure you want to delete this item?") ?>');"
                               title="Delete" href="/school/delete/<?php echo $_item['School']['school_id']; ?>"
                               data-toggle="modal" class="btn btn-sm btn-danger delete"><i
                                        class="glyphicon glyphicon-ban-circle icon-white"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php echo $this->element('pagination'); ?>
        </div>
    </form>
</div>
 