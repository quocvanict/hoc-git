 

<div class="clearfix" style="margin-bottom: 7px"></div>
<div class="box">
    <form method="POST" class="form-list" id="myForm" >
        <!-- Setting point-->
        <!--<div id="top_anchor"></div>-->
        <div class="box-content" id="table-container">
            <table class="table table-striped"  id="maintable">
                <thead >
					<tr>
						<th>
							STT
						</th>
						<th>
							Target ID
						</th>

						<th>

						</th>

						
					</tr>
                </thead>
                <tbody>
                    <?php foreach($json_retrieve as $key=>$_target){ ?>
                        <tr>
							
							<td><?php echo $key  ?></td>
							<td><?php echo $_target['target_cloud']; ?></td>

							 
                            <td>
                                <a target="_blank" title="Edit this user" href="/vuforia/edit/<?php echo $_target['target_relationship']['VuforiaTarget']['id']; ?>" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-edit icon-white" title="Edit this user"></i></a>

                                <a title="Delete target" href="/vuforia/delete/<?php echo $_target['target_cloud']; ?>" data-toggle="modal" class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-ban-circle icon-white" title="Delete this user"></i></a>
                            </td>
                        </tr>
					<?php } ?>
                </tbody>
            </table>
            <?php echo $this->element('pagination'); ?>
        </div>
    </form>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js">
</script>
<script src="/assets/js/customs_pop.js">
</script>
<!-- Model box -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title"><b>Delete User</b></h2>
            </div>
            <div class="modal-body">
                <p id="conent-message">Are you sure delete this user?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-delete" data-dismiss="modal">Yes</button>
                <button type="button" class="btn btn-danger" id="btn-close" data-dismiss="modal">Close</button>

            </div>
        </div>

    </div>
</div>
<script>
    $(".delete").on("click", function () {
        $("#btn-delete").attr("onclick", "del(" + $(this).data("id") + ")");
    });
    $('.status').on('change', function () {
        var conf = confirm('Do you want change user status?');
        if (conf) {
            var user_id = $(this).find(":selected").attr('class');
            var status = $(this).find(":selected").val();
            $.ajax({
                url: '/user/change_stt',
                method: "POST",
                data: {user_id: user_id, stt: status}
            }).done(function (msg) {
                alert(msg);
            });
        } else {
            $('.status option').prop('selected', function () {
                return this.defaultSelected;
            });
        }

    });
    function reset(id) {
        var c = confirm("Do you want to reset password for this user?");
        if (c) {
            $.ajax({
                url: '/user/reset_pass',
                method: "POST",
                data: {id: id}
            }).done(function (msg) {
                alert(msg);
                console.log(msg);
            });
        }

    }
    function del(id) {
        window.location.href = "/user/delete/" + id;

    }
    $('#myForm').submit(function () {
        var c = confirm("Click OK to continue?");
        return c; //you can just return c because it will be true or false
    });
</script>
