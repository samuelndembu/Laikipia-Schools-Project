
<?php
$validation_errors = validation_errors();
if (!empty($validation_errors)) {
    echo $validation_errors;
}
?>
<div class="shadow-lg p-3 mb-5 bg-white rounded">
<div class="card shadow mb-4">
<div class="card-header py-3">

<!-- <button type="button" class="btn btn-success">Add Partner</button> -->

<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
Add Category
</button>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Add new Category</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
<?php echo form_open_multipart(base_url() . 'laikipiaschools/categories/create_category') ?>
      <div class="form-group">
        <label for="category_Parent">Parent</label>
        <!-- <input type="name" class="form-control" name="partner_type" id="partner_type" naria-describedby="emailHelp" placeholder="Select Partner Name"> -->
        <select id="inputState" class="form-control" name="category_parent">
          <option value="">Choose a parent...</option>
          <?php if (is_array($categories->result())) {
    foreach ($categories->result() as $cat) {?>
              <option value="<?php echo $cat->category_id; ?>"><?php echo $cat->category_name; ?></option>
            <?php }
}?>
      </select>
      </div>
      <div class="form-group">
        <label for="category_name"> Name</label>
        <input type="name" class="form-control" name="category_name" id="category_name" naria-describedby="emailHelp" placeholder="Enter category Name">
      </div>
  </div>
  <div class="modal-footer">
  <button type="submit" class="btn btn-primary">Submit</button>
  </div>

</div>
</div>
</div>
<?php echo form_close() ?>

<!-- 
<div class="card-body"> -->
<div class="table-responsive">
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>#</th>
      <th>Parent</th>
      <th>Name</th>
      <th>Actions</th>
      
    </tr>
  </thead>
  <tfoot>
  <tr>
      <th>#</th>
      <th>Parent</th>
      <th>Name</th>
      <th>Actions</th>
    </tr>
  </tfoot>
  <tbody>
    <?php
if ($query->num_rows() > 0) {
    $count = 0;
    foreach ($query->result() as $row) {
        $count++;
        ?>

    <tr>
      <td>
        <?php echo $count ?>
      </td>
      <td>
        <?php if ($row->category_parent == 0) {
            echo "";
        } else {
            foreach ($categories->result() as $category) {
                if ($category->category_id == $row->category_parent) {
                    echo $category->category_name;
                }

            }
        }

        ?>
      </td>
      <td>
        <?php echo $row->category_name; ?>
        </td>
      <td>
      <?php if ($row->category_status == 1) {?>
        <a href="" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modalLoginAvatar"><i class="fas fa-eye"></i></a>
      <?php }?>

<!--Modal: Login with Avatar Form-->
<div class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
aria-hidden="true" >
<div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document" >
<!--Content-->
<div class="modal-content" style="margin-left:0px;">

<!--Header-->

<!--Body-->
<div class="modal-body ">

  <h5 class="pl-3 pb-3" style="font-size:20px;list-style-type:none;margin-left:10px;"><b>Retrieved:</b>  <?php echo $row->category_name; ?></h5>

  <div class=" pl-3 pb-3" style="font-size:20px;list-style-type:none;margin-left:10px;">
  <li ><b>Parent:</b>   <?php echo $row->category_parent; ?></li>
  </div>
  <div class="pl-3" style="font-size:20px;list-style-type:none;margin-left:10px;">
  <li><b>Name:</b> <?php echo $row->category_name; ?></li>
  </div>

</div>
<div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

      </div>

</div>
<!--/.Content-->
</div>
</div>
<!--Modal: Login with Avatar Form-->
      <?php echo anchor("administration/edit/" . $row->category_id, "<i class='fas fa-edit'></i>", "class='btn btn-warning btn-sm p-left-10'", "style='padding-left:10px;'"); ?>

      <?php if ($row->category_status == 1) {
            echo anchor("administration/deactivate-category/" . $row->category_id . "/" . $row->category_status, "<i class='far fa-thumbs-down'></i>", array("class" => "btn btn-info btn-sm p-left-10", "onclick" => "return confirm('Are you sure you want to deactivate?')"));
        } else {
            echo anchor("administration/deactivate-category/" . $row->category_id . "/" . $row->category_status, "<i class='far fa-thumbs-up'></i>", array("class" => "btn btn-info btn-sm", "onclick" => "return confirm('Are you sure you want to activate?')"));
        }?>
        <?php echo anchor("administration/delete-category/" . $row->category_id, "<i class='fas fa-trash-alt'></i>", array("class" => "btn btn-danger btn-sm", "onclick" => "return confirm('Are you sure you want to Delete?')")); ?>

      </td>
    </tr>
    <?php
}
}
?>
  </tbody>
</table>
</div>
<!-- </div> -->


<p>
    <?php echo $links; ?>
</p>

</div>


