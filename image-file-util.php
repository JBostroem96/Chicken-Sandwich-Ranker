<?php
require_once 'file-constants.php';


/**
 * This function's purpose is to validate the uploaded image file
 *
 * @param array $file this is the uploaded image submitted via the form
 * @return string Error message variable sent through that gets assigned errors if present; otherwise,
 * return an empty string
 */
function validateImageFile(array $file): string {

    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return "You must upload an image.";
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Error uploading image.";
    }

    if ($file['size'] > ML_MAX_FILES_SIZE || $file['size'] === 0) {
        return "Image must be less than " . ML_MAX_FILES_SIZE . " bytes and not be empty.";
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif'
    ];

    if (!array_key_exists($mime, $allowed)) {
        return "Allowed file types: jpg, png, gif.";
    }

    return "";
}


/**
 * This function's purpose is to move the uploaded image to the intended destination
 *
 * @param array $file the uploaded image submitted via the form
 * @return string The file path, or empty string if upload failed
 */
function addImageFileReturnPathLocation(array $file): string {

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif'
    ];

    $ext = $allowed[$mime] ?? null;

    if (!$ext) {
        return "";
    }

    if (!is_dir(ML_UPLOAD_PATH)) {
        mkdir(ML_UPLOAD_PATH, 0755, true);
    }

    try {

        $filename = bin2hex(random_bytes(8)) . '.' . $ext;

    } catch (Exception $e) {

        return "";
    }

    $destination = rtrim(ML_UPLOAD_PATH, '/') . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {

        return "";
    }

    $relativePath = '/Chicken_Sandwich_Ranker/images/' . $filename;
    
    return $relativePath;
}

    /**
 * This function's purpose is to delete the given image from the server
 *
 * @param string $path The full file path to delete
 */
function removeImageFile(string $path): void {
    
    if (is_file($path)) {
        unlink($path);
    }
}