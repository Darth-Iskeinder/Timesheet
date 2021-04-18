<h2>Login form</h2>

<?php echo $this->tag->form("login/login"); ?>
<form>
<div class="form-group">
    <label for="name">Имя</label>
    <?php echo $this->tag->textField([
            'name',
            'class' => 'form-control',
            'placeholder' => 'Enter full name'
    ]); ?>
</div>

<div class="form-group">
    <label for="email">E-Mail</label>
    <?php echo $this->tag->emailField([
            "email",
            'class' => 'form-control',
            'placeholder' => 'Enter email'
    ]); ?>
</div>

<div class="form-group">
    <?php echo $this->tag->submitButton([
            "Login",
            "class" => "btn btn-primary"]); ?>
</div>

</form>