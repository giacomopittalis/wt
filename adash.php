<?php// DASHBOARD OF THE SITE// must be developed the Activity Feed featuresession_start();error_reporting(E_ALL);ini_set('display_errors', 1);include 'sessionclass.php';$obj = new session;$seadmin = $obj->seadmin();?><!DOCTYPE html>    <html class="no-js" lang="en">    <head>        <meta charset="utf-8" />        <meta name="viewport" content="width=device-width" />        <title>Wellness - Admin Dashboard</title>        <link rel="stylesheet" href="stylesheets/foundation.min.css">        <link rel="stylesheet" href="style-G.css"><!--        <link rel="stylesheet" href="stylesheets/app.css">-->        <script src="javascripts/modernizr.foundation.js"></script>    </head>    <body>        <?php include('header.php'); ?>         <script src="javascripts/foundation.min.js"></script>        <script src="javascripts/app.js"></script>                         <div class="left-column">            <?php include "inc_left_column.php" ?>        </div>        <div class="right-column">            <div id="activity-feed">                                    <img src="img/fac_activity.gif">                            </div>                    </div>    </body></html>