    <form action='user-service.php' method='POST'>
        <label for="current-password"
        class="col-sm-2 col-form-label-lg">Current Password:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control"
            id="current-password" name="current-password"
            placeholder="Enter a password" required>
            <div class="invalid-feedback">
                Please provide a valid password
            </div>
        </div>
        <label for="password"
        class="col-sm-2 col-form-label-lg">New Password:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control"
            id="password" name="new-password"
            placeholder="Enter a password" required>
            <div class="invalid-feedback">
                Please provide a valid password
            </div>
        </div>
        <label for="repeated-password"
        class="col-sm-2 col-form-label-lg">Enter Password Again:</label>
        <div class="col-sm-4">
            <input type="password" class="form-control"
            id="repeated-password" name="repeated-password"
            placeholder="Enter a password" required>
            <div class="invalid-feedback">
                Please provide a valid password
            </div>
        </div>
        <button type="submit"
            name="edit-password">EDIT
        </button>
    </form>
</main>