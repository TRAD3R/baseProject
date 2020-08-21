var Helper = {
    /**
     * No conflict with JqueryUI datepicker
     * @param selector
     * @param options
     */
    bsDatePicker:  function (selector, options) {
        var main_options = {language: 'en', format: 'yyyy-mm-dd', weekStart: 1};
        if (options !== undefined && Object.keys(options).length > 0) {
            for (var prop in options) {
                if (options.hasOwnProperty(prop)) {
                    main_options[prop] = options[prop];
                }
            }
        }
        $(selector).noConflictDatepicker(main_options);
    },
    init:          function () {
        $('select.select2').select2({width: 'resolve'});

        var table_responsive = $('.table-responsive');

        $(document).on('shown.bs.dropdown', '.table-responsive .drop-down-push-footer', function () {
            if(table_responsive.hasScrollBar()) {
                table_responsive.css('padding-bottom', 135);
            }
        }).on('hide.bs.dropdown', '.drop-actions', function () {
            table_responsive.css('padding-bottom', 0);
        });
    }
};

$.fn.noConflictDatepicker = $.fn.datepicker.noConflict();

$.fn.hasScrollBar = function() {
    return this.get(0).scrollHeight > this.height();
};

$(function () {
    Helper.init();
});