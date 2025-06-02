<?php
require_once 'profile-image-constants.php';

/**
 * This function's purpose is to validate the uploaded profile image file
 *
 * @param array $file this is the uploaded profile image submitted via the form
 * @return string Error message variable sent through that gets assigned errors if present; otherwise,
 * return an empty string
 */
function validateProfileImageFile(array $file): string {
    
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {

        return "You must upload a profile image";
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {

        return "Error uploading profile image";
    }

    if ($file['size'] > PROFILE_IMAGE_MAX_FILE_SIZE || $file['size'] === 0) {
        return "Logo must be less than " . PROFILE_IMAGE_MAX_FILE_SIZE . " bytes and not be empty.";
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
 * This function's purpose is to move the uploaded profile image to the intended destination
 *
 * @param array $file the uploaded profile image submitted via the form
 * @return string The file path, or empty string if upload failed
 */
function addProfileImageFileReturnPathLocation(array $file): string {

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

    if (!is_dir(PROFILE_IMAGE_UPLOAD_PATH)) {
        mkdir(PROFILE_IMAGE_UPLOAD_PATH, 0755, true);
    }

    try {

        $filename = bin2hex(random_bytes(8)) . '.' . $ext;

    } catch (Exception $e) {

        return "";
    }

    $destination = rtrim(PROFILE_IMAGE_UPLOAD_PATH, '/') . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {

        return "";
    }

    $relativePath = '/Chicken_Sandwich_Ranker/profile_images/' . $filename;
    
    return $relativePath;
}

/**
 * This function's purpose is to delete the given profile image file from the server
 *
 * @param string $path The full file path to delete
 */
function removeProfileImageFile(string $path): void {
    if (is_file($path)) {
        unlink($path);
    }
}