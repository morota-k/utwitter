<div id="my_profile_edit">
<div class="container">
<div class="main_wrapper">
<div class="left_container">
	<div class="my_profile_mypage">
		<div class="my_profile_user_mypage">
		<form action="./profile_controller.php" method="post">
				<input type="hidden" name="action_id" value="profile_edit_complete">
			<div class="my_profile_image_mypage">
				<img src='<?php echo $login_user_info['user_profile_photo'] ?>'>
			</div>
				<p>ユーザー名</p>
				<input type="text" name="edit_user_name" value="<?php echo $login_user_info['user_name'] ?>" placeholder="ユーザー名を入力してください"><br>
				<p>ユーザID</p><?php echo $login_id ?>
				<p>プロフィール</p>
				<textarea name="edit_user_prifole" rows="7" cols="40" placeholder="プロフィールを入力してください"><?php echo $login_user_info['user_profile'] ?></textarea><br>
			<div class="my_profile_user_date_mypage">
				登録日時<?php echo date('Y-m-d', strtotime($login_user_info['user_date'])); ?>
			</div>
			<div class="btn_profile_edit_mypage">
				<input type="submit" value="変更を保存">
			</div>
		</form>
		</div>
</div>
</div>


<div class="right_container">
<div id="all_timeline">
<h3>うつぶやき</h3>
<?php foreach($my_time_line as $post) { ?>
	<div class="my_post">
		<?php echo $my_profile['user_name'] ?>&nbsp;
		<?php echo $user_profile_id ?><br>
		<?php echo $post['post_body']; ?><br>
		<?php echo $post['post_date'] ?>
	</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>