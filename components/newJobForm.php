<hr/>
<form method="post">
    <h2 class="mt-4">New Work Experience</h2>
    <div class="form-group">
        <label for="input1">Internal Name</label>
        <input name="job_internal_name" type="text" class="form-control" id="input1" placeholder="Golf Course" required>
    </div>
    <div class="form-group">
        <label for="input2">Machine Description (markdown supported)</label>
        <textarea name="machine_description" class="form-control" id="input2"></textarea>
    </div>
    <div class="form-group">
        <label for="input3">Human Description (markdown supported)</label>
        <textarea name="human_description" class="form-control" id="input3"></textarea>
    </div>
    <div class="form-group">
        <label for="input4">Current</label>
        <input name="current" type="checkbox" class="form-control" id="input4">
    </div>
    <div class="form-group">
        <label for="input5">Start Date</label>
        <input name="start_date" type="date" class="form-control" id="input5" placeholder="2020-01-01">
    </div>
    <div class="form-group">
        <label for="input6">End Date</label>
        <input name="end_date" type="date" class="form-control" id="input6" placeholder="2020-01-01">
    </div>
    <div class="form-group">
        <label for="input7">Employer</label>
        <input name="employer_name" type="text" class="form-control" id="input7" placeholder="MegaCorp" required>
    </div>
    <div class="form-group">
        <label for="input8">Title</label>
        <input name="title" type="text" class="form-control" id="input8" placeholder="Assistant to Regional Manaer" required>
    </div>
    <div class="form-group">
        <label for="input9">Location</label>
        <input name="location" type="text" class="form-control" id="input9" placeholder="Narnia">
    </div>
    <input type="hidden" name="submit" value="create">
    <button type="submit" class="btn btn-primary mt-3">Submit</button>
</form>
