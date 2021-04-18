<!DOCTYPE html>
<html>
	<head>
		<title>Welcome to Timesheet</title>
                <meta charset="utf-8">
                 <!-- Viewport Meta Tag -->
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <!-- Bootstrap 4.1.1 -->
		<?= $this->tag->stylesheetLink('css/bootstrap.min.css') ?>
                <!-- Open-iconic fonts for bootstrap -->
                <?= $this->tag->stylesheetLink('css/open-iconic-bootstrap.css') ?>
                <?= $this->tag->stylesheetLink('css/style.css') ?>
                <?= $this->tag->javascriptInclude('js/jquery-3.3.1.min.js') ?>
                <?= $this->tag->javascriptInclude('js/bootstrap.bundle.min.js') ?>
	</head>
	<body>
		<?= $this->getContent() ?>

	</body>
</html>