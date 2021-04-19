<?= $this->getContent() ?>
<div class=container>
<ul class="pager">
        <li class="previous pull-left">
            <?= $this->tag->linkTo(['user/index', 'Go Back']) ?>
        </li>
    </ul>
<select id="select-month" selected="selected">
        <?php foreach ($months as $key => $month) { ?>
            <option value="<?= $key ?>"><?= $month ?></option>
        <?php } ?>
</select>
<select id="select-year">
        <?php foreach ($years as $key => $year) { ?>
            <option value="<?= $key ?>"><?= $year ?></option>
        <?php } ?>
</select>

<h1>List of times by user</h2>

<th id="test"></th>
<table>
  <tr>
    <th>Start time</th>
    <th>End time</th>
    <th>Date</th>
    <th>Total time</th>
  </tr>
  <?php foreach ($userTimes as $userTime) { ?>
  <tr>
      <td><?= $userTime->startTime ?> </td>
      <td><?= $userTime->endTime ?></td>
      <td><?= $userTime->year ?>-<?= $userTime->month ?>-<?= $userTime->day ?></td>
      <td><?= $userTime->total ?></td>

        <td width="7%">
          <?= $this->tag->linkTo(['time/update/' . $userTime->id, 'Edit']) ?>
        </td>
  </tr>
    <?php } ?>
 </table>

</div>

<script>
$( document ).ready(function() {
    $('#select-month').val('<?= $getMonth ?>').attr('selected','selected');
    $('#select-year').val('<?= $getYear ?>').attr('selected','selected');
});
    $('#select-month').change(function(){
        var month = $(this).val();
        console.log(month);
        var year = $('#select-year').val();
          location.assign('/working_time/time/index/<?= $userId ?>?month='+month+ '&year='+year);
    });
    $('#select-year').change(function(){
            var month = $('#select-month').val();
            var year = $(this).val();
              location.assign('/working_time/time/index/<?= $userId ?>?month='+month + '&year='+year);
        });
</script>