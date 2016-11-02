<?php
/* @var $this PersonnelController */
/* @var $data Personnel */
?>
<div>Quickq <span id="qqLogin">Login</span> 
	<input type=hidden id="qqS" value="<?php echo $model->surname ?>">
	<input type=hidden id="qqN" value="<?php echo $model->name ?>"> 
	<input type=hidden id="qqP" value="<?php echo $model->patr  ?>">
	<input type=hidden id="newUserQQLogin" value="<?php echo $model->usersQqs->getLogin() ?>">
	<?php echo $model->usersQqs->getPassword() ?><input type=hidden id="newUserQQPassword" value="<?php echo md5($model->usersQqs->getPassword()) ?>"> 
	<input type=hidden id="newUserQQRole" value="<?php echo $model->usersQqs->getRole()  ?>">
	<span id="qqLogout">Logout</span> <span id="qqNewUser">newUser</span></div>
