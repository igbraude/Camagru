<?php
include("./formPost/Post.showCommentaries.php");
include("../function/databaseRequest.php");


like_data();
?>

<!DOCTYPE html>

<html>
<body>

<p>you liked this photo !!</p>
<form method="get" class="dislikeForm">
<div id="likeNdislike">
<input type="hidden" id="imgPath" name="imgPath" value="<?php echo $_POST['imgPath']; ?>">
<input type="hidden" id="img_id" name="img_id" value="<?php echo $_POST['img_id']; ?>">
<button type="button" name="dislike" id="dislikeBut" onclick="dislikeButton()">Dislike</button>
</div>
</form>


</body>
</html>