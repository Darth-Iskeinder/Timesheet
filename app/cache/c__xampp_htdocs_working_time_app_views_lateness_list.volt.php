<?= $this->getContent() ?>
<div class=container>
<ul class="pager">
        <li class="previous pull-left">
            <?= $this->tag->linkTo(['lateness/index', 'Go Back']) ?>
        </li>
    </ul>

<h1>List of lateness by user</h2>

<table>

  <?php foreach ($userLateness as $userLate) { ?>
  <tr>
      <td><?= $userLate->lateness ?> </td>
        <td width="7%">
          <?= $this->tag->linkTo(['lateness/delete/' . $userLate->id, 'Delete']) ?>
        </td>
  </tr>
    <?php } ?>
 </table>

</div>