jQuery(document).ready(function($) {
    $('td[contenteditable="true"]').on('keydown', function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
        }
    });
});
/* @@@######@##@@@@######@@ */

/*     pret perso          */
jQuery(document).ready(function($) {
    $('#register-button-perso').on('click', function() {
        var data = {};
        $('td[contenteditable="true"]').each(function() {
            var key = $(this).data('key');
            var duration = $(this).data('duration');
            var value = $(this).text();
            if (!data[key]) {
                data[key] = {};
            }
            data[key][duration] = value;
        });

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_pret_perso_data',
                data: data
            },
            success: function(response) {
                console.log(response);
                alert('Données enregistrés avec succès.');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });
});


/*     pret mobilite          */
jQuery(document).ready(function($) {
    $('#register-button-mobilite').on('click', function() {
        var data = {};
        $('td[contenteditable="true"]').each(function() {
            var key = $(this).data('key');
            var duration = $(this).data('duration');
            var value = $(this).text();
            if (!data[key]) {
                data[key] = {};
            }
            data[key][duration] = value;
        });

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_pret_mobilite_data',
                data: data
            },
            success: function(response) {
                console.log(response);
                alert('Données enregistrés avec succès.');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });
});


/*     pret voiture neuve          */
jQuery(document).ready(function($) {
    $('#register-button-new-car').on('click', function() {
        var data = {};
        $('td[contenteditable="true"]').each(function() {
            var key = $(this).data('key');
            var duration = $(this).data('duration');
            var value = $(this).text();
            if (!data[key]) {
                data[key] = {};
            }
            data[key][duration] = value;
        });

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_pret_new_car_data',
                data: data
            },
            success: function(response) {
                console.log(response);
                alert('Données enregistrés avec succès.');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });
});

/*     pret voiture occasion          */
jQuery(document).ready(function($) {
    $('#register-button-occasion-car').on('click', function() {
        var data = {};
        $('td[contenteditable="true"]').each(function() {
            var key = $(this).data('key');
            var duration = $(this).data('duration');
            var value = $(this).text();
            if (!data[key]) {
                data[key] = {};
            }
            data[key][duration] = value;
        });

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_pret_voiture_occasion_data',
                data: data
            },
            success: function(response) {
                console.log(response);
                alert('Données enregistrés avec succès.');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });
});


/*     pret moto neuve          */
jQuery(document).ready(function($) {
    $('#register-button-new-moto').on('click', function() {
        var data = {};
        $('td[contenteditable="true"]').each(function() {
            var key = $(this).data('key');
            var duration = $(this).data('duration');
            var value = $(this).text();
            if (!data[key]) {
                data[key] = {};
            }
            data[key][duration] = value;
        });

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_pret_moto_neuve_data',
                data: data
            },
            success: function(response) {
                console.log(response);
                alert('Données enregistrés avec succès.');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });
});


/*     pret moto occasion          */
jQuery(document).ready(function($) {
    $('#register-button-occasion-moto').on('click', function() {
        var data = {};
        $('td[contenteditable="true"]').each(function() {
            var key = $(this).data('key');
            var duration = $(this).data('duration');
            var value = $(this).text();
            if (!data[key]) {
                data[key] = {};
            }
            data[key][duration] = value;
        });

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_pret_moto_occasion_data',
                data: data
            },
            success: function(response) {
                console.log(response);
                alert('Données enregistrés avec succès.');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });
});


/*     pret travaux          */
jQuery(document).ready(function($) {
    $('#register-button-travaux').on('click', function() {
        var data = {};
        $('td[contenteditable="true"]').each(function() {
            var key = $(this).data('key');
            var duration = $(this).data('duration');
            var value = $(this).text();
            if (!data[key]) {
                data[key] = {};
            }
            data[key][duration] = value;
        });

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_pret_travaux_data',
                data: data
            },
            success: function(response) {
                console.log(response);
                alert('Données enregistrés avec succès.');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });
});

/*     pret énergie          */
jQuery(document).ready(function($) {
    $('#register-button-energie').on('click', function() {
        var data = {};
        $('td[contenteditable="true"]').each(function() {
            var key = $(this).data('key');
            var duration = $(this).data('duration');
            var value = $(this).text();
            if (!data[key]) {
                data[key] = {};
            }
            data[key][duration] = value;
        });

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'save_pret_energie_data',
                data: data
            },
            success: function(response) {
                console.log(response);
                alert('Données enregistrés avec succès.');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
            }
        });
    });
});
