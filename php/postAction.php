<?php
 
require('php/config.php');

$date = time();
$id = uniqid();

// File upload
if (isset($_POST['submit'])) {

    $title = htmlspecialchars($_POST['title']);
    $quality = htmlspecialchars($_POST['quality']);
    $duration = htmlspecialchars($_POST['duration']);
    $maxsize = 1048576000; // 100MB in bytes
    if (empty($title)) {
        $title = date("d-m-Y");
    }
    if (!empty($title) && !empty($quality)) {
        if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])) {
            $posterExt = strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION)) ;
            $vidExt = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)) ;

            $name = time() . '_' . $title . "." . $vidExt;
            $poster = time() . '_' . $title . "." . $posterExt;
            $target_dir = "uploads/videos/";
            $target_file = $target_dir . $name;
            $poster_target = "uploads/posters/";
            $target_poster = $poster_target . $poster;
            if (isset($_FILES['poster']['name']) && !empty($_FILES['poster']['name'])) {
                // File extension
                $extention = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Valid file extensions 
                $extention_arr = array("mp4", "avi", "webm", "mov", "mpeg");

                // Check extension
                if (in_array($extention, $extention_arr)) {

                    // Check file size
                    if ($_FILES['file']['size'] <= $maxsize) {
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file) && move_uploaded_file($_FILES['poster']['tmp_name'], $target_poster)) {

                            // Insert record

                            $sql = $bdd->prepare('INSERT INTO video(id, titre, chemin, duration, quality, poster, id_auteur,date ) VALUES(?,?,?,?,?,?,?,?)');
                            if($sql->execute(array($id, $title, $target_file, $duration, $quality, $target_poster, $_SESSION['id'], $date))){
                                header('location: ./');
                            }else{
                                $_SESSION['message'] = "Erreur inconnue";
                            }

                            


                        }else {
                            $_SESSION['message'] = "Impossible d'importer votre video";
                        }
                    } else {
                        $_SESSION['message'] = "Video trop volumineuse";
                    }

                } else {
                    $_SESSION['message'] = "Extension invalide";
                }
            } elseif (isset($_POST['posterLnk']) && !empty($_POST['posterLnk'])) {
                $posterLink = htmlspecialchars($_POST['posterLnk']);
                // File extension
                $extention = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Valid file extensions 
                $extention_arr = array("mp4", "avi", "webm", "mov", "mpeg");

                // Check extension
                if (in_array($extention, $extention_arr)) {

                    // Check file size
                    if ($_FILES['file']['size'] <= $maxsize) {
                        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {

                            // Insert record
                            $sql = $bdd->prepare('INSERT INTO video(id, titre, chemin, duration, quality, poster, id_auteur,date ) VALUES(?,?,?,?,?,?,?,?)');
                            if($sql->execute(array($id, $title, $target_file, $duration, $quality, $posterLink, $_SESSION['id'],$date))){
                                header('location:./');
                            }else {
                                $_SESSION['message'] = "Erreur inconnue";
                            }
                            


                        }else {
                            $_SESSION['message'] = "Impossible d'importer votre video";
                        }
                    } else {
                        $_SESSION['message'] = "Video trop volumineuse";
                    }

                } else {
                    $_SESSION['message'] = "Extension invalide";
                }
            } else {
                $_SESSION['message'] = "Vous n'avez pas inserré une miniature";
            }

        } elseif (isset($_POST['Link']) && !empty($_POST['Link'])) {
            $link = htmlspecialchars($_POST['Link']);
            $poster = time() . '_' . $_FILES['poster']['name'];
            $poster_target = "uploads/posters/";
            $target_poster = $poster_target . $poster;
            if (isset($_FILES['poster']['name']) && !empty($_FILES['poster']['name'])) {
                if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_poster)) {

                    // Insert record

                    $sql = $bdd->prepare('INSERT INTO video(id, titre, chemin, duration, quality, poster, id_auteur,date ) VALUES(?,?,?,?,?,?,?,?)');
                    $sql->execute(array($id, $title, $link, $duration,$quality, $target_poster, $_SESSION['id'], $date));

                    header('location:./');

                }

            } elseif (isset($_POST['posterLnk']) && !empty($_POST['posterLnk'])) {
                $posterLink = htmlspecialchars($_POST['posterLnk']);

                // Insert record
                $sql = $bdd->prepare('INSERT INTO video(id, titre, chemin, duration, quality, poster, id_auteur,date ) VALUES(?,?,?,?,?,?,?,?)');
                $sql->execute(array($id, $title, $link, $duration, $quality, $posterLink, $_SESSION['id'], $date));

                header('location:./');

            } else {
                $_SESSION['message'] = "Vous n'avez pas inserré une miniature";
            }

        } else {
            $_SESSION['message'] = "Vous n'avez pas inserré de vidéo";
        }
    }
}