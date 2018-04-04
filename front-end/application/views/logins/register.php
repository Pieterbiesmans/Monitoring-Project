<html>
    <head>

        <title>Register</title>
       <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
    </head>
    <body>
        <div>
            <?php echo form_open('logins/register'); ?>
                <legend>Register</legend>
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