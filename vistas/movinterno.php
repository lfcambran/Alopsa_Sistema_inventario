<?php

ob_start();
session_start();
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
   ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <img src="../files/server/construccion.png" width="100%" height="500px"  alt=""/>
            </div>
        </div>
    </section>
</div>
<?php
}
require 'footer.php';
ob_end_flush();

