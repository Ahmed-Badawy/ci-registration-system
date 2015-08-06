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
				<h1>Login</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Your username" value='<?= set_value('username') ?>'>
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Your password" value='<?= set_value('password') ?>'>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Login">
					<a href="<?= base_url("forgot-pass") ?>" class="btn btn-info">Forgot Your Password ?</a>
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->