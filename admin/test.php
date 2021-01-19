<?php
    if(isset($_POST["uploadBtn"])) {
      //print_r($_FILES);
      echo $_FILES["uploadedFile"]["name"][0];
      if(!move_uploaded_file($_FILES['uploadedFile']['tmp_name'][0], '../uploads/' . $_FILES['uploadedFile']['name'])) 
        echo 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
    }
?>
<p><?php echo $_SESSION['message']; ?></p>
<form method="POST" action="test.php" enctype="multipart/form-data">
    <div class="upload-wrapper">
      <span class="file-name">Choose a file...</span>
      <label for="file-upload">Browse<input type="file" id="file-upload" name="uploadedFile[]"></label>
      <label for="file-upload">Browse<input type="file" id="file-upload" name="uploadedFile[]"></label>
    </div>
 
    <input type="submit" name="uploadBtn" value="Upload" />
  </form>