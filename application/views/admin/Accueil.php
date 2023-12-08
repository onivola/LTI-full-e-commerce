<!DOCTYPE html>
<html>
    <head>
        <title>Lite Tech Info</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_general.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style_admin.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/jquery-3.3.1.slim.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome-free-5.11.2-web/css/all.css">
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/popper.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/script_admin.js"></script>
        
    </head>
    <body>
        <!--MENU 1-->
        <?php $this->view("admin/include/navmenu.php"); ?>
        <!--MENU 2-->
        <section id="sct_component"><!--component-->
            <div>
                <h3>AJOUT CATEGORIE</h3>
                <form>
                    <div class="form-group">
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            </div>
                <h3>AJOUT PRODUIT</h3>
                <form>
                    <div class="form-group">
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </section>
            <div style="height:1000px">
                   
            </div>
    </body>
</html>