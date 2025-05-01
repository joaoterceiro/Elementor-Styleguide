<?php
/**
 * Usage guide in English
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="usage-guide" style="margin-top: 30px; padding: 20px; background: #fff; border: 1px solid #ccd0d4; box-shadow: 0 1px 1px rgba(0,0,0,.04);">
    <h2><?php _e('Usage Guide', 'elementor-styleguide'); ?></h2>
    
    <h3><?php _e('How to Use Colors', 'elementor-styleguide'); ?></h3>
    <p><?php _e('Add these classes to Elementor elements:', 'elementor-styleguide'); ?></p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>color-primary</code>, <code>color-primary-light</code>, <code>color-primary-dark</code> - <?php _e('For primary text colors', 'elementor-styleguide'); ?></li>
        <li><code>color-secondary</code>, <code>color-secondary-light</code>, <code>color-secondary-dark</code> - <?php _e('For secondary text colors', 'elementor-styleguide'); ?></li>
        <li><code>color-accent</code>, <code>color-accent-light</code>, <code>color-accent-dark</code> - <?php _e('For accent/highlight text colors', 'elementor-styleguide'); ?></li>
        <li><code>color-success</code>, <code>color-warning</code>, <code>color-danger</code>, <code>color-info</code> - <?php _e('For status text colors', 'elementor-styleguide'); ?></li>
        <li><code>bg-primary</code>, <code>bg-primary-light</code>, <code>bg-primary-dark</code> - <?php _e('For primary background colors', 'elementor-styleguide'); ?></li>
        <li><code>bg-secondary</code>, <code>bg-secondary-light</code>, <code>bg-secondary-dark</code> - <?php _e('For secondary background colors', 'elementor-styleguide'); ?></li>
        <li><code>bg-accent</code>, <code>bg-accent-light</code>, <code>bg-accent-dark</code> - <?php _e('For accent/highlight background colors', 'elementor-styleguide'); ?></li>
        <li><code>bg-success</code>, <code>bg-warning</code>, <code>bg-danger</code>, <code>bg-info</code> - <?php _e('For status background colors', 'elementor-styleguide'); ?></li>
        <li><code>color-gray-100</code> to <code>color-gray-900</code> - <?php _e('For grayscale text', 'elementor-styleguide'); ?></li>
        <li><code>bg-gray-100</code> to <code>bg-gray-900</code> - <?php _e('For grayscale backgrounds', 'elementor-styleguide'); ?></li>
        <li><code>border-primary</code>, <code>border-secondary</code>, etc. - <?php _e('For colored borders', 'elementor-styleguide'); ?></li>
    </ul>
    
    <h3><?php _e('How to Use Typography', 'elementor-styleguide'); ?></h3>
    <p><?php _e('Font size classes:', 'elementor-styleguide'); ?></p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>display-large</code> - <?php _e('80px (64px tablet, 48px mobile)', 'elementor-styleguide'); ?></li>
        <li><code>display-small</code> - <?php _e('72px (56px tablet, 40px mobile)', 'elementor-styleguide'); ?></li>
        <li><code>heading-h1</code> to <code>heading-h6</code> - <?php _e('Hierarchical headings', 'elementor-styleguide'); ?></li>
        <li><code>text-xl</code> - <?php _e('18px', 'elementor-styleguide'); ?></li>
        <li><code>text-lg</code> - <?php _e('16px', 'elementor-styleguide'); ?></li>
        <li><code>text-md</code> - <?php _e('14px', 'elementor-styleguide'); ?></li>
        <li><code>text-sm</code> - <?php _e('12px', 'elementor-styleguide'); ?></li>
    </ul>

    <p><?php _e('Font weight classes:', 'elementor-styleguide'); ?></p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>font-regular</code> - <?php _e('Weight 400', 'elementor-styleguide'); ?></li>
        <li><code>font-medium</code> - <?php _e('Weight 500', 'elementor-styleguide'); ?></li>
        <li><code>font-semibold</code> - <?php _e('Weight 600', 'elementor-styleguide'); ?></li>
        <li><code>font-bold</code> - <?php _e('Weight 700', 'elementor-styleguide'); ?></li>
    </ul>
    
    <p><?php _e('Line height classes:', 'elementor-styleguide'); ?></p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>lh-tight</code> - <?php _e('Line height 1.2', 'elementor-styleguide'); ?></li>
        <li><code>lh-normal</code> - <?php _e('Line height 1.5', 'elementor-styleguide'); ?></li>
        <li><code>lh-loose</code> - <?php _e('Line height 1.8', 'elementor-styleguide'); ?></li>
    </ul>
    
    <p><?php _e('Text alignment classes:', 'elementor-styleguide'); ?></p>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><code>text-left</code>, <code>text-center</code>, <code>text-right</code>, <code>text-justify</code></li>
    </ul>

    <h3><?php _e('How to Apply', 'elementor-styleguide'); ?></h3>
    <ol style="margin-left: 20px;">
        <li><?php _e('In the Elementor editor, select the element you want to style', 'elementor-styleguide'); ?></li>
        <li><?php _e('In the "Advanced" tab, find the "CSS Classes" field', 'elementor-styleguide'); ?></li>
        <li><?php _e('Add the desired classes (for example: "color-primary font-bold")', 'elementor-styleguide'); ?></li>
    </ol>
    
    <h3><?php _e('Usage Examples', 'elementor-styleguide'); ?></h3>
    <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 15px;">
        <p><strong><?php _e('For a large primary heading:', 'elementor-styleguide'); ?></strong></p>
        <code>heading-h1 color-primary font-bold</code>
        
        <p style="margin-top: 15px;"><strong><?php _e('For a secondary button background:', 'elementor-styleguide'); ?></strong></p>
        <code>bg-secondary text-lg font-semibold</code>
        
        <p style="margin-top: 15px;"><strong><?php _e('For an alert or notice:', 'elementor-styleguide'); ?></strong></p>
        <code>bg-warning color-gray-900 text-md lh-normal</code>
    </div>
    
    <h3><?php _e('Tips & Best Practices', 'elementor-styleguide'); ?></h3>
    <ul style="list-style-type: disc; margin-left: 20px;">
        <li><?php _e('Maintain consistency by using the same color variants across your site', 'elementor-styleguide'); ?></li>
        <li><?php _e('Use the grayscale colors for most of your content and the accent colors sparingly', 'elementor-styleguide'); ?></li>
        <li><?php _e('Combine multiple classes to achieve the desired style', 'elementor-styleguide'); ?></li>
        <li><?php _e('Use status colors appropriately to convey meaning (success, warning, etc.)', 'elementor-styleguide'); ?></li>
    </ul>
</div>