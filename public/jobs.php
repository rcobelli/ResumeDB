<?php

include '../init.php';

$helper = new JobsDao($config);
$parsedown = new Parsedown();

// Application logic
if ($_REQUEST['action'] == 'delete') {
    if ($helper->delete($_REQUEST['id'])) {
        header("Location: ?");
        die();
    } else {
        $errors[] = $helper->getErrorMessage();
    }
} elseif ($_REQUEST['submit'] == 'create') {
    if ($helper->insert($_POST)) {
        header("Location: ?");
        die();
    } else {
        $errors[] = $helper->getErrorMessage();
    }
} elseif ($_REQUEST['submit'] == 'update') {
    if ($helper->update($_POST['id'], $_POST)) {
        header("Location: ?");
        die();
    } else {
        $errors[] = $helper->getErrorMessage();
    }
}

// Site/page boilerplate
$site = new site($errors);
$site->addHeader("../includes/navbar.php");
init_site($site);

$page = new page();
$site->setPage($page);


// Start rendering the content
ob_start();

if ($_REQUEST['action'] != 'create') {
    ?>
    <button class="btn btn-success float-right" onclick="window.location = '?action=create'">New Job</button>
    <?php
}
?>
<h1>Manage Jobs</h1>

<?php

if ($_REQUEST['action'] == 'create') {
    include_once('../components/newJobForm.php');
} elseif ($_REQUEST['action'] == 'update') {
    $data = $helper->select($_REQUEST['id']);
    include_once('../components/editJobForm.php');
} else {
    ?>
    <table class="table table-hover mt-5">
        <thead>
        <tr>
            <th>Internal Name</th>
            <th>Machine Description</th>
            <th>Human Description</th>
            <th>Current</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Employer</th>
            <th>Title</th>
            <th>Location</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($helper->selectAll() as $i) {
            echo "<tr>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $i['job_internal_name'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $parsedown->text($i['machine_description']) . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $parsedown->text($i['human_description']) . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $i['current'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $i['start_date'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $i['end_date'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $i['employer_name'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $i['title'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['job_id'] . "'>" . $i['location'] . "</a></td>";
            echo "<td><a class='btn btn-outline-danger' href='?action=delete&id=" . $i['job_id'] . "'>🗑️</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
}


// End rendering the content
$content = ob_get_clean();
$page->setContent($content);

$site->render();
?>
