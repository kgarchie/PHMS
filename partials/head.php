<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php $errors = array(); ?>
<?php $successes = array(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link href="/assets/images/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <title>SFH</title>
</head>
<style>
    :root {
        --accent: #ffbade;
    }

    .heading {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }

    .delete {
        background-color: transparent;
        border: none;
        cursor: pointer;
        right: 1rem;
        top: 1rem;
    }

    .custom-toast {
        position: absolute;
        z-index: 1200;
        right: 1rem;
        bottom: 1rem;
        transition: opacity 1s;
        color: white;
        padding: 1rem;
        border-radius: 5px;
        display: flex;
        height: 20px;
        max-width: 80vw;
        align-items: center;
    }

    .is-success {
        background-color: #46f196;
    }

    .icon {
        width: 1.5rem;
        height: 1.5rem;

        fill: white;
        margin-right: 0.25rem;
    }

    .delete {
        background-color: transparent;
        border: none;
        cursor: pointer;
        right: 1rem;
        top: 1rem;
    }

    .custom-toast {
        position: absolute;
        z-index: 1200;
        right: 1rem;
        bottom: 1rem;
        transition: opacity 1s;
        color: white;
        padding: 1rem;
        border-radius: 5px;
        display: flex;
        height: 20px;
        max-width: 80vw;
        align-items: center;
    }

    .is-danger {
        background-color: #f14668;
    }

    .icon {
        width: 1.5rem;
        height: 1.5rem;

        fill: white;
        margin-right: 0.25rem;
    }
</style>