
<?php
require_once 'file-constants.php';


/**
 * This function's purpose is to validate the uploaded image by first checking that it's not empty,
 * then checking for errors, then the size, and then the allowed types. If no errors are present, return empty string
 */
function validateImageFile() {


    //If an image was not uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        return "You must upload an image.";
    }

    //If there was an error uploading said image
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return "Error uploading image.";
    }

    //Ensure the image is more than 0, but less than a specific size
    if ($_FILES['image']['size'] > ML_MAX_FILES_SIZE || $_FILES['image']['size'] === 0) {
        return "Image must be less than " . ML_MAX_FILES_SIZE . " bytes and not be empty.";
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES['image']['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'];

    //Only allow these image types
    if (!array_key_exists($mime, $allowed)) {
        return "Allowed file types: jpg, png, gif.";
    }

    return ""; // No errors
}

/**
 * This function's purpose is to move the file from its temporary location to the intended destination that's been set, by
 * first ensuring there was no upload error, and that the file type is allowed
 */
function addImageFileReturnPathLocation() {

    //If an issue arises, abort
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        return "";
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES['image']['tmp_name']);

    //check the file type, and if it's not a valid one, assign null
    $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif'][$mime] ?? null;

    //if it's null, then abort
    if (!$ext) {
        return "";
    }

    //ensures the upload directory is valid
    if (!is_dir(ML_UPLOAD_PATH)) {
        mkdir(ML_UPLOAD_PATH, 0755, true);
    }

    //Randomized file name, preventing identical names
    $filename = bin2hex(random_bytes(8)) . '.' . $ext;
    $destination = ML_UPLOAD_PATH . $filename;

    //uploads the file to the intended destination
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
        return "";
    }

    return $destination;
}

//ensures the removal of a file
function removeImageFile($image) {
    if (is_file($image)) {
        unlink($image);
    }
}