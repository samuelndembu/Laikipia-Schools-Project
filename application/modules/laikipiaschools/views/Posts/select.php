<div class="form-group">
                                    <label for="partner_type">Category:</label>
                                    <select id="inputState" class="form-control" name="partner_type">
                                        <option selected>Choose category</option>

                                        <?php if ($categories->num_rows() > 0) {
    foreach ($categories->result() as $row) {?>
                                        <option value="<?php echo $row->category_id ?>">
                                            <?php echo $row->category_name ?></option>
                                        <?php
}
}?>
                                    </select>
                                </div>