(function( $ ) {
    $.widget("metro.accordion", {

        version: "1.0.0",

        options: {
            closeAny: true,
            open: function(frame){},
            action: function(frame){}
        },

        _frames: {},

        _create: function(){
            var element = this.element;

            if (element.data('closeany') != undefined) this.options.closeAny = element.data('closeany');

            this._frames = element.children(".frame");

            this.init();
        },

        init: function(){
            var that = this;

            this._frames.each(function(){
                var frame = this,
                    a = $(this).children(".heading"),
                    content = $(this).children(".content");

                if ($(a).hasClass("active")) {
                    $(content).show();
                }

                a.on('click', function(e){
                    e.preventDefault();

                    if (that.options.closeAny) that._closeFrames();

                    if ($(content).is(":hidden")) {
                        $(content).slideDown();
                        that._trigger("frame", event, {frame: frame});
                        that.options.open(frame);
                    } else {
                        $(content).slideUp();
                    }
                    that.options.action(frame);
                });
            });
        },

        _closeFrames: function(){
            this._frames.children(".content").slideUp();
        },

        _destroy: function(){},

        _setOption: function(key, value){
            this._super('_setOption', key, value);
        }
    })
})( jQuery );

$(function(){
    $('[data-role=accordion]').accordion();
});