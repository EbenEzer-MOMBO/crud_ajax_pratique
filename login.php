<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inscription - Connexion</title>
    <!-- bootstrap -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css'>
    <link rel="stylesheet" href="assets/login.css">
    <!-- jquery -->
    <script src="assets/jquery-3.7.1.js"></script>
    <!-- jquery slim -->
    <script src="assets/toast.js"></script>
</head>

<body>

    <body>
        <!-- loader -->
        <div class="loader-container">
            <div class="loader"></div>
        </div>

        <!-- Animated Wave Background  -->
        <div class="ocean">
            <div class="wave"></div>
            <div class="wave"></div>
        </div>

        <!-- Log In Form Section -->
        <section>
            <div class="container" id="container">
                <div class="form-container sign-up-container">
                    <form method="post" id="form-inscription">
                        <h1>Inscription</h1>
                        <div class="social-container">
                            <a href="" target="_blank" class="social"><i class="fab fa-github"></i></a>
                            <a href="" target="_blank" class="social"><i class="fab fa-codepen"></i></a>
                            <a href="" target="_blank" class="social"><i class="fab fa-google"></i></a>
                        </div>
                        <span>Ou s'incrire avec une adresse Email</span>
                        <label>
                            <input type="text" name="ins_nom" placeholder="Nom" required />
                        </label>
                        <label>
                            <input type="email" name="ins_email" placeholder="Email" required />
                        </label>
                        <label>
                            <input type="password" name="ins_passwd" placeholder="Mot de passe" required />
                        </label>
                        <input type="hidden" name="action" value="inscription">
                        <button style="margin-top: 9px">S'inscrire</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form method="post" id="form-connexion">
                        <h1>Connexion</h1>
                        <div class="social-container">
                            <a href="" target="_blank" class="social"><i class="fab fa-github"></i></a>
                            <a href="" target="_blank" class="social"><i class="fab fa-codepen"></i></a>
                            <a href="" target="_blank" class="social"><i class="fab fa-google"></i></a>
                        </div>
                        <span> Ou se connecter avec une adresse Email</span>
                        <label>
                            <input type="email" name="con_email" placeholder="Email" required />
                        </label>
                        <label>
                            <input type="password" name="con_passwd" placeholder="Mot de passe" required />
                        </label>
                        <input type="hidden" name="action" value="connexion">
                        <a href="#">Mot de passe oublié?</a>
                        <button>Se connecter</button>
                    </form>
                </div>
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>Se connecter</h1>
                            <p>Connecte toi si tu as déjà un compte </p>
                            <button class="ghost mt-5" id="signIn">Connexion</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Créer un compte!</h1>
                            <p>Pas encore de compte, inscris toi ... </p>
                            <button class="ghost" id="signUp">Inscription</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>


    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js'></script>
    <script src="assets/login.js"></script>
    <script>
        $(document).ready(function() {
            $("#form-inscription").submit(function(event) {
                event.preventDefault();

                // Afficher le loader lors de la soumission du formulaire
                $(".loader-container").fadeIn();

                // Récupération des données du formulaire
                var formData = $(this).serialize();

                // Vérification du mot de passe
                var password = $("input[name='ins_passwd']").val();
                if (password.length < 4) {
                    $(".loader-container").fadeOut();
                    $.snack('warning', 'Le mot de passe doit contenir au moins 4 caractères!', 3000);
                    return; // Arrêter l'exécution de la fonction
                }

                // Envoi de la requête AJAX
                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $(".loader-container").fadeOut(); 

                        if (response == 'successIns') {
                            $("#form-inscription")[0].reset();
                            $.snack('success', 'Inscription réussie! Veuillez vous connecter.', 3000);
                        } else if (response == 'emailExists') {
                            $.snack('warning', 'Adresse email déjà existante!', 3000);
                        } else {
                            $.snack('error', 'Une erreur est survenue!', 3000);
                        }
                    }
                });
            });

            $("#form-connexion").submit(function(event) {
                event.preventDefault();

                $(".loader-container").fadeIn();

                // Récupération des données du formulaire
                var formData = $(this).serialize();

                // Envoi de la requête AJAX
                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        $(".loader-container").fadeOut(); 
                        if (response == 'errorCon') {
                            $.snack('error', "Mot de passe ou nom d'utilisateur incorrect.", 3000);
                        } else {
                            window.location.href = "index.php";
                        }
                    }
                });
            });
        });
    </script>


</body>

</html>