
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

    $error_message = "";

    //Check for $_FILES being set and no errors
    if (isset($_FILES) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {

        //Check for uploaded file < Max file size AND an acceptable image type
        if ($_FILES['image']['size'] > ML_MAX_FILES_SIZE) {

            $error_message = "The image must be less than " . ML_MAX_FILES_SIZE . " Bytes";
        }

        $image_type = $_FILES['image']['type'];

        if ($image_type != 'image/jpg' && $image_type != 'image/jpeg' && $image_type != 'image/pjpeg'
            && $image_type != 'image/png' && $image_type != 'image/gif')
        {
            if (empty($error_message)) {

                $error_message = "The image must be of type jpg, png, or gif.";
            }
            else
            {
                $error_message .= ", and be an image of type jpg, png, or gif.";
            }
        }
    }

    elseif (isset($_FILES) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE
        && $_FILES['image']['error'] != UPLOAD_ERR_OK)
    {
        $error_message = "Error uploading image file.";
    }
    
    return $error_message;

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

    $image = "";

    //Check for $_FILES being set and no errors.
    if (isset($_FILES) && $_FILES['image']['error'] == UPLOAD_ERR_OK)
    {
        $image = ML_UPLOAD_PATH . $_FILES['image']['name'];

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image))
        {
            $image = "";
        }
    }

    return $image;
    
}

/**
 * @param
 */
function removeImageFile($image) {
    @unlink($image);
}