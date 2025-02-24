<?php
// Include necessary configurations or session start
include('config.php');

$galleryImages = isset($galleryImages) ? $galleryImages : []; // Retrieve gallery images array

if (!empty($galleryImages)) {
    $zip = new ZipArchive();
    $zipFileName = 'gallery_images.zip';

    // Create a temporary ZIP file
    if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
        foreach ($galleryImages as $image) {
            $filePath = 'uploads/' . trim($image); // Path to images
            if (file_exists($filePath)) {
                $zip->addFile($filePath, basename($filePath)); // Add file to ZIP
            }
        }
        $zip->close();

        // Set headers to download the ZIP
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zipFileName);
        header('Content-Length: ' . filesize($zipFileName));
        readfile($zipFileName);

        // Delete the temporary ZIP file after download
        unlink($zipFileName);
        exit;
    } else {
        echo "Failed to create ZIP file.";
    }
} else {
    echo "No gallery images available to download.";
}
?>
