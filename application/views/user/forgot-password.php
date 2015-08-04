

<div class="container">
	<div class="row">

		<div class="col-md-12">
			<div class="page-header">
				<h1>We will send you a temporary password</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="email">Your Email</label>
					<input type="text" class="form-control" id="email" name="email" placeholder="Your email" value='<?= set_value('email') ?>'>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default btn-lg" value="Send">
				</div>
			</form>
		</div>

	</div><!-- .row -->
</div><!-- .container -->