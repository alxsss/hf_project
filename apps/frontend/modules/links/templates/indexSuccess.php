<h1>Links List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>User</th>
      <th>Status text</th>
      <th>Num comment</th>
      <th>Img</th>
      <th>Url</th>
      <th>Title</th>
      <th>Description</th>
      <th>Created at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($user_link_list as $user_link): ?>
    <tr>
      <td><a href="<?php echo url_for('links/edit?id='.$user_link->getId()) ?>"><?php echo $user_link->getId() ?></a></td>
      <td><?php echo $user_link->getUserId() ?></td>
      <td><?php echo $user_link->getStatusText() ?></td>
      <td><?php echo $user_link->getNumComment() ?></td>
      <td><?php echo $user_link->getImg() ?></td>
      <td><?php echo $user_link->getUrl() ?></td>
      <td><?php echo $user_link->getTitle() ?></td>
      <td><?php echo $user_link->getDescription() ?></td>
      <td><?php echo $user_link->getCreatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('links/new') ?>">New</a>
