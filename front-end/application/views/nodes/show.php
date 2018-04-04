<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">NODES</th>
      <th scope="col">address</th>
      <th scope="col">name</th>
      <th scope="col">online</th>
    </tr>
  </thead>
  <?php foreach($nodes_data as $row): ?>
  <tbody>
    <tr class="table-active">
      <th scope="row">Node</th>
      <td><?php echo $row['address'] ?></td>
      <td><?php echo $row['name'] ?></td>
      <td><?php echo $row['online'] ?></td>
      <td>
        <?php echo form_open('/nodes/delete/'.$row['id']); ?>
        <button type="submit" name="delete" value="delete" class="btn btn-primary btn-sm">delete</button>
        </form>
        <?php echo form_open('/nodes/edit/'.$row['id']); ?>
        <button type="submit" name="delete" value="delete" class="btn btn-primary btn-sm">edit</button>
        </form>
      </td>
    </tr>
  </tbody>
  <?php endforeach; ?>
</table> 
</form>  

        

