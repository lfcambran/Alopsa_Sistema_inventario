<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])){
    header("Location: login.html");
}else{
    require 'header.php';
    
    if($_SESSION['dashboard']==1){
        ?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- -->
                </div>
            </div>
        </div>
    </section>
</div>
        <?php
    }else{
    require 'noacceso.php';
    }
    require 'footer.php';
    ?>
<script src="scripts/dashboard.js"></script>
<?php    
}
ob_end_flush();
?>
