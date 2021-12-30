$(document).ready(function () {
    // Afficher la liste des personnes
    $("#buttonListe").click(function () {
        // Si la liste est vide, alors on place la table, sinon, on la vide

        if ((!$("#liste").children().length > 0) || ($("#liste").hasClass("infos")) || ($("#liste").hasClass("heure"))) {
            $("#liste").removeClass("infos");
            $("#liste").removeClass("heure");
            $("#liste").addClass("personnes");
            $("#liste").empty();
            $.ajax({
                url: './liste.php',
                success: function (data) {
                    if ((data != null) && (data != "")) {

                        // Crée la table
                        let personnes = data.split(";");
                        let table = "<table id=\"myTable\"  class=\"table\"><thead><tr><th scope=\"col\">Présent</th><th scope=\"col\">Nom</th><th scope=\"col\">Prenom</th><th scope=\"col\">Adresse</th><th scope=\"col\">Telephone</th><th scope=\"col\">Historique</th></tr></thead><tbody>";

                        // Ajoute les entrées
                        personnes.forEach(p => {
                            let a = p.split(",");
                            let checked = "";
                            if (a[5] == 1) {
                                checked = "checked";
                            }
                            table += "<tr><td class=\"text-center\"><input type=\"checkbox\" id=\"" + a[0] + "\" name=\"" + a[0] + "\" " + checked + " </input></td><td>" + a[1] + "</td><td>" + a[2] + "</td><td>" + a[3] + "</td><td>" + a[4] + "</td><td class=\"text-center\"><button id=\"historique" + a[0] + "\" name=\"historique" + a[0] + "\" type=\"submit\" class=\"btn btn-primary\"><i class=\"fas fa-history\"></i></button></td></tr>";
                        });
                        table += "</tbody><table>";
                        $("#liste").append(table);

                        // Ajoute les eventListener
                        personnes.forEach(p => {
                            let a = p.split(",");
                            $("#" + a[0] + ":checkbox").change(function () {
                                // Checkbox pressée

                                // update la cell "present"
                                a[5] = $("#" + a[0]).is(":checked");
                                $.ajax({
                                    url: './personneSortieOuEntree.php',
                                    type: 'POST',
                                    data: { a: a },
                                    success: function () {
                                        //window.location.reload();
                                    },
                                });
                            });

                            $("#historique" + a[0]).click(function () {
                                // Affiche l'historique pour une personne
                                window.location.replace("./historique.php?pk=" + a[0]);
                            })
                        });

                        $('#myTable').DataTable({
                            "lengthChange": false,
                            "language": {
                                "lengthMenu": "",
                                "zeroRecords": "Aucun résultat",
                                "info": "Page _PAGE_ sur _PAGES_",
                                "infoEmpty": "Aucun résultat",
                                "infoFiltered": "(Filtré de _MAX_ entrées)"
                            }
                        });
                    } else {
                        $("#liste").append("<p class=\"text-center\">Pas de personnes inscrite</p>");
                    }
                }
            });
        } else {
            $("#liste").empty();
            $("#liste").removeClass("personnes");
        }
    });


    $("#buttonInfos").click(function () {
        // Si la liste est vide, alors on place les infos, sinon, on la vide
        if ((!$("#liste").children().length > 0) || ($("#liste").hasClass("personnes")) || ($("#liste").hasClass("heure"))) {
            $("#liste").removeClass("personnes");
            $("#liste").removeClass("heure");
            $("#liste").addClass("infos");
            $("#liste").empty();
            let content = "<div class=\"row mt-5 mb-3\"\><div class=\"col-sm-6\" id=\"actuel\"\><h5>Sur place de fete : </h5\></div\></div\><div class=\"row mb-3\"\><div class=\"col-md\" id=\"max\"\><h5>Max. simultanément : </h5\></div\></div\><div class=\"row\"\><div class=\"col-md\" id=\"total\"\><h5>Total Personnes : </h5\></div\></div\>";
            $("#liste").append(content);

            // update les valeurs
            $.ajax({
                url: './updateValues.php',
                success: function (data) {
                    data = data.replace('\n', "");
                    valeurs = data.split(',');
                    $("#actuel").html("<h5>Sur place de fete : <b>" + valeurs[0] + "</b></h5>");
                    $("#max").html("<h5>Max. simultanément : <b>" + valeurs[1] + "</b></h5>");
                    $("#total").html("<h5>Total Personnes :  <b>" + valeurs[2] + "</b></h5>");
                },
            });
        } else {
            $("#liste").empty();
            $("#liste").removeClass("infos");
        }
    });

    $("#buttonHeure").click(function () {
        // Si la liste est vide, alors on place les heures, sinon, on la vide
        if ((!$("#liste").children().length > 0) || ($("#liste").hasClass("personnes")) || ($("#liste").hasClass("infos"))) {
            $("#liste").removeClass("personnes");
            $("#liste").removeClass("infos");
            $("#liste").addClass("heure");
            $("#liste").empty();



            // Affiche l'input
            let content = "<h2 class=\"mb-4\">Filtrer par heure</h2><div class=\"input-group mb-3\"><input id=\"heureChoisie\" type=\"datetime-local\" value=\"2020-06-09T16:00\" class=\"form-control\" placeholder=\"Choisissez une heure\"></div><button id=\"buttonHeureChoisie\" type=\"button\" class=\"btn btn-info btn-block mb-5\">Rechercher</button>";
            $("#liste").append(content);

            // JQuery, listener "rechercher"
            $("#buttonHeureChoisie").click(function () {

                $("#table-par-heure").empty();
                $("#table-par-heure").remove();

                let heureChoisie = $("#heureChoisie").val();
                // update les valeurs
                $.ajax({
                    url: './selonHeure.php',
                    method: 'POST',
                    data: { heureChoisie: heureChoisie },
                    success: function (data) {
                        if ((data != null) && (data != "")) {

                            // Sépare les personnes
                            let personnes = data.split(";");
                            console.log(data);

                            // Afficher dataTable des résultats
                            let table = "<div id=\"table-par-heure\"> <table id=\"myTable\" class=\"table\"><thead><tr><th scope=\"col\">Nom</th><th scope=\"col\">Prenom</th><th scope=\"col\">Adresse</th><th scope=\"col\">Telephone</th></tr></thead><tbody>";

                            // Remplie le tableau
                            personnes.forEach(p => {
                                let a = p.split(",");
                                table += "<tr><td>" + a[1] + "</td><td>" + a[2] + "</td><td>" + a[3] + "</td><td>" + a[4] + "</td></tr>";
                            });
                            table += "</tbody><table></div>";
                            $("#liste").append(table);

                            $('#myTable').DataTable({
                                "lengthChange": false,
                                "language": {
                                    "lengthMenu": "",
                                    "zeroRecords": "Aucun résultat",
                                    "info": "Page _PAGE_ sur _PAGES_",
                                    "infoEmpty": "Aucun résultat",
                                    "infoFiltered": "(Filtré de _MAX_ entrées)"
                                }
                            });
                        }
                    },
                });
            });

        } else {
            $("#liste").empty();
            $("#liste").removeClass("heure");
        }
    });



});