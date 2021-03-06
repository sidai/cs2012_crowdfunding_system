<?php
date_default_timezone_set("Asia/Singapore");
require('functions/helpers.php');
require('classes/Database.php');
require('classes/Project.php');
require('classes/Category.php');
require('classes/Donation.php');
require('classes/User.php');
$gb_connection = new Database();

// simple router
$page = isset($_GET['_page']) ? $_GET['_page'] : 'home';

if (file_exists('pages/' . $page . '.php')) {
    require('pages/' . $page . '.php');
} else {
    require('pages/home.php');
}