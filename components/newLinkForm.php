<hr/>
<form method="post">
    <h2 class="mt-4">New Link</h2>
    <div class="form-group">
        <label for="input1">Internal Name</label>
        <input name="link_name" type="text" class="form-control" id="input1" placeholder="LinkedIn" required>
    </div>
    <div class="form-group">
        <label for="input2">Value</label>
        <input name="link_value" type="text" class="form-control" id="input2" placeholder="https://linkedin.com/in/rcobelli" required>
    </div>
    <input type="hidden" name="submit" value="create">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
