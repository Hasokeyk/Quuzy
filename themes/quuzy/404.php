<?php
    header("HTTP/1.1 404 Not Found");

    require THEMEDIR."header.php";
?>

    <section class="page-404">

        <div class="big-like">
            404
        </div>

        <div class="big-text">
            NOT FOUND
        </div>

        <div class="big-button">
            <a href="/">HOME</a>
        </div>

    </section>

<?php 
    require THEMEDIR."footer.php";
?>