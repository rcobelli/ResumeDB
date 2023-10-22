<?php
/** @var $data array */
?>
<hr/>
<form method="post">
    <h2>Edit Certification</h2>
    <div class="form-group">
        <label for="input1">Internal Name</label>
        <input name="internal_certification_name" type="text" class="form-control" id="input1" placeholder="AWS Pro" value="<?php echo $data['internal_certification_name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="input2">External Name</label>
        <input name="external_certification_name" type="text" class="form-control" id="input2" placeholder="AWS Certified Solutions Architect (Associates)" value="<?php echo $data['external_certification_name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="input3">Expiration</label>
        <input name="expiration" type="date" class="form-control" id="input3" placeholder="2024-12-31" value="<?php echo $data['expiration']; ?>">
    </div>
    <input type="hidden" name="submit" value="update">
    <input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
<hr/>
