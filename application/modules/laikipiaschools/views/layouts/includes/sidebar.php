<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="list-group-flush">
        <ul class="nav flex-column">

            <li class="nav-item pl-4 ">

                <div class="menu-block customscroll">
                    <div class="sidebar-menu">
                        <ul id="accordion-menu">
                            <li class="dropdown">
                                <a href="<?php echo base_url(); ?>administration/schools" class="">
                                    <span class="fas fa-graduation-cap"></span><span class="mtext"><b>School</b></span>
                                </a>
                            </li>
                            <hr>
                            <li class="dropdown">
                                <a href="javascript:;" class="">
                                    <span class="fa fa-table"></span>Content
                                </a>
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url(); ?>administration/categories">Category</a></li>

                                    <li><a href="<?php echo base_url(); ?>administration/posts">Post</a></li>
                                </ul>
                            </li>
                            <hr>
                            <?php if (is_array($categories->result())) {
    $cats = array();
    foreach ($categories->result() as $cat) {
        if (!in_array($cat->category_parent, $cats) && ($cat->category_parent != "0" || $cat->category_parent != 0)) {

            array_push($cats, $cat->category_parent);
        }

    }
    // var_dump($cats);
    foreach ($cats as $cat) {
        ?>
                            <li class="dropdown">
                                <a href="javascript:;" class="">
                                    <?php foreach ($categories->result() as $value) {
            if ($value->category_id == $cat) {?>
                                    <?php echo $value->category_name;
            }
        }
        ?>
                                </a>
                                <ul class="submenu">
                                    <?php
foreach ($categories->result() as $value) {
            if ($value->category_parent == $cat) {?>

                                    <li><a
                                            href="<?php echo base_url(); ?>administration/<?php echo strtolower($value->category_name); ?>"><?php echo $value->category_name; ?></a>
                                    </li>

                                    <?php }
        }?>
                                </ul>
                            </li>
                            <hr>
                            <?php }
}?>
                        </ul>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</nav>