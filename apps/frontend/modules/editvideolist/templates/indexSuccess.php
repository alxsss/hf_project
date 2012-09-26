<h1>Editvideolist List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Videolist</th>
      <th>Ytvideo</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($videolist_ytvideo_list as $videolist_ytvideo): ?>
    <tr>
      <td><a href="<?php echo url_for('editvideolist/edit?id='.$videolist_ytvideo->getId()) ?>"><?php echo $videolist_ytvideo->getId() ?></a></td>
      <td><?php echo $videolist_ytvideo->getVideolistId() ?></td>
      <td><?php echo $videolist_ytvideo->getYtvideoId() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('editvideolist/new') ?>">New</a>
