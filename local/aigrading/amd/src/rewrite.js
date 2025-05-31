// File: local/aigrading/amd/src/rewrite.js
define(['jquery'], function($) {
    return {
        init: function() {
            $('#id_satisfiedno').on('click', function(e) {
                e.preventDefault();

                const courseid = $('#id_courseid').val();

                $.ajax({
                    method: 'POST',
                    url: M.cfg.wwwroot + '/local/aigrading/ajax.php',
                    data: { courseid: courseid },
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
});
