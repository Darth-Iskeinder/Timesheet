
<?= $this->getContent() ?>
<div class=container>
<div class="page-header">
    <h3>Log In</h3>
</div>
<?= $this->tag->form(['session/authorize', 'role' => 'form']) ?>
    <fieldset>
        <div class="form-group">
            <label for="email">Email</label>
            <div class="controls">
                <?= $this->tag->emailField(['email', 'class' => 'form-control']) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="controls">
                <?= $this->tag->passwordField(['password', 'class' => 'form-control']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= $this->tag->submitButton(['Login', 'class' => 'btn btn-primary btn-large']) ?>
        </div>
    </fieldset>
    </div>
<?= $this->tag->endform() ?>