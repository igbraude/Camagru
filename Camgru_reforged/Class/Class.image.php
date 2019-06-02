<?php

class Images {

        /* 
            DOC ==>

        This class image is made to SEARCH, INSERT, DELETE or DISPLAY image in database.
        An image is made with the webcam and upload 
        magic function --> 
                        __construct image we need :
                                         - client username
                                         - image in base 64, need to encode it
                                         - like ans dislike in the image
                                         - private or public image
        public function -->
                         addInDatabase :
                                         - Insert a new image in the database `Camagru`, in the table `image`
                         displayCommentary :
                                         - Display all the images.
                                         - Create a show image button and a delete button for the user, when clicking on it the user see the commentaries like and dislike of the image.
                                         - For the user, create a formulaire POST with 3 input, the image base64 encode, image id and action. 
    
        */

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
            echo '<div class="content"> <a href="./showCommentary.php" class="showImage"><img name="imgPath" src="'.$this->path.'" alt="'.$this->id.'" height="250" width="250"></a>';
            echo '<a href="#" class="img-delete">delete</a></div>';
            echo '</form>';
        }
    }

    public function deleteImages() {

    }

    public function upgradeImageData() {

    }

}