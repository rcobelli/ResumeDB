<?php
/** @var $data array */
?>
<hr/>
<form method="post">
    <h2>Edit Link</h2>
    <div class="form-group">
        <label for="input1">Internal Name</label>
        <input name="link_name" type="text" class="form-control" id="input1" placeholder="LinkedIn" value="<?php echo $data['link_name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="input2">Value</label>
        <input name="link_value" type="text" class="form-control" id="input2" placeholder="https://linkedin.com/in/rcobelli" value="<?php echo $data['link_value']; ?>" required>
    </div>
    <input type="hidden" name="submit" value="update">
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
<hr/>
