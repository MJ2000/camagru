<?php

    // Load the stamp and the photo to apply the watermark to
    $im = imagecreatefromjpeg("image.png");

    // First we create our stamp image manually from GD
    $stamp = imagecreatefrompng("image2.png");

    // Set the margins for the stamp and get the height/width of the stamp image
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    // Merge the stamp onto our photo with an opacity of 50%
    imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);

    // Save the image to file and free memory
    imagepng($im, 'image.png');
    imagedestroy($im);