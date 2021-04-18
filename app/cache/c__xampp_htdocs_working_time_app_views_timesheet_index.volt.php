<?= $this->getContent() ?>
<div class=container><?php if (empty($logged_in)) { ?><?= $this->tag->linkTo(['session/logout', 'Logout', 'class' => 'btn btn-primary btn-lg']) ?>
    <?php } ?>

    <?= $this->tag->linkTo(['user/changePassword', 'Change password', 'class' => 'btn btn-primary btn-lg']) ?>
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

<h2>My working Hours</h2>
<div>
    You have: <p>76</p>
    You have/Assigned: <p>43.6%</p>
    Assigned: <p>176</p>
    <strong>На работе необходимо быть до 9:00</strong>
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
        <?php foreach ($users as $user) { ?>
            <th scope="row"><?= $user->name ?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>

            <?php foreach ($days as $day => $weekDay) { ?>
                 <tr>
                    <td>
                    <?= $day ?>
                    </td>
<!--                     <td> -->
                    <?php foreach ($users as $user) { ?>
                        <?php foreach ($user->workTime as $userTime) { ?>

                            <?php if ($day == $userTime->day) { ?>
                                <td>
                                    <div>
                                    <?= $userTime->startTime ?>
                                    </div>
                                </td>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
<!--                     </td> -->
                </tr>
            <?php } ?>
    </tbody>
</table>

</div>
<?= $this->tag->endform() ?>

<script>
$( document ).ready(function() {
    $("#EndTime").css("display", "none");
});

    $('#StartTime').on('click', function(){
        $(this).hide();
        $('#EndTime').show();
            $.ajax({
            type:'POST',
            url: 'createStart',
            datatype: 'json',
            success: function(data){
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