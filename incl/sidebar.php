<div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
    <ul class="nav flex-column text-white w-100">
        <a href="#" class="nav-link h3 text-white my-2">
            Gestion </br>Scolaire
        </a>
        <li href="#" class="nav-link text-white" id="dashboard">
            <i class="bx bxs-dashboard"></i>
            <span class="mx-2">Accueil</span>
        </li>
        <li href="#" class="nav-link text-white" id="classe">
            <i class="bx bx-user-check"></i>
            <span class="mx-2">Classes</span>
        </li>
        <li href="#" class="nav-link text-white" id="eleve">
            <i class="bx bx-conversation"></i>
            <span class="mx-2">Élèves</span>
        </li>
    </ul>

    <span href="#" class="nav-link h4 w-100 mb-5">
        <a href=""><i class="bx bxl-instagram-alt text-white"></i></a>
        <a href=""><i class="bx bxl-twitter px-2 text-white"></i></a>
        <a href=""><i class="bx bxl-facebook text-white"></i></a>
    </span>
</div>

<script>
    // Fonction pour enregistrer la page sélectionnée dans le stockage local du navigateur
    function sauvegarderPageSelectionnee(page) {
        localStorage.setItem('page_selectionnee', page);
    }

    // Fonction pour récupérer la page sélectionnée depuis le stockage local du navigateur
    function recupererPageSelectionnee() {
        return localStorage.getItem('page_selectionnee');
    }

    document.addEventListener("DOMContentLoaded", function() {
        var menu_btn = document.querySelector("#menu-btn");
        var sidebar = document.querySelector("#sidebar");
        var container = document.querySelector(".my-container");

        // Récupérer la page sélectionnée (si elle existe) et la charger
        var pageSelectionnee = recupererPageSelectionnee();
        if (pageSelectionnee) {
            $('#frame_affichage').load(pageSelectionnee + '.php');
        }

        menu_btn.addEventListener("click", () => {
            sidebar.classList.toggle("active-nav");
            container.classList.toggle("active-cont");
        });

        $(document).ready(function() {
            $('#dashboard').click(function() {
                $('#frame_affichage').empty().load('accueil.php');
                sauvegarderPageSelectionnee('accueil');
            });
            $('#classe').click(function() {
                $('#frame_affichage').empty().load('classe.php');
                sauvegarderPageSelectionnee('classe');
            });
            $('#eleve').click(function() {
                $('#frame_affichage').empty().load('eleve.php');
                sauvegarderPageSelectionnee('eleve');
            });
            $('#paiement').click(function() {
                $('#frame_affichage').empty().load('paiement.php');
                sauvegarderPageSelectionnee('paiement');
            });
        });
    });
</script>