<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <?php if (isset($title)) $this->assign('title', $title); ?>
        <title><?php echo $this->fetch('title'); ?></title>
        <!-- end: Meta -->
        <!-- start: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- end: Mobile Specific -->
        <base href="<?php echo BASE_URL ?>" />
        <!-- start: CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="assets/css/retina.min.css" rel="stylesheet" />
        <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
        <link href="assets/css/halflings.css" rel="stylesheet" />
        <link href="assets/css/social.css" rel="stylesheet" />
        <link href="http://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet" />
        <link href="http://fonts.googleapis.com/css?family=Lato:400" rel="stylesheet" />
        <link href="http://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" />
        <link href="assets/css/style.min.css" rel="stylesheet" />
        <link href="assets/css/customs.css" rel="stylesheet" />
        <link href="assets/css/all.css" rel="stylesheet" />
        <link href="assets/css/add_style.css" rel="stylesheet" />
        <!-- end: CSS -->
        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <script src="assets/css/ie6-8.css"></script>
        <![endif]-->
        <!-- start: Favicon and Touch Icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/favico.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/favico.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/favico.png" />
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="assets/ico/favico.png" />
        <link rel="shortcut icon" href="assets/ico/favico.png" />
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.validate.js"></script>
        <!-- theme scripts -->
        <script src="assets/js/core.min.js"></script>
        <script src="assets/js/customs.js"></script>
        <script src="assets/js/jquery-impromptu.js"></script>
        <script src="assets/js/all.js"></script>
        <!-- end: Favicon and Touch Icons -->
        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <?php echo $this->element("admin_top"); ?>
        <div class="container">
            <div class="row">
                <!-- start: Main Menu -->
                <div id="sidebar-left" class="col-lg-2 col-sm-1">
                    <?php echo $this->element("admin_left_menu"); ?>
                </div>
                <!-- end: Main Menu -->
                <!-- start: Content -->

                <div id="content" class="col-lg-10 col-sm-11">


                    <?php
                    echo $this->Session->flash('success');
                    echo $this->Session->flash('error');
                    echo $this->Session->flash('warning');
                    echo $this->Session->flash('notice');
                    ?>


                    <div class="row">
                        <?php echo $this->fetch('content'); ?>
                    </div>
                    <!--/col-->
                </div>
            </div>
            <!--/row-->
        </div>
        <!--/container-->
        <div class="clearfix"></div>
        <?php echo $this->element("admin_footer"); ?>
        <div class="page-loading">
            <img src="assets/img/loading.gif" alt="Loading..." /><br />Loading...
        </div>
        <!-- end: JavaScript-->
        <script>l();</script>
    </body>
</html>