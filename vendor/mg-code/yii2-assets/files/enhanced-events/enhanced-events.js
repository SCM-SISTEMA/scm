(function () {
    var timeout = null;
    document.addEventListener('scroll', function () {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            var event;
            if (document.createEvent) {
                event = document.createEvent("Event");
                event.initEvent("scrollEnd", true, true);
            } else {
                event = document.createEventObject();
                event.eventType = "scrollEnd";
            }
            event.eventName = "scrollEnd";
            if (document.createEvent) {
                document.dispatchEvent(event);
            } else {
                document.fireEvent("on" + event.eventType, event);
            }
        }, 50);
    });
})();