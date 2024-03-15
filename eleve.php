<?php
require_once 'class/ecole.php';

// Instanciation de la classe Ecole
$ecole = new Ecole();

// Récupérer les élèves de l'école depuis la base de données
$eleves = $ecole->getEleves();
$classes = $ecole->getClasses();
?>

<div class="container">
    <div class="row px-4 pt-4">
        <div class="col">
            <h1 class="title">Élèves</h1>
        </div>
        <div class="col-2">
            <!-- Bouton pour ouvrir le modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterEleveModal"><i class="bx bx-user-plus"></i> Ajouter</button>
        </div>
    </div>
</div>

<div class="container">
    <table id="eleves_table" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Classe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<!-- Modal pour ajouter un élève -->
<div class="modal fade" id="ajouterEleveModal" tabindex="-1" aria-labelledby="ajouterEleveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterEleveModalLabel">Ajouter un élève</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour ajouter un élève -->
                <form id="ajouterEleveForm" method="post" action="action.php">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_classe" class="form-label">Classe</label>
                        <select class="form-select" id="id_classe" name="id_classe" required>
                            <option value="">Sélectionnez une classe</option>

                            <?php foreach ($classes as $classe) : ?>
                                <option value="<?php echo $classe['id']; ?>"><?php echo $classe['libelle']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="ajouterEleve">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour la modification de l'élève -->
<div class="modal fade" id="modifierEleveModal" tabindex="-1" aria-labelledby="modifierEleveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierEleveModalLabel">Modifier un élève</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulaire pour modifier un élève -->
                <form id="modifierEleveForm" method="post" action="action.php">
                    <input type="hidden" name="id_eleve" id="id_eleve">
                    <div class="mb-3">
                        <label for="nom_modifier" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom_modifier" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_classe_modifier" class="form-label">Classe</label>
                        <select class="form-select" id="id_classe_modifier" name="id_classe" required>
                            <option value="">Sélectionnez une classe</option>
                            <?php foreach ($classes as $classe) : ?>
                                <option value="<?php echo $classe['id']; ?>"><?php echo $classe['libelle']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="modifierEleve">
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function chargerDonneesDataTable() {
        $('#eleves_table').DataTable().ajax.reload();
    }
    // Fonction pour pré-remplir les champs du modal de modification
    function preRemplirModal(id, nom, id_classe) {
        $('#id_eleve').val(id);
        $('#nom_modifier').val(nom);
        $('#id_classe').val(id_classe);
    }
    $(document).ready(function() {
        $("#ajouterEleveForm").submit(function(event) {
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
                        $('#nom').val('');
                        $('#id_classe').val('');
                        $.snack('success', "L'élève a été ajouté avec succès.", 3000);
                        // Charger les données du DataTable après l'ajout de la classe
                        chargerDonneesDataTable();
                    } else {
                        $.snack('error', "Une erreur s'est produite lors de l'ajout de l'élève.", 3000);
                    }
                }
            });
        });

        // Intercepter la soumission du formulaire de modification
        $('#modifierEleveForm').submit(function(event) {
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
                        $('#modifierEleveModalUnique').modal('hide');
                        $.snack('success', "L'élève a été modifié avec succès.", 3000);
                        chargerDonneesDataTable();
                    } else {
                        $.snack('error', "Une erreur s'est produite lors de la modification de l'élève.", 3000);
                    }
                },
            });
        });
    });
    $(document).ready(function() {
        // Initialiser DataTables
        var table = $('#eleves_table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
            },
            "ajax": {
                "url": "getEleve.php",
                "dataSrc": ""
            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "nom"
                },
                {
                    "data": "libelle"
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return '<button type="button" class="btn btn-primary btn-sm btnModifier" data-bs-toggle="modal" data-bs-target="#modifierEleveModal" onclick="preRemplirModal(' + row.id + ', \'' + row.nom + '\', ' + row.id_classe + ')"><i class="bx bx-edit-alt"></i> Modifier</button>' +
                            '<form method="post" action="action.php" class="formSupprimer" onsubmit="return confirmDelete();">' +
                            '<input type="hidden" name="delete_id" value="' + row.id + '">' +
                            '<input type="hidden" name="action" value="supprimerEleve">' +
                            '<button type="submit" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i> Supprimer</button>' +
                            '</form>';
                    }
                }
            ]
        });

        $('#eleves_table').on('submit', '.formSupprimer', function(event) {
            event.preventDefault();
            if (confirm("Êtes-vous sûr de vouloir supprimer cet élève ?")) {
                var formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "action.php",
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response == 'true') {
                            $.snack('success', "L'élève a été supprimé avec succès.", 3000);
                            table.ajax.reload();
                        } else {
                            $.snack('error', "Une erreur s'est produite lors de la suppression de l'élève.", 3000);
                        }
                    }
                });
            }
        });
    });
</script>