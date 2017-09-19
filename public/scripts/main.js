var app = null;

$(function(){
    bootbox.setDefaults({
        locale: "de"
    });



    function Page() {

        var self = this;

        this.initAjax = function()
        {
            $(document).on('click', 'a.loadAjax:not(a.deleterow)', this.loadContainer);
            $(document).on('submit', 'form.loadAjax', this.loadContainer);
        };

        this.initPlugins = function()
        {
            this.initSwitch();
            this.initMultiple();
            this.initListOptionForm();
            this.initFileUpload();
        }

        this.initFileUpload = function()
        {
            if($.isFunction($.fn.fileinput)) {
                $('.fileinput').fileinput({
                    allowedFileExtensions: ['xlsx', 'csv', 'ods'],
                    showCaption: false,
                    showPreview: false,
                    language: $(this).data('language')
                });
            }
        };

        this.initSwitch = function()
        {
            if($.isFunction($.fn.bootstrapSwitch)) {
                $('.bootstrap-switch').bootstrapSwitch();
            }
        };

        this.initMultiple = function()
        {
            if ($.isFunction($.fn.multiSelect)) {
                $('.splitselect').multiSelect();
            }
        }

        this.initConfirmDelete = function() {
            var that = this;

            $('a.deleterow')
                .off('click', this.confirmDelete)
                .on('click', this.confirmDelete);

            $(document).on('loaded.rs.jquery.bootgrid', function(e) {
                $('a.deleterow')
                    .off('click', that.confirmDelete)
                    .on('click', that.confirmDelete);
            });
        };

        /**
         * opens a modal with delete yes/no
         * if yes, then it changes the location to the link location,
         * or sends an ajax request and deletes data-remove-parent=".selector" if link has data-ajax="true"
         */
        this.confirmDelete = function(e)
        {
            e.preventDefault();
            var $this = $(this);
            bootbox.confirm(translations.confirm_delete, function(result){
                if (result) {
                    if ($this.hasClass('loadAjax')) {
                        $this.removeClass('deleterow');
                        $this.trigger('click');
                    } else if($this.hasClass('ajax')) {
                        $.get($this.attr('href'));
                        $this.parents($this.data('removeParent')).remove();
                    } else {
                        document.location.href = $this.attr('href');
                    }
                }
            });
        };

        this.loadContainer = function(e) {
            e.preventDefault();
            var $this = $(this);

            var container = $this.data('target-container');
            var useOverlay = $this.data('display-overlay');

            if (useOverlay === undefined) {
                useOverlay = true;
            }

            if (useOverlay) {
                self.addLoadingOverlay(container);
            }

            if ($this.is('form') && e.type == 'submit')
            {
                href = $this.attr('action');
                data = $this.serializeArray();

                $.post(href, data, function(result) {
                    $(container).html(result);
                    self.initConfirmDelete();
                    self.initPlugins();
                    if (useOverlay) {
                        self.removeLoadingOverlay(container);
                    }
                });

            } else if ($this.is('a') && e.type == 'click') {
                href = $this.attr('href');

                $.get(href, function(result) {
                    $(container).html(result);
                    self.initConfirmDelete();
                    self.initPlugins();
                    if (useOverlay) {
                        self.removeLoadingOverlay(container);
                    }
                });
            }
        };

        this.addLoadingOverlay = function(container)
        {
            $(container + ' .box').append($('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'));
        };

        this.removeLoadingOverlay = function(container)
        {
            $(container + ' .box').find('.overlay').remove();
        };


        this.initListOptionForm = function ()
        {
            var $typeField = $('#list_option_type');

            $typeField.change(function() {
                var $form = $(this).closest('form');
                var data = {};
                data[$typeField.attr('name')] = $typeField.val();

                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    data: data,
                    success: function(html) {
                        $('#list_option_optionValues').replaceWith(
                            $(html).find('#list_option_optionValues')
                        );
                    }
                });
            });

        };


        this.init = function() {
            this.initConfirmDelete();
            this.initAjax();
            this.initPlugins();
        }
    }


    app = new Page();
    app.init();
});
