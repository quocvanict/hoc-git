<div id="bz" script="banner.index();"></div>
<div class="box">
    <form method="POST" class="form-list">
        <!-- Setting point-->
        <div class="box-header">
            <h2><?php echo __('List') ?></h2>
            <a href="/admin/edit" class="btn btn-primary" style="float: right;height: 40px; line-height: 28px"><i
                        class="glyphicon glyphicon-plus"></i><?php echo __('Add') ?></a>
        </div>
        <div class="box-content">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><input type="checkbox" class="checkall"/></th>
                    <th><?php echo __('Email') ?></th>
                    <th><?php echo __("Fullname") ?></th>
                    <th><?php echo __("School name") ?></th>
                    <th><?php echo __("Rule") ?></th>
                    <th><?php echo __("Status") ?></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $l):
                    $school = $l['School'];
                    $l = $l['Admin'] ?>

                    <tr>
                        <td><input type="checkbox" class="massaction-checkbox" data-value="<?php echo $l['id'] ?>"/>
                        </td>
                        <td><?php echo $l['email']; ?></td>
                        <td><?php echo $l['name']; ?></td>
                        <td><?php echo $school['school_name']; ?></td>
                        <td><?php echo ($l['level'] == 1) ? __("Admin") : __("User"); ?></td>
                        <td><?php echo ($l['status'] == 1) ? __('Active') : __('Inactive'); ?></td>
                        <td>
                            <a title="Edit this account" href="/admin/edit/<?php echo $l['id']; ?>"class="btn btn-sm btn-success"><i class="glyphicon glyphicon-edit icon-white"></i></a>

                            <a onclick="return confirm('<?php echo __("Are you sure you want to delete this item?") ?>');" href="/admin/delete/<?php echo $l['id']; ?>" data-toggle="modal"
                               class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-ban-circle icon-white"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php echo $this->element('pagination'); ?>
        </div>
    </form>
</div>