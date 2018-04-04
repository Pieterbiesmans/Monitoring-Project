<?php echo validation_errors(); ?>

<?php echo form_open('nodes/update'); ?>
    <legend>Add Nodes</legend>
    <input type="hidden"  name="id" value="<?php echo $node['id'];?>">
    <div>
        <label>Enter Username</label>
        <input type="text" class="form-control" name="name" value="<?php echo $node['name'];?>">
    </div>   
    <div>    
        <label>Password</label>
        <input type="text" class="form-control" name="address" value="<?php echo $node['address'];?>">
    </div>
</br>
    <button type="submit" name="save_user" value="insert" class="btn btn-primary">Save</button>
</form>