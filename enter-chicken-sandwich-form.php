<?php 

    if(isset($_POST['id'])) {
        ?> <h1>Update Chicken Id <?php echo $_POST['id']; ?> </h1> <?php

    } else {
        ?> <h1>Enter a Chicken Sandwich</h1> <?php
    } ?>


<form enctype="multipart/form-data" id='submit-form'
    class="needs-validation" novalidate method="POST"
    action="chicken-sandwich-service.php">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name"
        name="name" placeholder="name" required> 
        <div class="invalid-feedback">
            <p>Please provide a valid name</p>
        </div>
    </div>
                    
    <div class="form-group">
        <label for="source">Source</label>
        <input type="text" class="form-control" id="source"
        name="source"
        placeholder="source" required>

        <div class="invalid-feedback">
            <p>Please provide a source</p>
        </div>
    </div>
            
    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" class="form-control"
                    
        placeholder="image" required>
        <div class="invalid-feedback">
            <p>Please provide a valid image<p>
        </div>
    </div> 
            
    <div class="form-group">
        <label for="logo">Logo</label>
        <input type="file" id="logo" name="logo" class="form-control" placeholder="logo" required>
        <div class="invalid-feedback">
            <p>Please provide a valid logo<p>
        </div> 
    </div>

    <button class="button" type="submit" <?php if (isset($_POST['edit-chicken-sandwich']) || isset($_POST['id'])) { ?> name="<?php echo 'id'; ?>" value="<?php echo $_POST['id']?>" <?php } else {
        ?> name="enter-chicken-sandwich"<?php
        } ?>>Submit Chicken
    </button>
</form>

<script src="js/formValidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>       
        
    