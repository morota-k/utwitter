	<div id="userList">
	<div class="userlist_title">
		<h3>ユーザ一覧</h3>
	</div>
	<?php foreach($user_list as $user) { ?>
		<div class="user_profile">
			<form action="./main_controller.php" method="post">
				<div class="user_profile_image">
				<img src= "<?php echo $user['user_profile_photo']; ?>" >
				</div>
				<div class="user_profile_info">
				<input type="hidden" name="follower_user_id" value="<?php echo $user['user_id']; ?>">
				<a href="./profile_controller.php?action_id=profile&user_profile_id=<?php echo $user['user_id']; ?>"><?php echo $user['user_id']; ?></a>&nbsp;
				<?php echo $user['user_name']?><br>
				<?php echo $user['user_profile']; ?><br>
				<?php if (in_array($user['user_id'], $my_follow_list) === false) { ?>
					<input type="hidden" name="action_id" value="follow">
					<input type="submit" value="ふぉろー">
				<?php } else { ?>
					<input type="hidden" name="action_id" value="unfollow">
					<input type="submit" value="さよなら">
				<?php } ?>
				</div>
			</form>
		</div>
	<?php } ?>
	</div>
</div>