<hr/>
<form method="post">
    <h2 class="mt-4">New Education Experience</h2>
    <div class="form-group">
        <label for="input1">Internal Name</label>
        <input name="education_internal_name" type="text" class="form-control" id="input1" placeholder="College" required>
    </div>
    <div class="form-group">
        <label for="input2">Institution</label>
        <input name="institution" type="text" class="form-control" id="input2" placeholder="Georgia Tech" required>
    </div>
    <div class="form-group">
        <label for="input3">Location</label>
        <input name="location" type="text" class="form-control" id="input3" placeholder="Location">
    </div>
    <div class="form-group">
        <label for="input4">Result</label>
        <input name="result" type="text" class="form-control" id="input4" placeholder="B.S. Computer Science" required>
    </div>
    <div class="form-group">
        <label for="input5">GPA</label>
        <input name="gpa" type="text" class="form-control" id="input5" placeholder="1.90">
    </div>
    <div class="form-group">
        <label for="input6">Description (markdown supported)</label>
        <textarea name="description" class="form-control" id="input6"></textarea>
    </div>
    <div class="form-group">
        <label for="input7">Completion Date</label>
        <input name="completion_date" type="date" class="form-control" id="input7" placeholder="2020-05-01">
    </div>
    <input type="hidden" name="submit" value="create">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
