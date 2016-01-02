<div id="all_timeline">
<h3>うついーと一覧</h3>
<?php foreach($all_time_line as $time_line) { ?>
	<div class="time_line">
		<div class="utweet_box">
		<div class="utweet_profile_image">
			<img src= "<?php echo $time_line['user_profile_photo']; ?>" >
		</div>
		<div class="utweet_info">
		<div class="utweet_user_top">
			<div class="utweet_user_id">
				<a href="./main_controller.php?action_id=profile&user_profile_id=<?php echo $time_line['user_id']; ?>"><?php echo $time_line['user_name']; ?></a>
			</div>
			<div class="utweet_user_name">
				@<?php echo $time_line['user_id'] ?>
			</div>
			<div class="utweet_date">
			<?php echo $time_line['post_date'] ?>
			</div>
		</div>
		<div class="utweet">
		<?php echo $time_line['post_body']; ?>
		</div>
		<div>
		<ul class="utweet_action">
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/comment.png">
		へんじする</li>
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/knife.png">
		うついね</li>
		<li>
		<img class="icon hvr-pulse" src="../include/img/parts/favorite.png">
		おきにいり</li>
		</ul>
		</div>
		</div>
		</div>
	</div>
<?php } ?>

