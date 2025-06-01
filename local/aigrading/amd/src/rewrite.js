// File: local/aigrading/amd/src/rewrite.js
// File: local/aigrading/amd/src/rewrite.js
define(['jquery'], function($) {
    function getCourseIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('courseid');
    }

    return {
        init: function() {
            console.log('📦 rewrite.js: init called');

            $('#id_satisfiedno').on('click', function(e) {
                e.preventDefault();
                console.log('🚨 Botón "No" presionado');

                const courseid = getCourseIdFromUrl();  // ✅ usa esta función correctamente
                const sesskey = M.cfg.sesskey;

                console.log('📤 Enviando AJAX con courseid:', courseid, 'sesskey:', sesskey);

                $.ajax({
                    method: 'POST',
                    url: M.cfg.wwwroot + '/local/aigrading/ajax.php',
                    data: {
                        courseid: Number(courseid), // 👈 fuerza conversión a entero
                        sesskey: sesskey
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('✅ Respuesta recibida:', response);
                        if (response.success) {
                            $('#id_rubric').val(response.rubric);
                            $('#custom_feedbacksummary').html(response.feedbacksummary);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('⚠️ Error del servidor: ' + xhr.status + ' - ' + xhr.statusText);
                    }
                });
            });
        }
    };
});


/*define(['jquery'], function($) {
    return {
        init: function() {
            $('#id_satisfiedno').on('click', function(e) {
                e.preventDefault();

                const courseid = $('#id_courseid').val();

                $.ajax({
                    method: 'POST',
                    url: M.cfg.wwwroot + '/local/aigrading/ajax.php',
                    //MUY IMPORTANTE, SE ENVIA LA INFO DESDE AQUÍ
                    data: {
                        courseid: courseid,
                        sesskey: M.cfg.sesskey // 🔐 agrega el token CSRF
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#id_rubric').val(response.rubric);
                            //$('#id_feedbacksummary').html(response.feedbacksummary);
                            $('#custom_feedbacksummary').html(response.feedbacksummary);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                });
            });
        }
    };
});*/
