<?php
/**
 * @var $model ContactForm
 */
?>
<html>
<body>
    Name: <?php echo $model->name; ?><br/>
    Email: <?php echo $model->email; ?><br/>
    Subject: <?php echo $model->getSubjectName(); ?><br/>
    Message: <?php echo $model->message; ?><br/>
</body>
</html>
