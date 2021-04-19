<?= $this->getContent() ?>
<div class=container><?php if (empty($logged_in)) { ?><?= $this->tag->linkTo(['session/logout', 'Logout', 'class' => 'btn btn-primary btn-lg']) ?>
    <?php } ?>
<h1>Welcome to admin panel</h2>
<?= $this->tag->linkTo(['user/create/', 'Create new user']) ?>
<br>
<br>
<?= $this->tag->linkTo(['time/create', 'Create time for user']) ?>
<br>
<br>
<?= $this->tag->linkTo(['holiday/create/', 'Create new holiday']) ?>
<?php foreach ($users as $user) { ?>

<table>
    <tr>
        <td><?= $user->name ?></td>
        <td width="7%">
            <?= $this->tag->linkTo(['time/index/' . $user->id, 'User times']) ?>
        </td>
                <td width="7%">
                </td>
        <td width="7%">
            <?= $this->tag->linkTo(['user/update/' . $user->id, 'Edit']) ?>
        </td>
        <td width="7%">
            <?= $this->tag->linkTo(['user/delete/' . $user->id, 'Deactivate']) ?>
        </td>
        <td width="7%">
             <?php foreach ($userTime as $time) { ?>
                <?php if ($user->id == $time->userId) { ?>
                    <?= $time->startTime ?>
<!--                     <?php if ($time->year == $year) { ?> -->
<!--                         <?php if ($time->month == $month) { ?> -->
<!--                             <?php if ($time->day == $day) { ?> -->
<!--                                 <?= $time->startTime ?> -->
<!--                             <?php } ?> -->
<!--                         <?php } ?> -->
<!--                     <?php } ?> -->
                <?php } ?>
             <?php } ?>
        </td>

    </tr>
</table>
<?php } ?>
</div>
