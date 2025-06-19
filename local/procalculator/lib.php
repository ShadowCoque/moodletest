<?php
// Esta función es un hook reconocido por Moodle.
// Los hooks son funciones especiales que Moodle llama 
// automáticamente durante su ciclo de ejecución.
//
// Su nombre debe ser exactamente local_{pluginname}_extend_navigation_frontpage()
// para que Moodle la detecte automáticamente.
// Sirve para añadir elementos personalizados al menú de navegación en la página principal (frontpage).
//
// navigation_node $frontpage:
// Es un objeto de tipo `navigation_node` que representa un nodo del arbol de navegacion (para el menu principal, menu de curso, configuracion, etc)
// extend_navigation_frontpage(), el objeto $frontpage representa el nodo raíz 
// de la navegación de la portada/pagina principal
// Moodle lo pasa automáticamente al invocar este hook.

// function local_procalculator_extend_navigation_frontpage(navigation_node $frontpage) {
//     // Añade un nuevo ítem al nodo de navegación de la portada (menú principal).
//     $frontpage->add( //metodo add() y sus argumentos a continuacion
//         // 1. Texto visible: el nombre del plugin, traducido desde los archivos de idioma.
//         get_string('pluginname', 'local_procalculator'),
//         // 2. moodle_url: la URL a la que apuntará el enlace.
//         new moodle_url('/local/procalculator/index.php'),
//         // 3. TYPE_CUSTOM: indica que este nodo no pertenece a los tipos estándar (curso, categoría, etc),
//         //  sino que es personalizado.
//         navigation_node::TYPE_CUSTOM,
//     );
// }

function local_procalculator_extend_navigation_course(navigation_node $nav, stdClass $course, context_course $context) {
    // Añadir el nodo al arbol de navegacion en el contexto utilizado
    $course_id = $course->id;
    $nav->add(
        get_string('pluginname', 'local_procalculator'),
        // URL con parámetro id del curso
        new moodle_url('/local/procalculator/index.php', ['course_id' => $course_id]),
        navigation_node::TYPE_CUSTOM
    );
}


//PARECE QUE ES NECESARIO RECONSTRUIR EL PLUGIN PARA QUE REFLEJE LOS CAMBIOS DE ESTE ARCHIVO