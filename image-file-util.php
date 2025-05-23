
<?php
require_once 'file-constants.php';


/**
 * Purpose: Validates  an uploaded image file
 * 
 * Description: Validates an uploaded image file is not greater than ML_MAX_FILE_SIZE (1/2MB),
 * and is either a jpg or png image type, and has no errors. If the image file
 * validates to these contraints, an error message containing an empty string is 
 * returned. If there is an error, a string containing constraints the file failed
 * to validate to are returned.
 * 
 * @return string Empty if validation is successful, otherwise error string containing
 * constraints the image file failed to validate to. */
function validateImageFile() {


    //If an image was not uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        return "You must upload an image.";
    }

    //If there was an erro uploading said image
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
 * Purpose: Moves an uploaded image file to the ML_UPLOAD_PATH (images/)
 * folder and return the path location
 * 
 * Description: Moves an uploaded image file from the temporary server location
 * to the ML_UPLOAD_PATH (images/) folder IF an image file was uploaded
 * and returns the path location of the uploaded file by appending the file
 * name to the ML_UPLOAD_PATH (e.g. images/movie_image.png). IF an image
 * file was NOT uploaded, an empty string will be returned for the path.
 * 
 * @return string Path to image file IF a file was uploaded AND moved to the
 * ML_UPLOAD_PATH (images/) folder, otherwise and empty string */
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