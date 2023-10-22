<?php

include '../init.php';

$certificateHelper = new CertificationDao($config);
$educationHelper = new EducationDao($config);
$jobsHelper = new JobsDao($config);
$linksHelper = new LinksDao($config);
$profileHelper = new ProfileHelper($config);
$helper = new ResumeDao($config);
$parsedown = new Parsedown();

$resume_id = $_REQUEST['id'];

if (is_null($resume_id)) {
    echo "<script>window.close();</script>";
    die();
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
<h1>
    <?php echo $data['internal_resume_name']; ?>
</h1>
Copy & Paste the data from this page into a nicely formatted Word document resume template
<hr />
<style>
    h2 {
        margin-top: 20px;
    }
</style>

<?php
$links = $linksHelper->getLinks($resume_id);
if (count($links) > 0) {
    echo "<h2>Links</h2>";
}
echo "<ul>";
foreach ($links as $i) {
    $linkData = $linksHelper->select($i['job_id']);
    echo '<li>' . $linkData['link_value'] . '</li>';
}
echo "</ul>";


$linkedJobs = $jobsHelper->getLinks($resume_id);
if (count($linkedJobs) > 0) {
    echo "<h2>Work Experience</h2>";
}
foreach ($linkedJobs as $i) {
    $jobData = $jobsHelper->select($i['job_id']);
    echo $jobData['title'] . ', ' . $jobData['employer_name'];
    
    if (!is_null($jobData['location'])) {
        echo ' | ' . $jobData['location'];
    }

    if (!is_null($jobData['start_date'])) {
        echo ' <span class="float-right">' . date('m/Y', strtotime($jobData['start_date']));
        if (!is_null($jobData['end_date'])) {
            echo ' - ' . date('m/Y', strtotime($jobData['end_date']));
        } elseif ($jobData['current']) {
            echo ' - Present';
        }
        echo '</span>';
    }
    echo '</br>';
    if ($data['machine_first']) {
        echo $parsedown->text($jobData['machine_description']);
    } else {
        echo $parsedown->text($jobData['human_description']);
    }
}


$linkedEducation = $educationHelper->getLinks($resume_id);
if (count($linkedEducation) > 0) {
    echo "<h2>Education</h2>";
}
foreach ($linkedEducation as $i) {
    $educationData = $educationHelper->select($i['education_id']);
    echo $educationData['result'] . ', ' . $educationData['institution'];
    if (!is_null($educationData['gpa'])) {
        echo ' | ' . $educationData['gpa'];
    }
    if (!is_null($educationData['completion_date'])) {
        echo '<span class="float-right">' . date('Y', strtotime($educationData['completion_date'])) . '</span>';
    }
    echo '</br>';
    echo $parsedown->text($educationData['description']);
}


$linkedCerts = $certificateHelper->getLinks($resume_id);
if (count($linkedCerts) > 0) {
    echo "<h2>Certifications</h2>";
}
foreach ($linkedCerts as $i) {
    $certData = $certificateHelper->select($i['certification_id']);
    echo $certData['external_certification_name'] . ' <span class="float-right">' . $certData['expiration'] . '</span></br>';
}


if (!is_null($data['skills'])) {
    echo "<h2>Skills</h2>";
    echo $data['skills'];
}



$content = ob_get_clean();
$page->setContent($content);

$site->render();
