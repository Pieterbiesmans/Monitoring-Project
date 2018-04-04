<?php echo validation_errors(); ?>

<?php echo form_open('nodes/create'); ?>
    <legend>Add Nodes</legend>
    <div>
        <label>Name of node</label>
        <input type="text" class="form-control" name="name">
    </div>   
    <div>    
        <label>ip Address</label>
        <input type="text" class="form-control" name="address">
    </div>
</br>
    <button type="submit" name="insert" value="insert" class="btn btn-primary">Submit</button>
</form>
