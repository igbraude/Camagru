<?php

class Images {
    public $image_id;
    public $username;
    public $date_img;
    public $like;
    public $dislike;
    public $path;
    public $private;

    public $table_var = array("image_id", "username", "date_img", "like", "dislike", "private");

    public $table = "image";

    public function __construct($id = null, $username, $path, $like, $dislike, $private) {
        $this->id = $id;
        $this->username = $username;
        $this->date_img = date("Y-m-d H:i:s");
        $this->path = $path;
        $this->like = $like;
        $this->dislike = $dislike;
        $this->private = $private;

    }

    public function addInDatabase() {
        include("../config.php");
        $query = sprintf("INSERT INTO `image` (`username`, `date_img`, `like`, `dislike`, `path`, `private`)
        VALUE (
            '%s', '%s', '%d', '%d', '%s', '%s')", $this->username, $this->date_img, $this->like, $this->dislike, $this->path, $this->private);
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $this->id = $conn->lastInsertId();
    }

    public function displayImages() {
        include("../config.php");
        if ($_SESSION['username'] == $this->username) {
            echo '<form class="images" method="post">';
            echo '<input type="hidden" name="img_id" value="'. $this->id .'">';
            echo '<input type="hidden" name="imgPath" value="'. $this->path .'">';
            echo '<input type="hidden" name="action" value="">';
            echo '<div class="content"> <a href="http://localhost:8008/Archive/loginSystem/user_session/showCommentary.php" class="showImage"><img name="imgPath" src="'.$this->path.'" alt="'.$this->id.'" height="250" width="250"></a>';
            echo '<a href="#" class="img-delete">delete</a></div>';
            echo '</form>';
        }
    }

    public function deleteImages() {

    }

    public function upgradeImageData() {

    }

}

include('../config.php');

if(isset($_POST['addImage'])) {
    $img = new Images(0, $_SESSION['username'],$_POST['imagePath'], 0, 0, 'N');
    $img->addInDatabase();
}
?>