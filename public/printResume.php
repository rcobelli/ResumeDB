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
<div class="d-print-none">
    <h1>
        <?php echo $data['internal_resume_name']; ?>
    </h1>
    Hit <a onclick="print(); return false;" href="#">Print</a> or copy paste your information into a custom resume
    template
    <hr />
</div>
<link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'PT Serif', serif !important;
    }

    a:link {
        text-decoration: underline;
    }

    h2 {
        margin-top: 20px;
    }
</style>

<?php
echo "<h1 class='text-center'>" . $profileHelper->name() . "</h1>";
echo "<h4 class='text-center'>" . $profileHelper->email() . " | " . $profileHelper->phone() . "</h4>";

$links = $linksHelper->getLinks($resume_id);
if (count($links) > 0) {
    echo "<h2>Links</h2>";
}
echo "<h5>";
foreach ($links as $i) {
    $linkData = $linksHelper->select($i['link_id']);
    echo $linkData['link_value'] . ' | ';
}
echo "</h5>";

echo "<hr/>";

$linkedJobs = $jobsHelper->getLinks($resume_id);
if (count($linkedJobs) > 0) {
    echo "<h2>Work Experience</h2>";
}
$jobs = array();
foreach ($linkedJobs as $i) {
    array_push($jobs, $jobsHelper->select($i['job_id']));
}

function cmp($a, $b)
{
    return -1 * strcmp($a["start_date"], $b["start_date"]);
}

usort($jobs, "cmp");

foreach ($jobs as $jobData) {
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

echo "<hr/>";

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

echo "<hr/>";

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
    echo $parsedown->text($data['skills']);
}



$content = ob_get_clean();
$page->setContent($content);

$site->render();
