<?php
include("./formPost/Post.showCommentaries.php");
include("../function/databaseRequest.php");


dislike_data();
?>

<!DOCTYPE html>

<html>
<body>

<p>you not no longer like this photo !!</p>
<form method="get" class="dislikeForm">
<div id="likeNdislike">
<input type="hidden" id="imgPath" name="imgPath" value="<?php echo $_POST['imgPath']; ?>">
<input type="hidden" id="img_id" name="img_id" value="<?php echo $_POST['img_id']; ?>">
<button type="button" name="like" onclick="likeButton()">like</button>
</div>
</form>


</body>
</html>