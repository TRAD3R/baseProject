var SelectAjax = {
    init: function() {
        this.selects = $('select[data-select-type="ajax"]').not('.no-select2');
        for (var i = 0; i < this.selects.length; i++) {
            if (!$(this.selects[i]).data('backend')) {
                this.selects.splice(i, 1);
            }
        }

        if (this.selects.length === 0) return false;

        for (i = 0; i < this.selects.length; i++) {
            var current_select = $(this.selects[i]);
            if (current_select.data('submit-on-enter')) {
                current_select.wrap('<div class="select2-event-container"></div>');
            }
            current_select.select2({
                width: '100%',
                ajax: {
                    delay: 250,
                    url: current_select.data('backend'),
                    data: function (params) {
                        var nested_select = $(this).data('nested-select') !== undefined ? $('#' + $(this).data('nested-select')) : null;
                        var enable_constraint = $(this).attr('data-enable-constraint') !== undefined ? $(this).attr('data-enable-constraint') : 0;
                        var request = {'value': params.term, 'enable_constraint': enable_constraint};
console.log(request);
                        if(nested_select) {
                            if(nested_select.val() && nested_select.val() !== undefined) {
                                request['nested_id'] = nested_select.val();
                            } else {
                                return false;
                            }
                        }

                        return request;
                    }
                }
            });

            if (!current_select.attr('multiple')) {
                current_select.on('select2:select', function () {
                    $(this).closest('form').find('[type="submit"]').focus();
                })
            }
        }

        $(document).on('keyup','.select2-event-container .select2-search__field', function (ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            var select2 = $(this).closest('.select2-event-container').find('select');
            if (keycode === 13) {
                if (select2.data('wait-submit') === 1) {
                    select2.closest('form').submit()
                } else {
                    select2.data('wait-submit', 1);
                }
            } else {
                select2.data('wait-submit', 0);
            }
        });
    }
};
if (typeof jQuery === "undefined") {
    console.error('Init Jquery first. Ajax Chosen requires Jquery.');
} else {
    $(function () {
        SelectAjax.init();
    });
}
