<?php include_once "includes/header.php"; ?>
    <div class="container-fluid p-3">
        <form action="#" class="needs-validation" novalidate>
            <div class="form-floating">
                <textarea class="form-control" style="height : 50vh" placeholder="Leave a comment here" id="floatingTextarea" required></textarea>
                <label for="floatingTextarea">Please input your comments here...</label>
            </div>
            <div class="py-2">
                <button type="submit" class="btn btn-base_color">Submit</button>
            </div>
        </form>
    </div>
    <script src="js/form-validation.js"></script>
<?php include_once "includes/footer.php"?>