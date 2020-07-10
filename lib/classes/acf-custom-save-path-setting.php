<?php

/**
 * Adds a JSON Save Path setting to the Settings section for ACF Field Groups.
 */
class acf_custom_json_save_path_setting {
    // This will store the preferred save path for the group for later retrieval.
    private $preferred_save_path;

    public function __construct() {
        // Add the "JSON Save Path" setting to all field groups.
        add_action('acf/render_field_group_settings', [$this, 'add_json_save_path_setting']);

        // Call an early bird (priority 1) action before saving the field group.
        add_action('acf/update_field_group', [$this, 'set_up_save_path'], 1, 1);
    }

    public function add_json_save_path_setting($field_group) {
        // Create our custom setting field with the specified options.
        acf_render_field_wrap([
            'label'        => 'JSON Save Path',
            'instructions' => 'Determines where the field group\'s JSON file will be saved, relative to the active theme\'s directory.',
            'type'         => 'text',
            'name'         => 'json_save_path',
            'prefix'       => 'acf_field_group',
            'prepend'      => '/',
            'placeholder'  => 'Use default path',
            'value'        => $field_group['json_save_path'] ?? '',
        ]);
    }

    public function set_up_save_path($group) {
        // Get the preferred save path, if set.
        $preferred_save_path = $group['json_save_path'] ?? null;

        // If not set (or set to an empty string), do nothing.
        if (!$preferred_save_path) {
            return $group;
        }

        // Set aside the preferred path and add an override action.
        $this->preferred_save_path = get_stylesheet_directory() . "/$preferred_save_path";
        add_action('acf/settings/save_json', [$this, 'save_to_preferred_save_path'], 9999);

        // Return the group for updating as usual.
        return $group;
    }

    public function save_to_preferred_save_path($path) {
        // Ensure this field group is saved to the preferred save path.
        $path = $this->preferred_save_path;

        return $path;
    }
}
new acf_custom_json_save_path_setting();