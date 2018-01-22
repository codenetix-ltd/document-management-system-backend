$(document).on('ready', function () {
    $('.document-remove').on('click', function (e) {
        e.preventDefault();
        if ($(this).data('disabled')) {
            toastr["warning"]($(this).data('less-than-required-text'));
        } else {
            confirmWrapper(this);
        }
    });

    var scrolling = null,
        scrollIndex = 0,
        mainContainer = $('.table-compare-wrapper'),
        widthContainer = mainContainer.width(),
        widthTable = $('.table-compare').width(),
        widthScrolling = widthTable - widthContainer,
        speed = 100;

    $('.scroll-left').hide();
    $('.scroll-right').mouseover(function () {
        var _this = $(this);
        scrolling = setInterval(function () {
            if (scrollIndex > 0) {
                $('.scroll-left').show();
            }
            if (scrollIndex > widthScrolling) {
                scrollIndex = widthScrolling;
                clearInterval(scrolling);
                _this.hide();
            }
            scrollIndex += 10
            mainContainer.scrollLeft(scrollIndex);
        }, speed);
    }).mouseout(function () {
        clearInterval(scrolling);
    });

    $('.scroll-left').mouseover(function () {
        var _this = $(this);
        scrolling = setInterval(function () {
            if (scrollIndex < widthScrolling) {
                $('.scroll-right').show();
            }
            if (scrollIndex < 0) {
                scrollIndex = 0;
                clearInterval(scrolling);
                _this.hide();
            }
            scrollIndex -= 10
            _this.parent().scrollLeft(scrollIndex);
        }, speed);
    }).mouseout(function () {
        clearInterval(scrolling);
    });


    function FixedHeader() {
        var isActive = false;
        var catchedAt = null;
        var isAttached = false;

        var wrapper = $('.table-compare-wrapper');
        var table = $('.table-compare');
        var tbody = $('.table-compare > tbody');
        var thead = $('.table-compare > thead');

        var originalWidth = null;
        var originalHeight = null;

        function getOriginalColWidths() {
            return $('th', thead).map(function (k, v) {
                return $(v).width();
            }).toArray();
        }

        function activateFixedHeader() {
            thead.removeClass('thead-fixed');
            table.css('margin-top', 0);
            isAttached = false;

            if (table.width() > wrapper.width()) {
                isActive = false;
                return;
            }

            isActive = true;
            originalWidth = thead.width();
            originalHeight = thead.height();
            var originalColWidths = getOriginalColWidths();

            $(thead).find('tr').children().each(function (k) {
                $(this).width(originalColWidths[k]);
            });

            $(tbody).children().each(function () {
                $(this).children().each(function (k) {
                    $(this).width(originalColWidths[k]);
                });
            });

            handleScroll();
        }

        function handleScroll() {
            if (!isActive) {
                return;
            }

            var eTop = thead.offset().top; //get the offset top of the element

            if ((eTop - $(window).scrollTop()) <= 0 && !isAttached) {
                catchedAt = eTop;
                isAttached = true;
                thead.addClass('thead-fixed');
                table.css('margin-top', originalHeight);
                thead.width(originalWidth);
                thead.height(originalHeight);
            }

            if ($(window).scrollTop() < catchedAt && isAttached) {
                isAttached = false;
                thead.removeClass('thead-fixed');
                table.css('margin-top', 0);
            }
        }

        $(window).on('resize', function () {
            activateFixedHeader();
        });

        $(document).on('scroll', handleScroll);

        activateFixedHeader();
    }

    new FixedHeader();
});