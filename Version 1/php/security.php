<?php

if(!isset($_SESSION['auth'])){
    header('location: ../membres/login');
}