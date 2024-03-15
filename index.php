<?php
include_once('incl/auth.php');

include('incl/header.php');

include('incl/sidebar.php');

?>

<!-- Main Wrapper -->
<div class="p-1 my-container active-cont">
    <!-- Top Nav -->
    <nav class="navbar top-navbar navbar-light bg-light px-5">
        <a class="btn border-0" id="menu-btn"><i class="bx bx-menu"></i></a>
        <!-- Bouton icône de déconnexion -->
        <div class="ms-auto">
            <form action="action.php" method="post">
                <input type="hidden" name="action" value="deconnexion">
                <button type="submit" class="btn border-0">Se déconnecter <i class="bx bx-log-out"></i></button>
            </form>
        </div>

    </nav>

    <!--End Top Nav -->
    <div id="frame_affichage"></div>
</div>

<?php

include('incl/footer.php');

?>