<!--<input type="text" class="search hidden-sm" placeholder="search..." />-->

<div class="nav-collapse sidebar-nav collapse navbar-collapse bs-navbar-collapse">
	<ul class="nav nav-tabs nav-stacked main-menu">
	<?php foreach(Configure::read('left_menu') as $menu) {
        if (in_array($user_level, $menu['rule'])) {
            ?>
            <?php if (!$menu['childrens']) { ?>
                <li><a href="<?php echo $menu['url']; ?>" title="<?php echo $menu['title']; ?>"><i
                                class="<?php echo $menu['icon']; ?>"></i><span
                                class="hidden-sm"> <?php echo $menu['title']; ?></span></a></li>
            <?php } else { ?>
                <li>
                    <a class="dropmenu" href="#" title="<?php echo $menu['title']; ?>"><i
                                class="<?php echo $menu['icon']; ?>"></i><span
                                class="hidden-sm"> <?php echo $menu['title']; ?></span></a>
                    <ul>
                        <?php foreach ($menu['childrens'] as $submenu) { ?>
                            <li><a class="submenu" href="<?php echo $submenu['url']; ?>"
                                   title="<?php echo $submenu['title']; ?>"> <span
                                            class="hidden-sm"> <?php echo $submenu['title']; ?></span></a></li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
            <?php
        }
    }

	?>
	</ul>
</div>