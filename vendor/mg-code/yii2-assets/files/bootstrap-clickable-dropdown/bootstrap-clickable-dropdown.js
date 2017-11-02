(function ($) {
    var bindEvent = function () {
        $('.dropdown-menu[data-clickable=true]')
            .off('click.btDropdownClickable')
            .on('click.btDropdownClickable', function (e) {
                if ($(e.target).data('toggle') != 'close') {
                    e.stopPropagation();
                }
            });
    };
    $('body').on('show.bs.dropdown', function (e) {
        bindEvent();
    });
})(jQuery);