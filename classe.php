
<div class="container">
    <div class="row px-4 pt-4">
        <div class="col">
            <h1 class="title">Classe</h1>
        </div>
        <div class="col-2">
            <!-- Bouton pour ouvrir le modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterClasseModal"><i class="bx bx-book-content"></i> Ajouter</button>
        </div>
    </div>
</div>

<div class="container">
    <table id="classes_table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- contenu du tableau -->
        </tbody>
    </table>
</div>

<!-- Modal pour ajouter une classe -->
<div class="modal fade" id="ajouterClasseModal" tabindex="-1" aria-labelledby="ajouterClasseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterClasseModalLabel">Ajouter une classe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter une classe -->
                <form id="ajouterClasseForm" method="post" action="action.php">
                    <div class="mb-3">
                        <label for="libelle" class="form-label">Libellé</label>
                        <input type="text" class="form-control" id="libelle" name="libelle" required>
                    </div>
                    <input type="hidden" name="action" value="ajouterClasse">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal pour la modification de la classe -->
<div class="modal fade" id="modifierClasseModalUnique" tabindex="-1" aria-labelledby="modifierClasseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierClasseModalLabel">Modifier une classe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour modifier une classe -->
                <form id="modifierClasseForm" method="post" action="action.php">
                    <input type="hidden" name="id_classe" id="id_classe">
                    <div class="mb-3">
                        <label for="libelle_modifier" class="form-label">Nouveau libellé</label>
                        <input type="text" class="form-control" id="libelle_modifier" name="libelle" required>
                    </div>
                    <input type="hidden" name="action" value="modifierClasse">
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // Fonction pour charger les données du DataTable à partir de la source de données
    function chargerDonneesDataTable() {
        $('#classes_table').DataTable().ajax.reload();
    }

    $(document).ready(function() {
        $("#ajouterClasseForm").submit(function(event) {
            event.preventDefault();

            // Récupérer les données du formulaire
            var formData = $(this).serialize();

            // Envoi de la requête AJAX
            $.ajax({
                type: "POST",
                url: "action.php",
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response == 'true') {
                        $('#libelle').val('');
                        $.snack('success', "La classe a été ajoutée avec succès.", 3000);
                        // Charger les données du DataTable après l'ajout de la classe
                        chargerDonneesDataTable();
                    } else {
                        $.snack('error', "Une erreur s'est produite lors de l'ajout de la classe.", 3000);
                    }
                }
            });
        });

        // Intercepter la soumission du formulaire de modification
        $('#modifierClasseForm').submit(function(event) {
            event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

            // Récupérer les données du formulaire
            var formData = $(this).serialize();

            // Envoi de la requête AJAX pour la modification de la classe
            $.ajax({
                type: "POST",
                url: "action.php",
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response == 'true') {
                        $('#modifierClasseModalUnique').modal('hide');
                        $.snack('success', "La classe a été modifiée avec succès.", 3000);
                        chargerDonneesDataTable();
                    } else {
                        $.snack('error', "Une erreur s'est produite lors de la modification de la classe.", 3000);
                    }
                },
            });
        });
    });

    $(document).ready(function() {
        // Initialiser DataTables
        var table = $('#classes_table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            },
            "ajax": {
                "url": "getClasse.php",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "libelle"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button type="button" class="btn btn-primary btn-sm btnModifier" data-bs-toggle="modal" data-bs-target="#modifierClasseModal" data-id="' + row.id + '" data-libelle="' + row.libelle + '"><i class="bx bx-edit-alt"></i>Modifier</button>' +
                            '<form method="post" action="action.php" class="formSupprimer" onsubmit="return confirmDelete();">' +
                            '<input type="hidden" name="delete_id" value="' + row.id + '">' +
                            '<input type="hidden" name="action" value="supprimerClasse">' +
                            '<button type="submit" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i> Supprimer</button>' +
                            '</form>';
                    }
                }
            ]
        });

        // Gestionnaire d'événements délégué pour le bouton "Modifier"
        $('#classes_table').on('click', '.btnModifier', function() {
            var idClasse = $(this).data('id');
            var libelleClasse = $(this).data('libelle');

            // Remplir les champs du formulaire de modification avec les détails de la classe sélectionnée
            $('#id_classe').val(idClasse);
            $('#libelle_modifier').val(libelleClasse);

            // Ouvrir le modal de modification
            var modal = new bootstrap.Modal($('#modifierClasseModalUnique'));
            modal.show();
        });

        // Gestionnaire d'événements délégué pour le formulaire de suppression
        $('#classes_table').on('submit', '.formSupprimer', function(event) {
            event.preventDefault();
            if (confirm("Êtes-vous sûr de vouloir supprimer cette classe ?")) {
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response == 'true') {
                            $.snack('success', "La classe a été supprimée avec succès.", 3000);
                            table.ajax.reload();
                        } else {
                            $.snack('error', "Une erreur s'est produite lors de la suppression de la classe.", 3000);
                        }
                    }
                });
            }
        });
    });
</script>