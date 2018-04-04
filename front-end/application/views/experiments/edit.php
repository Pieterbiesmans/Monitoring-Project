<?php echo validation_errors(); ?>

<?php echo form_open('experiments/update'); ?>
    <legend>Add Nodes</legend>
    <input type="hidden"  name="id" value="<?php echo $experiment['id'];?>">
    <div>
        <label>server ip</label>
        <input type="text" class="form-control" name="server" value="<?php echo $experiment['server'];?>"> 
    </div>   
    <div>    
        <label>client ip</label>
        <input type="text" class="form-control" name="client" value="<?php echo $experiment['client'];?>">
    </div>
    <div>    
        <label>Done</label>
        <input type="text" class="form-control" name="done" value="<?php echo $experiment['done'];?>">
    </div>
    <div>    
        <label>config</label>
        <input type="text" class="form-control" name="config" value="<?php echo $experiment['config'];?>">
    </div>
    <div>    
        <label>repeat</label>
        <input type="text" class="form-control" name="repeat" value="<?php echo $experiment['rep'];?>">
    </div>
</br>
    <button type="submit" name="insert" value="insert" class="btn btn-primary">Submit</button>
</form>