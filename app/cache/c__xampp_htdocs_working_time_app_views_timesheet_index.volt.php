<?= $this->getContent() ?>
<div class=container><?php if (empty($logged_in)) { ?><?= $this->tag->linkTo(['session/logout', 'Logout', 'class' => 'btn btn-primary btn-lg']) ?>
    <?php } ?>

    <?= $this->tag->linkTo(['timesheet/changePassword', 'Change password', 'class' => 'btn btn-primary btn-lg']) ?>
<select id="select-month-users" selected="selected">
        <?php foreach ($months as $key => $month) { ?>
            <option value="<?= $key ?>"><?= $month ?></option>
        <?php } ?>
</select>
<select id="select-year-users">
        <?php foreach ($years as $key => $year) { ?>
            <option value="<?= $key ?>"><?= $year ?></option>
        <?php } ?>
</select>

<h2>My working Hours</h2>
<div>
    You have: <p>76</p>
    You have/Assigned: <p>43.6%</p>
    Assigned: <p>176</p>
    <strong>На работе необходимо быть до <?= $startDay ?></strong>
</div>
<table>
  <tr>
    <th>Current date</th>
    <th>Start time</th>
    <th>End time</th>
    <th>Total time</th>
  </tr>
  <tr>
      <th><?= $currentTime ?></th>
      <th id="start"></th>
      <th id="end"></th>
      <th>Country</th>
    </tr>
 </table>
 <input type="button" data-id="" class="btn btn-primary" value="Start time" id="StartTime">
 <input type="button" class="btn btn-primary" value="End time" id="EndTime">
<table class="table table-bordered">
    <thead>
    <tr>
    <td>
      Date
    </td>
    <td>

    </td>
        <?php foreach ($users as $user) { ?>
            <th scope="row"><?= $user->name ?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>

            <?php foreach ($days as $day => $date) { ?>

                     <tr>

                     <?php if ($this->isIncluded($date, $holidaysDate)) { ?>
                        <td style="background-color:#FF0000">
                        <?= $day ?>
                        <br>

                        </td>
                     <?php } else { ?>
                        <td style="background-color:#00FF00">
                            <?= $day ?>
                            <br>

                        </td>
                     <?php } ?>

                        <td>
                        <?php foreach ($users as $user) { ?>
                            <td>
                            <?php foreach ($workTime as $userTime) { ?>

                                <?php if ($day == $userTime->day && $userTime->userId == $user->id) { ?>

                                        <div>
                                        <?= $userTime->startTime ?>-<?= $userTime->endTime ?>

                                        </div>

                                <?php } ?>

                            <?php } ?>
                            </td>

                        <?php } ?>
                        </td>

                    </tr>

            <?php } ?>
    </tbody>
</table>

</div>
<?= $this->tag->endform() ?>

<script>
$( document ).ready(function() {
    $("#EndTime").css("display", "none");
    $('#select-month-users').val('<?= $getMonthUsers ?>').attr('selected', 'selected');
    $('#select-year-users').val('<?= $getYearUsers ?>').attr('selected', 'selected');
});

$('#select-month-users').change(function(){
    var monthUsers = $(this).val();
    console.log(monthUsers);
    var yearUsers = $('#select-year-users').val();
    location.assign('/working_time/timesheet/index?monthUsers='+monthUsers+ '&yearUsers='+yearUsers);
});

$('#select-year-users').change(function(){
    var yearUsers = $(this).val();
    console.log(yearUsers);
    var monthUsers = $('#select-month-users').val();
    location.assign('/working_time/timesheet/index?monthUsers='+monthUsers+ '&yearUsers='+yearUsers);
});

    $('#StartTime').on('click', function(){
        $(this).hide();
        $('#EndTime').show();
            $.ajax({
            type:'POST',
            url: 'createStart',
            datatype: 'json',
            success: function(data){
                console.log(data);
                var obj = JSON.parse(data);
                console.log(obj);
                $('#start').html(obj.time);
                $('#StartTime').attr('data-id', obj.userTimeId);
            }
        });
    });

    $('#EndTime').on('click', function(){
        $(this).hide();
        $('#StartTime').show();
        var startId = $('#StartTime').attr('data-id');
                $.ajax({
                type:'POST',
                url: 'createEnd',
                datatype: 'json',
                data: {'startId':startId},
                success: function(data){
                    $('#end').html(data);
                }
            });
        });




</script>
