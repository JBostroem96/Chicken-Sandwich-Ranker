<?php
require_once 'logo-file-constants.php';

/**
 * This function's purpose is to validate the uploaded logo
 *
 * @param array $file this is the uploaded logo submitted via the form
 * @return string Error message variable sent through that gets assigned errors if present; otherwise,
 * return an empty string
 */
function validateLogoFile(array $file): string {
    
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return "You must upload a logo.";
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Error uploading logo.";
    }

    if ($file['size'] > LOGO_MAX_FILE_SIZE || $file['size'] === 0) {
        return "Logo must be less than " . LOGO_MAX_FILE_SIZE . " bytes and not be empty.";
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
    ];

    if (!array_key_exists($mime, $allowed)) {
        return "Allowed file types: jpg, png, gif.";
    }

    return ""; // No errors
}

/**
 * This function's purpose is to move the uploaded logo to the intended destination
 *
 * @param array $file the uploaded logo submitted via the form
 * @return string The file path, or empty string if upload failed
 */
function addLogoFileReturnPathLocation(array $file): string {
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
    ];

    $ext = $allowed[$mime] ?? null;

    if (!$ext) {

        return "";
    }

    if (!is_dir(LOGO_UPLOAD_PATH)) {

        mkdir(LOGO_UPLOAD_PATH, 0755, true);
    }

    try {

        $filename = bin2hex(random_bytes(8)) . '.' . $ext;

    } catch (Exception $e) {

        return "";
    }

    $destination = rtrim(LOGO_UPLOAD_PATH, '/') . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {

        return "";
    }

    $relativePath = '/Chicken_Sandwich_Ranker/logos/' . $filename;
    
    return $relativePath;
}

/**
 * This function's purpose is to delete the given logo from the server
 *
 * @param string $path The full file path to delete
 */
function removeLogoFile(string $path): void {

    if (is_file($path)) {
        unlink($path);
    }
}