

<table class='table table-bordered table-striped'>
	<tr>
		<th>Name</th>
		<th>email</th>
		<th>avatar</th>
		<th>created_at</th>
		<th>last_login</th>
		<th>last_seen</th>
		<th>is_confirmed</th>
		<th>is_admin</th>
		<th>is_locked</th>
	</tr>

<?php foreach($all_users as $user): ?>
	<tr>
		<td><?= $user->username ?></td>
		<td><?= $user->email ?></td>
		<td><?= $user->avatar ?></td>
		<td><?= $user->created_at ?></td>
		<td><?= $user->last_login ?></td>
		<td><?= $user->last_seen ?></td>
		<td><?= $user->is_confirmed ?></td>
		<td><?= $user->is_admin ?></td>
		<td><?= $user->is_locked ?></td>
	</tr>
<?php endforeach; ?>

</table>