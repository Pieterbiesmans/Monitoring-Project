<?php echo validation_errors(); ?>

<?php echo form_open('experiments/create'); ?>
    <legend>Add Nodes</legend>
    <div>
        <label>server ip</label>
        <input type="text" class="form-control" name="server">
    </div>   
    <div>    
        <label>client ip</label>
        <input type="text" class="form-control" name="client">
    </div>
    <div>    
        <label>Done</label>
        <input type="text" class="form-control" name="done">
    </div>
    <div>    
        <label>config</label>
        <input type="text" class="form-control" name="config">
    </div>
    <div>    
        <label>repeat</label>
        <input type="text" class="form-control" name="repeat">
    </div>
</br>
    <button type="submit" name="insert" value="insert" class="btn btn-primary">Submit</button>
</form>