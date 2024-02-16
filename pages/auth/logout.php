<?php
if(!isAuthenticated()){
    redirect('auth/login');
}

if(isset($_COOKIE['user'])){
    setcookie('user', '', time() - 3600);
}

redirect('auth/login');
?>