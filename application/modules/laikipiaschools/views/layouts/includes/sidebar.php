<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="list-group-flush">
        <ul class="nav flex-column">

            <li class="nav-item ">


                <div class="menu-block customscroll">
                    <div class="sidebar-menu">
                        <ul id="accordion-menu">

                            <li class="dropdown">
                                <a href="<?php echo base_url(); ?>administration/schools" class="dropdown-toggle">
                                    <span class="fas fa-graduation-cap"></span><span class="mtext">School</span>
                                </a>

                            </li>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle">
                                    <span class="fa fa-home"></span>Content
                                </a>
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url(); ?>laikipiaschools/categories">Category</a></li>

                                    <li><a href="<?php echo base_url(); ?>laikipiaschools/posts">Post</a></li>
                                </ul>
                            </li>
                            <?php if (is_array($categories->result())) {
    $cats = array();
    foreach ($categories->result() as $cat) {
        if (!in_array($cat->parent, $cats) && ($cat->parent != "" || $cat->parent != null)) {
            array_push($cats, $cat->parent);
        }

    }

    foreach ($cats as $cat) {
        ?>
                            <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle">
                                    <span class="fa fa-home"></span><?php echo $cat; ?>
                                </a>
                                <ul class="submenu">
                                    <?php
foreach ($categories->result() as $value) {
            if ($value->parent == $cat) {?>

                                    <li><a
                                            href="<?php echo base_url(); ?>administration/<?php echo strtolower($value->name); ?>"><?php echo $value->name; ?></a>
                                    </li>

                                    <?php }
        }?>
                                </ul>
                            </li>
                            <?php }
}?>
                        </ul>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</nav>