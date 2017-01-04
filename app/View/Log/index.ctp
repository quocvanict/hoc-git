<script src="http://momentjs.com/downloads/moment.js"></script>
<script src="/assets/js/rs.datetimepicker.js"></script>

<div id="bz" script="log.index();"></div>
<nav class="navbar_menu navbar-default">
    <div class="container-fluid">
        <div class="row" id="bs-example-navbar-collapse-1" style="padding-left: 0px">
            <ul class="nav navbar-nav" style="width: 16%">
                <li style="width: 28%;text-align: center" class="<?php if ($device_select == 'ALL') echo 'active'; ?>"><a href="/log/index" >All</a></li>
                <li class="<?php if ($device_select == 'Android') echo 'active'; ?>"><a href="/log?device_select=Android" >Android</a></li>
                <li style="width: 28%;text-align: center"class="<?php if ($device_select == 'iOS') echo 'active'; ?>"><a href="/log?device_select=iOS" >iOS</a></li>
            </ul>
            <form class=" navbar-form" style="width: 100%">

                <div class="col-sm-2 " style="width: 13%;padding-right: 0px;">
                    <input type="text" style="width: 100%" value="<?php
                    echo $os_ver;
                    ?>" data-field="os_ver"  placeholder="OS version" class="search-fields form-control" />
                </div>
                <div class="col-sm-2 " style="width: 13%;padding-right: 0px;">
                    <input type="text" style="width: 100%" value="<?php
                    echo $build;
                    ?>" data-field="build"  placeholder="Build" class="search-fields form-control" />

                </div>

                <div class="col-sm-5 search_paddding" style="width: 42%" >

                    <label class="col-sm-2 search_top" >Log date:</label>

                    <div class="col-sm-5"style="padding-right: 0px;padding-left: 7px">
                        <div class="input-group date datetimepicker">
                            <input type="text" class="form-control search-fields input-group-addon1" data-field="start_time" value="<?php echo $start_time; ?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-5 search_paddding" style="padding-right: 0px;padding-left: 7px">
                        <div class="input-group date datetimepicker">
                            <input type="text" class="form-control search-fields input-group-addon1" data-field="end_time" value="<?php echo $end_time; ?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1" style="width: 16%">
                    <input class="search-button btn btn-success" title="Search for something" type="button" name="search" class="btn btn-primary" value="Search"/>
                    <a href="/log/index"><span title="Reset search" class=" btn btn-warning">Reset</span></a>
                </div>

            </form>
        </div>
    </div>
</div>
</nav>
<div class="clearfix" style="margin-bottom: 7px"></div> 
<style>
    .table1, .th1, .td1 {
        border: 1px solid #f1cccc;
        border-collapse: collapse;
    }
    .th1, .td1 {
        padding: 5px;
    }
    .morecontent span {
        display: none;
    }
    .morelink {
        display: block;
        color: #006dcc;
    }
</style>
<div class="row">
    <div class="box">
        <form method="POST" class="form-list" id="myForm" >
            <!-- Setting point-->
            <div class="box-header">
            </div>
            <div class="box-content" id="table-container">
                <table class="table table-striped" id="maintable">
                    <thead>
                        <?php
                        $paginator = $this->Paginator;
                        echo "<tr id='table_header'>";
                        echo "<th>" . $paginator->sort('id', 'id') . "</th>";
                        echo "<th>" . $paginator->sort('os_version', 'OS version') . "</th>";
                        echo "<th>" . $paginator->sort('device', 'Device') . "</th>";
                        echo "<th>" . $paginator->sort('device_id', 'Device ID') . "</th>";
                        echo "<th>" . $paginator->sort('build', 'Build') . "</th>";
                        echo "<th>" . $paginator->sort('log', 'Log') . "</th>";
                        echo "<th>" . $paginator->sort('log', 'Log date') . "</th>";
                        echo "</tr>";
                        ?>
                    </thead>
                    <tbody>
                        <?php foreach ($list_log as $log): ?>
                            <?php $log = $log['Log'] ?>
                            <tr>
                                <td><?php echo $log['id'] ?></td>
                                <td><?php echo $log['os_version'] ?></td>
                                <td><?php echo $log['device'] ?></td>
                                <td><?php echo $log['device_id'] ?></td>
                                <td><?php echo $log['build'] ?></td>
                                <td class="more"><?php echo $log['log'] ?></td>
                                <td><?php echo $log['created_datetime'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="bottom_anchor"></div>
                <?php echo $this->element('pagination'); ?>
            </div>
        </form>
        <a data-toggle="modal" data-target="#myModal" class="btn btn-danger" style="margin: 10px;padding: 10px">
            <span title="Clear log" >Clear log</span></a>
    </div>
</div>
<!-- Model box -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title"><b>Clear log</b></h2>
            </div>
            <div class="modal-body">
                <p>Are you sure to clear log?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="del();" data-dismiss="modal">Yes</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

            </div>
        </div>

    </div>
</div>

<script>
    function del() {

        var list_log = <?php echo json_encode($list_log) ?>;

        if (list_log.length == 0) {
            alert("Nothing to clear");
        } else {
            $.ajax({
                url: '/log/delete',
                method: "POST",
                data: {list: list_log, }
            }).done(function (msg) {

                if (msg == "done") {
                    location.reload();
                } else {
                    alert(msg);
                }
            });
        }


    }

    //Show less show more
    $(document).ready(function () {

        var showChar = 50;
        var ellipsestext = "...";
        var moretext = "Show more >";
        var lesstext = "Show less";


        $('.more').each(function () {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function () {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });

</script>