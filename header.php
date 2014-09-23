<title>WellTrail Pathfinder System v1.0 BETA</title>
<style type="text/css">
#logo {
    text-align: left;
    float: left;
    width: 48%;
}
#nome {
    text-align: right;
    vertical-align: top;
    float: left;
    width: 45%;
    height: 59px;
    line-height: 59px;
    color: #A0CC51;
    font-weight: bold;
}
#nome img {
    margin-right: 10px;
}
#header {
    width: 100%;
    float: left;
}
</style>


<div id="header">
    <div id="logo">
        <a href="adash.php" border="0">  <img src="img/logo.jpg" /></a>
    </div>
    <div id="nome">
      
         <?php
                 if ($_SESSION['uname']<>"") {
            ?>
        <img src="img/ico_user.jpg" />  
     <?php  echo $obj->decode($_SESSION['uname']); ?>
       <?php
        }
        ?> 
    </div>

</div>