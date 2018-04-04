<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Experiments</th>
      <th scope="col">created</th>
      <th scope="col">server</th>
      <th scope="col">client</th>
      <th scope="col">done</th>
      <th scope="col">config</th>
      <th scope="col">repeat</th>
    </tr>
  </thead>
  <?php foreach($experiments_data as $row): ?>
  <tbody>
    <tr class="table-active">
      <th scope="row">Experiment</th>
      <td><?php echo $row['created'] ?></td>
      <td><?php echo $row['server'] ?></td>
      <td><?php echo $row['client'] ?></td>
      <td><?php echo $row['done'] ?></td>
      <td><?php echo $row['config'] ?></td>
      <td><?php echo $row['rep'] ?></td>
      <td>
        <?php echo form_open('/experiments/delete/'.$row['id']); ?>
        <button type="submit" name="delete" value="delete" class="btn btn-primary btn-sm">delete</button>
        </form>
        <?php echo form_open('/experiments/edit/'.$row['id']); ?>
        <button type="submit" name="delete" value="delete" class="btn btn-primary btn-sm">edit</button>
        </form>
      </td>
    </tr>
  </tbody>
  <?php endforeach; ?>
</table> 
</form>  