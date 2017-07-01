(function (exports) {
'use strict';

(function ($) {
    var $body = $('body');

    $body.on('click', '.trigger-import', function (event) {
        var $form = $(this).closest('form');
        $form.find('input[type=file]').val('');
    });

    $body.on('change', 'form.import-field-group input[type=file]', function (event) {
        var $form = $(this).closest('form');
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.readAsText(file);
            reader.onload = function(e) {
                var json = Helpers.jsonDecode(e.target.result);
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: {
                        json_data: json,
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        WebEd.showLoading();
                    },
                    success: function (res) {
                        WebEd.showNotification(res.messages, (res.error ? 'error' : 'success'));
                        if (!res.error) {
                            var dataTableHelper = $('table.datatables')[0].dataTableHelper;
                            if (dataTableHelper) {
                                dataTableHelper.getDataTable().ajax.reload();
                            }
                        }
                    },
                    complete: function (data) {
                        WebEd.hideLoading();
                    },
                    error: function (data) {
                        WebEd.showNotification('Some error occurred', 'error');
                    }
                });
            };
        }
    });
}(jQuery));

}((this.LaravelElixirBundle = this.LaravelElixirBundle || {})));
//# sourceMappingURL=import-field-group.js.map
