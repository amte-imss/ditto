<?php
if(isset($output)){
    foreach($output->css_files as $file): 
?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php 
    endforeach; 
?>

<?php 
    foreach($output->js_files as $file): 
?>
    <script src="<?php echo $file; ?>"></script>
<?php 
    endforeach; 
}
?>

<div id="page-inner">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="table table-container-fluid panel">
            <?php 
            if(isset($output)){
                echo $output->output;
            }
            ?>
        </div>
    </div>
</div>