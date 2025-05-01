<?php
/**
 * Plugin Name: Elementor Styleguide
 * Plugin URI: https://zardlabs.com/elementor-styleguide
 * Description: A complete styleguide plugin for Elementor Pro with color management and typography
 * Version: 1.0.2
 * Author: zard labs
 * License: GPL v2 or later
 * Text Domain: elementor-styleguide
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('ELEMENTOR_STYLEGUIDE_VERSION', '1.0.2');
define('ELEMENTOR_STYLEGUIDE_FILE', __FILE__);
define('ELEMENTOR_STYLEGUIDE_PATH', plugin_dir_path(__FILE__));
define('ELEMENTOR_STYLEGUIDE_URL', plugin_dir_url(__FILE__));

/**
 * Verifica se o Elementor está ativo usando uma verificação mais robusta
 */
function elementor_styleguide_is_elementor_active() {
    // Verifica se o plugin Elementor está ativo usando a função padrão
    $elementor_active = is_plugin_active('elementor/elementor.php');
    
    // Verifica diretamente pela classe principal do Elementor como backup
    $elementor_class_exists = class_exists('\Elementor\Plugin');
    
    // Considera ativo se qualquer uma das verificações for bem-sucedida
    return $elementor_active || $elementor_class_exists;
}

// Adiciona a função para verificar plugins ativos se ainda não estiver disponível
if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

// Verifica se o Elementor está ativo usando a função melhorada
if (!elementor_styleguide_is_elementor_active()) {
    add_action('admin_notices', function() {
        echo '<div class="notice notice-error"><p>' . 
             sprintf(__('Elementor Styleguide requires Elementor to be installed and active. <a href="%s">Install Elementor</a>', 'elementor-styleguide'), 
                    admin_url('plugin-install.php?s=elementor&tab=search&type=term')) . 
             '</p></div>';
    });
} else {
    // Carrega o plugin apenas se o Elementor estiver ativo
    
    // Load plugin files
    require_once ELEMENTOR_STYLEGUIDE_PATH . 'includes/class-utils.php';
    require_once ELEMENTOR_STYLEGUIDE_PATH . 'includes/class-settings.php';
    require_once ELEMENTOR_STYLEGUIDE_PATH . 'includes/class-css-generator.php';
    require_once ELEMENTOR_STYLEGUIDE_PATH . 'includes/class-frontend.php';
    require_once ELEMENTOR_STYLEGUIDE_PATH . 'includes/class-admin.php';

    /**
     * Main Elementor Styleguide Class
     */
    class Elementor_Styleguide {
        /** @var Elementor_Styleguide Singleton instance */
        private static $instance = null;
        
        /** @var Elementor_Styleguide_Admin Admin class instance */
        public $admin;
        
        /** @var Elementor_Styleguide_Frontend Frontend class instance */
        public $frontend;
        
        /** @var Elementor_Styleguide_Settings Settings class instance */
        public $settings;

        /**
         * Get singleton instance
         * @return Elementor_Styleguide
         */
        public static function get_instance() {
            if (null === self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor
         */
        public function __construct() {
            // Register text domain for translations
            load_plugin_textdomain('elementor-styleguide', false, dirname(plugin_basename(__FILE__)) . '/languages');
            
            // Initialize components
            $this->settings = new Elementor_Styleguide_Settings();
            $this->frontend = new Elementor_Styleguide_Frontend($this->settings);
            $this->admin = new Elementor_Styleguide_Admin($this->settings);
            
            // Registra o menu diretamente de forma independente
            add_action('admin_menu', array($this, 'register_admin_menu'), 99);
            
            // Register activation hook
            register_activation_hook(__FILE__, array($this, 'activation_hook'));
        }
        
        /**
         * Register admin menu directly from main class
         */
        public function register_admin_menu() {
            add_menu_page(
                __('Styleguide Settings', 'elementor-styleguide'),
                __('Styleguide', 'elementor-styleguide'),
                'manage_options',
                'elementor-styleguide',
                array($this->admin, 'settings_page'),
                'dashicons-art',
                30  // Posição ajustada para maior visibilidade
            );
        }
        
        /**
         * Activation hook
         */
        public function activation_hook() {
            // Sync with Elementor's global colors on activation
            $this->settings->sync_with_elementor_globals();
            
            // Clear menu cache
            delete_transient('_menu_items_cache');
            delete_transient('_wp_admin_menu_placeholder');
            
            // Force refresh
            flush_rewrite_rules();
        }
    }

    /**
     * Initialize the plugin
     */
    function elementor_styleguide_init() {
        return Elementor_Styleguide::get_instance();
    }

    // Inicia o plugin após todos os plugins estarem carregados
    add_action('plugins_loaded', 'elementor_styleguide_init', 99);
}

// Force flush rewrite rules when the plugin is activated to ensure menus are updated
register_activation_hook(__FILE__, function() {
    flush_rewrite_rules();
    
    // Limpa cache de menus
    delete_transient('_menu_items_cache');
    delete_transient('_wp_admin_menu_placeholder');
});