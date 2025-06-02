<form enctype='multipart/form-data' method='POST'
    action='user-service.php'>
                                
    <div class='form-group'>
        <label for='image'>Image</label>
        <input type='file' id='profile-image' name='profile-image' class='form-control'
        placeholder='image' required>
        <div class='invalid feedback'>
            <p>Please provide a valid image<p>
        </div>
    </div>
    <button type='submit' name='edit-image'>UPDATE</button>
</form>
<div class='d-flex'>

    <form action='user-chicken-sandwich-service.php' method='GET' class='mx-1'>
        <button class='button' type='submit' id='user-scores'
        name='user-scores'>YOUR RATINGS</button>
    </form>
                                
    <form action='user-service.php' method='POST'>
        <button class='button' type='submit'
        name='delete-user'>DELETE</button>
        <button class='button' type='submit'
        name='password-to-change'>EDIT PASSWORD</button>
    </form>
</div>