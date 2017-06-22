<?php
require_once("wp-load.php");
$wpdb;
if(!empty($_POST["keyword"])) {
$query ="SELECT * FROM a1_nasdaq WHERE Symbol like '" . $_POST["keyword"] . "%' or Name like '" . $_POST["keyword"] . "%' ORDER BY Symbol LIMIT 0,5";

$instruments = $wpdb->get_results($query);

$query ="SELECT * FROM a1_users WHERE display_name like '" . $_POST["keyword"] . "%' ORDER BY display_name LIMIT 0,5";
$authers = $wpdb->get_results($query);
?>
<?php if(!empty($instruments)) {?>
<h6>Symbol:</h6>
<ul id="instrument-auther-list">
<?php foreach($instruments as $instrument) {?>
<li onClick="redirectSymbos('<?php echo $instrument->Symbol; ?>');"><span><b><?php echo $instrument->Symbol;?></b></span><span><?php echo $instrument->Name; ?></span></li>
<?php } ?>
</ul>
<?php } ?>

<?php if(!empty($authers)) {?>
<h6 style="margin-top:0;">Authors:</h6>
<ul id="instrument-auther-list">
<?php foreach($authers as $auther) {?>
<li onClick="redirectAuthor('<?php echo $auther->user_login; ?>');"><?php echo $auther->display_name; ?></li>
<?php } ?>
</ul>
<?php } ?>

<?php } ?>
