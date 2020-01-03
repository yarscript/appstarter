<div class="content">

	<!--		<div class="homePanel">-->
	<!--			<h1>Homepage</h1>-->
	<!--			<div class="homeMenu">-->
	<!--				<h4>Menu</h4>-->
	<!--				<p>Hello, !</p>-->
	<!--				<form action="logout" method="post">-->
	<!--					<input type="submit" value="logout" class="submit button">-->
	<!--				</form>-->
	<!--				<form action="topic" method="post">-->
	<!--					<input type="submit" value="Add new topic" class="submit button">-->
	<!--				</form>-->
	<!--			</div>-->
	<!--		</div>-->


	<div class="homePanel">
		<h1>Homepage</h1>
		<div class="homeMenu">
			<h4>Menu</h4>
			<p>Hello, <?php echo $username; ?>!</p>
			<?php if ($logged) { ?>
			<form action="account/logout" method="post">
			<div><input type="submit" value="Logout" class="submit" name="logout"></div>
			</form>
			<?php } else { ?>
			<form action="/login" method="post">
			<div><input type="submit" value="Login" class="submit"></div>
			</form>
			<br>
			<form action="/register" method="post">
			<div><input type="submit" value="Register" class="submit"></div>
			</form>
			<?php  } ?>
		</div>
	</div>
	<div class="topicContainer">
		<div class="topicBlock" id="">
			<h2></h2>
			<p></p>
			<hr class="line">
			<form method="post" action="comment/getComments?post_id=" id="displayCommentsButton">
				<input type="button" value="Show comments" class="homeCommentSubmit">
			</form>
			<div class="homeCommentDiv"></div>

			<div id="homeCommentDiv" style="display: none">
				<hr class="line">
				<br>
				Add Comment
				<form method="post" class="homeCommentForm"
					  action="comment/addComment?post_id=&user_id=&author=">
					<input type="text" name="comment" id="" class="commentInput">
					<input type="button" class="homeCommentSubmit" value="Submit">
				</form>
			</div>
		</div>
	</div>
</div>

