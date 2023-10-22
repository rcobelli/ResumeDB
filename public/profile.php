<?php

include '../init.php';

$helper = new ProfileHelper($config);

// Site/page boilerplate
$site = new site($errors);
$site->addHeader("../includes/navbar.php");
init_site($site);

$page = new page();
$site->setPage($page);


// Start rendering the content
ob_start();
?>
<h1>Profile</h1>

<table class="table table-hover mt-5">
    <tbody>
    <td><?php echo $helper->name(); ?></td>
    <td><?php echo $helper->email(); ?></td>
    <td><?php echo $helper->phone(); ?></td>
    </tbody>
    </table>
<?php

// End rendering the content
$content = ob_get_clean();
$page->setContent($content);

$site->render();
?>
