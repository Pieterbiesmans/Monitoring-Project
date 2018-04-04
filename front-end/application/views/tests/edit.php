<?php echo validation_errors(); ?>

<?php echo form_open('tests/update'); ?>
    <legend>Add Test</legend>
    <input type="hidden"  name="id" value="<?php echo $test['id'];?>">
    <div>
        <label>Name of test</label>
        <input type="text" class="form-control" name="test" value="<?php echo $test['test'];?>">
    </div>   
</br>
    <button type="submit" name="insert" value="insert" class="btn btn-primary">Submit</button>
</form>