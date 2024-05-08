<?php
$files = scandir("uploads/");
foreach($files as $file) {
    if ($file != "." && $file != "..") {
        echo "<li><a href='uploads/$file' download>$file</a></li>";
    }
}
?>
