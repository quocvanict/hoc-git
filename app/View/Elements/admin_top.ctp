<!-- start: Header -->
<header class="navbar" style="border-radius: 0px;">
    <div class="container">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".sidebar-nav.nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a id="main-menu-toggle" class="hidden-xs open"><i class="fa fa-bars"></i></a>
        <a class="navbar-brand col-lg-2 col-sm-1 col-xs-12" href="./"><span><?php echo Configure::read('project_title'); ?></span></a>
        <!-- start: Header Menu -->
        <div class="nav-no-collapse header-nav">
            <div class="col-md-2"></div>
            <h2 style="position: relative; top: 13px;" class="nav navbar-nav"><?php if (!empty($title_for_menu)) echo $title_for_menu; ?></h2>
            <ul class="nav navbar-nav pull-right">

                <!-- start: User Dropdown -->
                <li class="dropdown">
                    <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
                        <div class="user">
                            <span class="hello"><?php echo __('Welcome!') ?></span>
                            <span class="name"><?php echo AuthComponent::user('name'); ?></span>
                        </div>
                    </a>
                    <ul class="dropdown-menu pull-right">
                            <!--<li><a href="#"><i class="fa fa-envelope"></i> Profile</a></li>-->
                        <li><a href="auth/logout"><i class="fa  fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>
                <!-- end: User Dropdown -->
            </ul>
        </div>
        <!-- end: Header Menu -->
    </div>
</header>
<!-- end: Header -->