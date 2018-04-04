<?php echo validation_errors(); ?>

<?php echo form_open('tests/create'); ?>
    <legend>Add Test</legend>
    <div>
        <label>Name of test</label>
        <input type="text" class="form-control" name="test">
    </div>   
</br>
    <button type="submit" name="insert" value="insert" class="btn btn-primary">Submit</button>
</form>