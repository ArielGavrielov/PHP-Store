<?php
include 'extra.php';
// configuration
$url = '../index.php';
$file = '../index.php';

// check if form has been submitted
if (isset($_POST['home']))
{
    // save the text contents
    file_put_contents($file, $_POST['home']);

    // redirect to form again
    header(sprintf('Location: %s', $url));
    printf('<a href="%s">Moved</a>.', htmlspecialchars($url));
    exit();
}

// read the textfile
$text = file_get_contents($file);

?>
<!-- HTML form -->
<form action="" method="post">
<div class="form-group">
    <label for="home">Home editor:</label>
    <textarea class="form-control" id="home" rows="20" name="home" style="font-family: Arial, Helvetica, sans-serif !important;"><?php echo htmlspecialchars($text) ?></textarea>
  </div>
<input type="submit" />
<input type="reset" />
</form>