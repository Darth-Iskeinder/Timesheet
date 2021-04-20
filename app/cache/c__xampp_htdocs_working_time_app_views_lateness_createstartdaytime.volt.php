<?= $this->getContent() ?>
<div class=container>
<ul class="pager">
        <li class="previous pull-left">
            <?= $this->tag->linkTo(['user/index', 'Go Back']) ?>
        </li>
    </ul>
<div class="page-header">
    <h3>Create start time for day</h3>
</div>
<?= $this->tag->form(['lateness/createStartDayTime']) ?>

    <fieldset>

            <?php foreach ($form as $element) { ?>
                <div class='control-group'>
                    <?= $element->label(['class' => 'control-label']) ?>

                    <div class='controls'>
                        <?= $element ?>
                    </div>
                </div>
            <?php } ?>



            <div class='control-group'>
                <?= $this->tag->submitButton(['Save', 'class' => 'btn btn-primary']) ?>
            </div>

        </fieldset>
    </div>
<?= $this->tag->endform() ?>