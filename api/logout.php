<?php

require_once __DIR__ . '/../app/functions.php';

session_destroy();
session_start();
setFlash('success', 'You have been logged out.');
redirect('/login.php');
