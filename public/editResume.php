<?php

include '../init.php';

$certificateHelper = new CertificationDao($config);
$educationHelper = new EducationDao($config);
$jobsHelper = new JobsDao($config);
$linksHelper = new LinksDao($config);
$profileHelper = new ProfileHelper($config);
$helper = new ResumeDao($config);

$resume_id = $_REQUEST['id'];

if (is_null($resume_id)) {
    echo "<script>window.close();</script>";
    die();
}

if (!empty($_POST)) {
    if (!$helper->update($resume_id, $_POST)) {
        $errors[] = $helper->getErrorMessage();
    }

    if (isset($_POST['education'])) {
        $educationHelper->deleteLinks($resume_id);
        foreach ($_POST['education'] as $i) {
            if (!$educationHelper->createLink($resume_id, $i)) {
                $errors[] = $educationHelper->getErrorMessage();
                break;
            }
        }
    }
    if (isset($_POST['job'])) {
        $jobsHelper->deleteLinks($resume_id);
        foreach ($_POST['job'] as $i) {
            if (!$jobsHelper->createLink($resume_id, $i)) {
                $errors[] = $jobsHelper->getErrorMessage();
                break;
            }
        }
    }
    if (isset($_POST['certification'])) {
        $certificateHelper->deleteLinks($resume_id);
        foreach ($_POST['certification'] as $i) {
            if (!$certificateHelper->createLink($resume_id, $i)) {
                $errors[] = $certificateHelper->getErrorMessage();
                break;
            }
        }
    }
    if (isset($_POST['link'])) {
        $linksHelper->deleteLinks($resume_id);
        foreach ($_POST['link'] as $i) {
            if (!$linksHelper->createLink($resume_id, $i)) {
                $errors[] = $linksHelper->getErrorMessage();
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

$data = $helper->select($_REQUEST['id']);

// Start rendering the content
ob_start();
?>
<script>
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>
<h1>Edit Resume</h1>

<form class="ml-2 mr-2" method="post">
    <div class="form-group">
        <label for="input1">Internal Resume Name</label>
        <input name="internal_resume_name" class="form-control" id="input1" type="text" placeholder="Software Engineer" value="<?php echo $data['internal_resume_name']; ?>" readonly>
    </div>
    <label>Work Experience Descriptions</label>
    <div class="mb-2">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="machine" name="type" class="custom-control-input" value="machine" <?php if ($data['machine_first']) echo "checked"; ?>>
            <label class="custom-control-label" for="machine">Machine Optimized</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="human" name="type" class="custom-control-input" value="human" <?php if (!$data['machine_first']) echo "checked"; ?>>
            <label class="custom-control-label" for="human">Human Optimized</label>
        </div>
    </div>
    <div class="form-group">
        <label for="input2">Skills (markdown supported)</label>
        <textarea name="skills" class="form-control" id="input2"><?php echo $data['skills']; ?></textarea>
    </div>
    <div class="mb-2">
        <label>Work Experience to Include</label>
        <?php
        $existingLinks = $jobsHelper->getLinks($resume_id);
        foreach ($jobsHelper->selectAll() as $i) {
            if (array_search($i['job_id'], array_column($existingLinks, 'job_id')) !== false) {
                $enabled = 'checked';
            } else {
                $enabled = '';
            }

            echo '<div class="form-check">';
            echo '<input type="checkbox" id="job' . $i['job_id'] . '" name="job[]" class="form-check-input" value="' . $i['job_id'] . '" ' . $enabled . '>';
            echo '<label class="form-check-label" for="job' . $i['job_id'] . '">' . $i['job_internal_name'] . '</label>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="mb-2">
        <label>Education Experience to Include</label>
        <?php
        $existingLinks = $educationHelper->getLinks($resume_id);
        foreach ($educationHelper->selectAll() as $i) {
            if (array_search($i['education_id'], array_column($existingLinks, 'education_id')) !== false) {
                $enabled = 'checked';
            } else {
                $enabled = '';
            }

            echo '<div class="form-check">';
            echo '<input type="checkbox" id="edu' . $i['education_id'] . '" name="education[]" class="form-check-input" value="' . $i['education_id'] . '"' . $enabled . '>';
            echo '<label class="form-check-label" for="edu' . $i['education_id'] . '">' . $i['education_internal_name'] . '</label>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="mb-2">
        <label>Certifications to Include</label>
        <?php
        $existingLinks = $certificateHelper->getLinks($resume_id);
        foreach ($certificateHelper->selectAll() as $i) {
            if (array_search($i['certification_id'], array_column($existingLinks, 'certification_id')) !== false) {
                $enabled = 'checked';
            } else {
                $enabled = '';
            }

            echo '<div class="form-check">';
            echo '<input type="checkbox" id="cert' . $i['certification_id'] . '" name="certification[]" class="form-check-input" value="' . $i['certification_id'] . '" ' . $enabled . '>';
            echo '<label class="form-check-label" for="cert' . $i['certification_id'] . '">' . $i['internal_certification_name'] . '</label>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="mb-2">
        <label>Links to Include</label>
        <?php
        $existingLinks = $linksHelper->getLinks($resume_id);
        foreach ($linksHelper->selectAll() as $i) {
            if (array_search($i['link_id'], array_column($existingLinks, 'link_id')) !== false) {
                $enabled = 'checked';
            } else {
                $enabled = '';
            }

            echo '<div class="form-check">';
            echo '<input type="checkbox" id="link' . $i['link_id'] . '" name="link[]" class="form-check-input" value="' . $i['link_id'] . '" ' . $enabled . '>';
            echo '<label class="form-check-label" for="link' . $i['link_id'] . '">' . $i['link_name'] . '</label>';
            echo '</div>';
        }
        ?>
    </div>
    <input type="hidden" name="id" value="<?php echo $resume_id; ?>">
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>

<?php
$content = ob_get_clean();
$page->setContent($content);

$site->render();
