<?php

include '../init.php';

$certificateHelper = new CertificationDao($config);
$educationHelper = new EducationDao($config);
$jobsHelper = new JobsDao($config);
$linksHelper = new LinksDao($config);
$profileHelper = new ProfileHelper($config);
$helper = new ResumeDao($config);

if (!empty($_POST)) {
    if (!$helper->insert($_POST)) {
        $errors[] = $helper->getErrorMessage();
    }
    $resume_id = $helper->getLastInsertID();

    if (isset($_POST['education'])) {
        foreach ($_POST['education'] as $i) {
            if (!$educationHelper->createLink($resume_id, $i)) {
                $errors[] = $educationHelper->getErrorMessage();
                break;
            }
        }
    }
    if (isset($_POST['job'])) {
        foreach ($_POST['job'] as $i) {
            if (!$jobsHelper->createLink($resume_id, $i)) {
                $errors[] = $jobsHelper->getErrorMessage();
                break;
            }
        }
    }
    if (isset($_POST['certification'])) {
        foreach ($_POST['certification'] as $i) {
            if (!$certificateHelper->createLink($resume_id, $i)) {
                $errors[] = $certificateHelper->getErrorMessage();
                break;
            }
        }
    }
    if (isset($_POST['link'])) {
        foreach ($_POST['link'] as $i) {
            if (!$certificateHelper->createLink($resume_id, $i)) {
                $errors[] = $certificateHelper->getErrorMessage();
                break;
            }
        }
    }

    if (empty($errors)) {
        echo "<script>window.close();</script>";
    }
}

// Site/page boilerplate
$site = new site($errors);
init_site($site);

$page = new page();
$site->setPage($page);


// Start rendering the content
ob_start();
?>
<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>
<h1>Create New Resume</h1>

<form class="ml-2 mr-2" method="post">
    <div class="form-group">
        <label for="input1">Internal Resume Name</label>
        <input name="internal_resume_name" class="form-control" id="input1" type="text" placeholder="Software Engineer"
            required>
    </div>
    <label>Work Experience Descriptions</label>
    <div class="mb-2">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="machine" name="type" class="custom-control-input" value="machine">
            <label class="custom-control-label" for="machine">Machine Optimized</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="human" name="type" class="custom-control-input" value="human">
            <label class="custom-control-label" for="human">Human Optimized</label>
        </div>
    </div>
    <div class="form-group">
        <label for="input2">Skills (markdown supported)</label>
        <textarea name="skills" class="form-control" id="input2"></textarea>
    </div>
    <div class="mb-2">
        <label>Work Experience to Include</label>
        <?php
        foreach ($jobsHelper->selectAll() as $i) {
            echo '<div class="form-check">';
            echo '<input type="checkbox" id="job' . $i['job_id'] . '" name="job[]" class="form-check-input" value="' . $i['job_id'] . '">';
            echo '<label class="form-check-label" for="job' . $i['job_id'] . '">' . $i['job_internal_name'] . '</label>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="mb-2">
        <label>Education Experience to Include</label>
        <?php
        foreach ($educationHelper->selectAll() as $i) {
            echo '<div class="form-check">';
            echo '<input type="checkbox" id="edu' . $i['education_id'] . '" name="education[]" class="form-check-input" value="' . $i['education_id'] . '">';
            echo '<label class="form-check-label" for="edu' . $i['education_id'] . '">' . $i['education_internal_name'] . '</label>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="mb-2">
        <label>Certifications to Include</label>
        <?php
        foreach ($certificateHelper->selectAll() as $i) {
            echo '<div class="form-check">';
            echo '<input type="checkbox" id="cert' . $i['certification_id'] . '" name="certification[]" class="form-check-input" value="' . $i['certification_id'] . '">';
            echo '<label class="form-check-label" for="cert' . $i['certification_id'] . '">' . $i['internal_certification_name'] . '</label>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="mb-2">
        <label>Links to Include</label>
        <?php
        foreach ($linksHelper->selectAll() as $i) {
            echo '<div class="form-check">';
            echo '<input type="checkbox" id="link' . $i['link_id'] . '" name="link[]" class="form-check-input" value="' . $i['link_id'] . '">';
            echo '<label class="form-check-label" for="link' . $i['link_id'] . '">' . $i['link_name'] . '</label>';
            echo '</div>';
        }
        ?>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>

<?php
$content = ob_get_clean();
$page->setContent($content);

$site->render();
