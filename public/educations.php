<?php

include '../init.php';

$samlHelper->processSamlInput();

if (!$samlHelper->isLoggedIn()) {
    header("Location: index.php");
    die();
}

$config['type'] = Rybel\backbone\LogStream::console;

$helper = new EducationDao($config);
$parsedown = new Parsedown();

// Boilerplate
$page = new Rybel\backbone\page();
$page->addHeader("../includes/header.php");
$page->addFooter("../includes/footer.php");
$page->addHeader("../includes/navbar.php");

// Application logic
if ($_REQUEST['action'] == 'delete') {
    if ($helper->delete($_REQUEST['id'])) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
} elseif ($_REQUEST['submit'] == 'create') {
    if ($helper->insert($_POST)) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
} elseif ($_REQUEST['submit'] == 'update') {
    if ($helper->update($_POST['id'], $_POST)) {
        header("Location: ?");
        die();
    } else {
        $page->addError($helper->getErrorMessage());
    }
}

// Start rendering the content
ob_start();

if ($_REQUEST['action'] != 'create') {
    ?>
    <button class="btn btn-success float-right" onclick="window.location = '?action=create'">New Education</button>
    <?php
}
?>
<h1>Manage Education</h1>

<?php

if ($_REQUEST['action'] == 'create') {
    include_once('../components/newEducationForm.php');
} elseif ($_REQUEST['action'] == 'update') {
    $data = $helper->select($_REQUEST['id']);
    include_once('../components/editEducationForm.php');
} else {
    ?>
    <table class="table table-hover mt-5">
        <thead>
        <tr>
            <th>Internal Name</th>
            <th>Institution</th>
            <th>Location</th>
            <th>Result</th>
            <th>GPA</th>
            <th>Description</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($helper->selectAll() as $i) {
            echo "<tr>";
            echo "<td><a href='?action=update&id=" . $i['education_id'] . "'>" . $i['education_internal_name'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['education_id'] . "'>" . $i['institution'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['education_id'] . "'>" . $i['location'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['education_id'] . "'>" . $i['result'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['education_id'] . "'>" . $i['gpa'] . "</a></td>";
            echo "<td><a href='?action=update&id=" . $i['education_id'] . "'>" . $parsedown->text($i['description']) . "</a></td>";
            echo "<td><a class='btn btn-outline-danger' href='?action=delete&id=" . $i['education_id'] . "'>🗑️</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
}


// End rendering the content
$content = ob_get_clean();
$page->render($content);
