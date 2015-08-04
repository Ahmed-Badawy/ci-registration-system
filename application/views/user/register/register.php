<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">

		<?php if (validation_errors()) : ?>
			<div class="col-md-12 alert alert-danger">
				<ul>
					<?= validation_errors('<li>', '</li>') ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if (isset($errors)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?php foreach($errors as $error): ?>
					<li> <?= $error ?> </li>
					<?php endforeach ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="col-md-12">
			<div class="page-header">
				<h1>Register</h1>
			</div>

			<form action="<?= base_url('register') ?>" method="post">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Enter a username" value='<?= set_value('username') ?>'>
					<span><?= form_error('username', '<span style="color:red;" class="label">', '</span>'); ?></span>
					<p class="help-block">At least 4 characters, letters or numbers only</p>
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value='<?= set_value('email') ?>'>
					<span><?= form_error('email', '<span style="color:red;" class="label">', '</span>'); ?></span>
					<p class="help-block">A valid email address</p>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password" value='<?= set_value('password') ?>'>
					<span><?= form_error('password', '<span style="color:red;" class="label">', '</span>'); ?></span>
					<p class="help-block">At least 6 characters</p>
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirm password</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password" value='<?= set_value('password_confirm') ?>'>
					<span><?= form_error('password_confirm', '<span style="color:red;" class="label">', '</span>'); ?></span>
					<p class="help-block">Must match your password</p>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary btn-lg col-sm-6" value="Register">
					<input type="reset" class="btn btn-danger btn-lg col-sm-6" value="Reset Form">
				</div>
			</form>

		</div>
	</div><!-- .row -->
</div><!-- .container -->