<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Tests</th>
      <th scope="col">Test</th>
    </tr>
  </thead>
  <?php foreach($tests_data as $row): ?>
  <tbody>
    <tr class="table-active">
      <th scope="row">Test</th>
      <td><?php echo $row['test'] ?></td>
      <td>
        <?php echo form_open('/tests/delete/'.$row['id']); ?>
        <button type="submit" name="delete" value="delete" class="btn btn-primary btn-sm">delete</button>
        </form>
        <?php echo form_open('/tests/edit/'.$row['id']); ?>
        <button type="submit" name="delete" value="delete" class="btn btn-primary btn-sm">edit</button>
        </form>
      </td>
    </tr>
  </tbody>
  <?php endforeach; ?>
</table> 
</form>  