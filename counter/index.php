<?php
session_start();

require __DIR__.'/vendor/autoload.php';

const FILE_HITS = 'hits_counter.txt';
const FILE_USERS = 'users_counter.txt';

$usersCounter = new Counter(FILE_USERS);
$hitsCounter = new Counter(FILE_HITS);
$hitsCounter->increment();

if (!isset($_SESSION['visited'])) {
	$usersCounter->increment();
	$_SESSION['visited'] = true;
}

?>

<html>
	<body>
		<h4>Hits count: <?php echo $hitsCounter->count(); ?></h4>
		<h4>Users count: <?php echo $usersCounter->count(); ?></h4>
	</body>
</html>
