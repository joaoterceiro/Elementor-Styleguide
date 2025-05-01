/**
 * Admin JavaScript for Elementor Styleguide
 */
(function($) {
  'use strict';
  
  $(document).ready(function() {
      // Initialize color pickers
      $(".color-picker").wpColorPicker({
          change: function(event, ui) {
              $(this).next(".color-picker-hex").val(ui.color.toString());
              updateColorPreview($(this));
          }
      });
      
      // Hex input synchronization
      $(".color-picker-hex").on("input", function() {
          var hexColor = $(this).val();
          if(/^#[0-9A-F]{6}$/i.test(hexColor)) {
              $(this).prev(".color-picker").wpColorPicker("color", hexColor);
              updateColorPreview($(this).prev(".color-picker"));
          }
      });
      
      // Reset individual color
      $(".reset-color").on("click", function() {
          var defaultColor = $(this).data("default");
          var colorPicker = $(this).closest(".color-field").find(".color-picker");
          var hexInput = $(this).closest(".color-field").find(".color-picker-hex");
          
          colorPicker.wpColorPicker("color", defaultColor);
          hexInput.val(defaultColor);
          updateColorPreview(colorPicker);
      });
      
      // Reset all colors
      $("#reset-all-colors").on("click", function() {
          if (confirm(elementorStyleguide.resetConfirm)) {
              $.each(elementorStyleguide.defaultColors, function(key, value) {
                  var colorPicker = $("#" + key);
                  var hexInput = colorPicker.next(".color-picker-hex");
                  
                  colorPicker.wpColorPicker("color", value);
                  hexInput.val(value);
                  updateColorPreview(colorPicker);
              });
          }
      });
      
      // Export settings
      $("#export-settings").on("click", function() {
          var formData = $("form").serialize();
          $("#export-data").val(formData);
          $("#export-result").show();
      });
      
      // Import settings button
      $("#import-settings-btn").on("click", function() {
          $("#import-container").toggle();
      });
      
      // Process import
      $("#process-import").on("click", function() {
          var importData = $("#import-data").val();
          if (!importData) {
              alert("Please paste settings data first");
              return;
          }
          
          try {
              // Parse the import data
              var parsedData = {};
              var pairs = importData.split("&");
              
              for (var i = 0; i < pairs.length; i++) {
                  var pair = pairs[i].split("=");
                  var key = decodeURIComponent(pair[0]);
                  var value = decodeURIComponent(pair[1] || "");
                  
                  if (key.indexOf("elementor_styleguide_colors") !== -1) {
                      var colorKey = key.match(/\[(.*?)\]/)[1];
                      var colorPicker = $("#" + colorKey);
                      var hexInput = colorPicker.next(".color-picker-hex");
                      
                      if (colorPicker.length && hexInput.length) {
                          colorPicker.wpColorPicker("color", value);
                          hexInput.val(value);
                          updateColorPreview(colorPicker);
                      }
                  }
              }
              
              alert("Settings imported successfully!");
          } catch (e) {
              alert("Error parsing import data: " + e.message);
          }
      });
      
      // Function to update color preview
      function updateColorPreview(colorPicker) {
          var color = colorPicker.wpColorPicker("color");
          var preview = colorPicker.closest(".color-field").find(".color-preview");
          
          if (preview.length) {
              preview.css("background-color", color);
          }
      }
      
      // Tab navigation
      $(".nav-tab").on("click", function(e) {
          e.preventDefault();
          var target = $(this).attr("href");
          
          // Update active tab
          $(".nav-tab").removeClass("nav-tab-active");
          $(this).addClass("nav-tab-active");
          
          // Show corresponding content
          $(".tab-content").hide();
          $(target).show();
      });
  });
})(jQuery);