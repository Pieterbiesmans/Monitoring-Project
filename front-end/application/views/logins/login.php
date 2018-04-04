<html>
    <head>
       <title>Login</title>
       <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
    </head>
    <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">ZOL</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-itemc">
        <a class="nav-link" href="<?php echo base_url();?>logins/register">Register<span class="sr-only">(current)</span></a>
      </li>
      </li>
    </ul>
  </div>
  </nav>
        <div class="container">
            <?php echo form_open('logins/login_validation'); ?>
                <legend>Login</legend>
                <div class="form-group">
                    <label>Enter Username</label>
                    <input type="text" class="form-control" name="username">
                    <span class="text-danger"><?php echo form_error('username'); ?></span>
                </div>   
                <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password">
                <span class="text-danger"><?php echo form_error('password'); ?></span>
                </div>
                </br>
                <button type="submit" name="insert" value="insert" class="btn btn-primary">Submit</button>
                <?php
                echo $this->session->flashdata("error");
                ?>
            </form> 
        </div>
    </body>
</html>