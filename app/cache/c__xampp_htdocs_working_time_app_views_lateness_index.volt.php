<?= $this->getContent() ?>
<div class=container>
<ul class="pager">
        <li class="previous pull-left">
            <?= $this->tag->linkTo(['user/index', 'Go Back']) ?>
        </li>
    </ul>
<h1>List of lateness</h2>
<?php foreach ($users as $user) { ?>

<table>
    <tr>
        <td><?= $user->name ?></td>
        <td width="7%">
            <?= $this->tag->linkTo(['lateness/list/' . $user->id, 'User lateness']) ?>
        </td>
    </tr>
</table>
<?php } ?>
</div>