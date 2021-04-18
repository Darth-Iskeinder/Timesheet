<!-- <?= $this->getContent() ?> -->

<div class="jumbotron" id="overview">
    <div class="container-fluid">
        <h1 class="display-3">Welcome to Timesheet!</h1>
        <p class="lead">This is a timesheet platform</p>

        <div align="right"><?php if (empty($logged_in)) { ?><?= $this->tag->linkTo(['session/login', '<span class="oi oi-check" aria-hidden="true"></span> Login', 'class' => 'btn btn-primary btn-lg']) ?>
        <?php } else { ?>
            <?= $this->tag->linkTo(['users', '<span class="oi oi-account-login" aria-hidden="true"></span> Enter User Panel', 'class' => 'btn btn-primary btn-lg']) ?>
        <?php } ?>
        </div>
    </div>
</div>
