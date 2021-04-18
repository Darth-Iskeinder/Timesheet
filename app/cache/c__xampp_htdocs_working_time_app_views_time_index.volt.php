<?= $this->getContent() ?>
<div class=container>
<ul class="pager">
        <li class="previous pull-left">
            <?= $this->tag->linkTo(['user/index', 'Go Back']) ?>
        </li>
    </ul>
<select id="selectvalue">

<option value="all">All</option>
<option value="1">January</option>
<option value="2">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
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
    $('#selectvalue').change(function(){
        var month = $(this).children("option:selected").val();
            $.ajax({
                 type: 'POST',
                 url: '/working_time/time/sortUserData',
                 datatype: 'json',
                 data: {'month' : month},
                 success: function(data){
                    console.log(month);
                    $('#test').html(data);
                 }
            })
    });
</script>