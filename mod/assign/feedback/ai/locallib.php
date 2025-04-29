<?php

defined('MOODLE_INTERNAL') || die();

class assign_feedback_ai extends assign_feedback_plugin {

    public function get_name() {
        return get_string('pluginname', 'assignfeedback_ai');
    }

    public function is_enabled() {
        return true;
    }

    public function is_visible() {
        return true;
    }

    public function get_settings(MoodleQuickForm $mform) {
        // Aquí puedes agregar configuraciones específicas para tu plugin si es necesario.
    }

    public function save_settings(stdClass $data) {
        // Guarda las configuraciones específicas de tu plugin si es necesario.
        return true;
    }

    public function get_feedback_file_areas() {
        return array();
    }

    public function get_editor_fields() {
        return array();
    }

    public function get_file_areas() {
        return array();
    }

    public function supports_quickgrading() {
        return false;
    }

    public function view_summary(stdClass $grade, & $showviewlink) {
        // Proporciona un resumen de la retroalimentación si es necesario.
        return '';
    }

    public function view(stdClass $grade) {
        // Muestra la retroalimentación completa si es necesario.
        return '';
    }

    public function is_feedback_modified(stdClass $grade, stdClass $data) {
        return false;
    }

    public function save(stdClass $grade, stdClass $data) {
        return true;
    }

    public function get_form_elements_for_user($grade, MoodleQuickForm $mform, stdClass $data, $userid) {
        // Agrega elementos de formulario para la retroalimentación si es necesario.
    }

    public function get_editor_text($name, $gradeid) {
        return '';
    }

    public function get_editor_format($name, $gradeid) {
        return FORMAT_HTML;
    }

    public function is_empty(stdClass $grade) {
        return true;
    }

    public function can_upgrade($type, $version) {
        return false;
    }

    public function upgrade($grade) {
        return false;
    }
}
