<?php

class commentary {

    // variables of commentary tables columns
    public $id;
    public $username;
    public $dataTime;
    public $image_id;
    public $text;

    // array
    public $table_var = array("commentary_id", "username", "message", "dataTime", "image_id");
    
    //table name
    public $table = "commentary";
    
    public function __construct ($message, $username, $img_id, $id = null) {
        $this->text = $message;
        $this->username = $username;
        $this->dateTime = date("Y-m-d H:i:s");
        $this->image_id = $img_id;
        $this->id = $id;
    }

    public function __toString() {
        return($this->text);
    }

    // Add commentary

    public function addInDatabase() {
        include("../config.php");
        $query = sprintf( "INSERT INTO commentary (username, date_comm, image_id, `message`)
        VALUES ('%s', '%s', '%d', '%s')", $this->username, $this->dateTime, $this->image_id, $this->text);
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $this->id = $conn->lastInsertId();
    }

    // Upgrade commentary

    public function upgradeCommentary() {
        include("../config.php");
        $query = sprintf("UPDATE `commentary` SET `message`='%s' WHERE commentary_id=%d",$_POST['content'], $_POST['id']);
        $stmt = $conn->prepare($query);
        $stmt->execute();
    }

    // Delete commentary ne sert a rien pour l'instant dans class commentaire, util->showCommentary.php

    public function deleteCommentary() {
        if (isset($_POST['deleteCommentary'])) {
            include("../config.php");
            $query = sprintf("DELETE FROM `commentary` WHERE `commentary_id`=%d", $_POST['deleteCommentary']);
            $stmt = $conn->prepare($query);
            $stmt->execute();
        }
    }

    public function displayCommentaries() {
        include("../config.php");
        if ($_SESSION['username'] == $this->username) {
            echo '<form class="comment" method="post">';
            echo '<input type="hidden" name="id" value="'. $this->id .'">';
            echo '<input type="hidden" name="action" value="">';
            echo '<div class="content"><p>'.$this->text.'</p>';
            echo '<a href="#" class="comment-delete">delete</a> | ';
            echo '<a href="#" class="comment-edit">edit</a></div>';
            echo '</form>';
        }
        echo "<br>";
    }
}

include('../config.php');

if(isset($_POST['postCommentary'])) {
    $com = new commentary($_POST['commentaryField'], $_SESSION['username'], $_SESSION['image_id']);
    $com->addInDatabase();
}

if(isset($_POST['upgradeCommentary'])) {
    include("../config.php");
    $query = sprintf("UPDATE FROM `commentary` WHERE `commentary_id`=%d", $_POST['commentary']);
    $stmt = $conn->prepare($query);
    $stmt->execute();
}

/*foreach(array_keys($_POST) as $session) {
    echo $session . "<br>";
}*/

?>