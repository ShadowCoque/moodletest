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
                alert('🚨 Please update your rubric and re-evaluate the model.');

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
            $('#id_satisfiedyes').on('click', function(e) {
                e.preventDefault();
                console.log('✅ Botón "Yes" presionado');
            
                const courseid = getCourseIdFromUrl();
                const sesskey = M.cfg.sesskey;
            
                // Petición AJAX para obtener estudiantes
                $.ajax({
                    method: 'POST',
                    url: M.cfg.wwwroot + '/local/aigrading/ajax_get_students.php',
                    data: {
                        courseid: Number(courseid),
                        sesskey: sesskey
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('🎯 Estudiantes recibidos:', response);
                    
                        // 👉 Elimina contenido duplicado
                        $('#student-selection-container').remove();
                    
                        if (response.success) {
                            const container = $(`
                                <div id="student-selection-container" class="form-group mt-3">
                                </div>
                            `);
                            const infoText = $('<p><strong>Please select a student or students to be graded by AI</strong></p>');
                            container.append(infoText);

                    
                            response.students.forEach(student => {
                                const checkbox = $(`
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="${student.id}" id="student_${student.id}">
                                        <label class="form-check-label" for="student_${student.id}">
                                            ${student.name}
                                        </label>
                                    </div>
                                `);
                                container.append(checkbox);
                            });
                    
                            const confirmBtn = $(`<button class="btn btn-primary mt-2" id="confirm-selection">Confirm Selection</button>`);
                            confirmBtn.on('click', function() {
                                // Redirección o lógica futura
                                window.location.href = M.cfg.wwwroot + '/local/aigrading/next_interface.php';
                            });
                    
                            container.append(confirmBtn);
                    
                            // ✅ Añade debajo del contenedor común de los botones
                            const buttonContainer = $('#student-selection-target').html(container); // <- asumiendo div.form-group
                            buttonContainer.append(container);

                        } else {
                            alert('❌ Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('⚠️ Error al cargar estudiantes: ' + xhr.status);
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
