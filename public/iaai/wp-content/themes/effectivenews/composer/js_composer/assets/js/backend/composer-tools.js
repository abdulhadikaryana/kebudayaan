(function ($) {
    $.log = function (text) {
        if (typeof(window.console) !== 'undefined' && window.console.log) window.console.log(text);
    };
    $.expr[':'].containsi = function (a, i, m) {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };

    window.vc_get_column_size = function ($column) {
        if ($column.hasClass("vc_span12")) //full-width
            return "1/1";
        else if ($column.hasClass("vc_span10")) //three-fourth
            return "5/6";
        else if ($column.hasClass("vc_span9")) //three-fourth
            return "3/4";
        else if ($column.hasClass("vc_span8")) //two-third
            return "2/3";
        else if ($column.hasClass("vc_span6")) //one-half
            return "1/2";
        else if ($column.hasClass("vc_span4")) // one-third
            return "1/3";
        else if ($column.hasClass("vc_span3")) // one-fourth
            return "1/4";
        else if ($column.hasClass("vc_span2")) // one-fourth
            return "1/6";
        else
            return false;
    };
})(window.jQuery);


function vc_convert_column_size(width) {
    if (width == '5/6') //three-fourth
        return "vc_span10";
    else if (width == '3/4') //three-fourth
        return "vc_span9";
    else if (width == '2/3') //two-third
        return "vc_span8";
    else if (width == '1/2') //one-half
        return "vc_span6";
    else if (width == '1/3') // one-third
        return "vc_span4";
    else if (width == '1/4') // one-fourth
        return "vc_span3";
    else if (width == '1/6') // one-fourth
        return "vc_span2";
    else
        return 'vc_span12';
}
;

/**
 * Create Unique id for records in storage.
 * Generate a pseudo-GUID by concatenating random hexadecimal.
 * @return {String}
 */
function vc_guid() {
    return (VCS4() + VCS4() + "-" + VCS4());
}

// Generate four random hex digits.
function VCS4() {
    return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
}

/**
 * Taxonomies filter
 *
 * Show or hide taxonomies depending on selected post types

 * @param $element - post type checkbox object
 * @param $object -
 */
var wpb_grid_post_types_for_taxonomies_handler = function () {
    var $labels = this.$content.find('.wpb_el_type_taxonomies label[data-post-type]'),
        $ = jQuery;
    $labels.hide();
    $('.grid_posttypes:checkbox', this.$content).change(function () {
        if ($(this).is(':checked')) {
            $labels.filter('[data-post-type=' + $(this).val() + ']').show();
        } else {
            $labels.filter('[data-post-type=' + $(this).val() + ']').hide();
        }
    }).each(function () {
            if ($(this).is(':checked')) $labels.filter('[data-post-type=' + $(this).val() + ']').show();
        });
};
var wpb_single_image_img_link_dependency_callback = function () {
    var $img_link_large = this.$content.find('#img_link_large-yes'),
        $ = jQuery,
        $img_link_target = this.$content.find('[name=img_link_target]').closest('.vc_row-fluid');
    this.$content.find('#img_link_large-yes').change(function () {
        var checked = $(this).is(':checked');
        if (checked) {
            $img_link_target.show();
        } else {
            if ($('.wpb-edit-form [name=img_link]').val().length > 0) {
                $img_link_target.show();
            } else {
                $img_link_target.hide();
            }
        }
    });
    if (this.$content.find('#img_link_large-yes').is(':checked')) {
        $img_link_target.show();
    } else {
        if ($('.wpb-edit-form [name=img_link]').val().length > 0) {
            $img_link_target.show();
        } else {
            $img_link_target.hide();
        }
    }
};
