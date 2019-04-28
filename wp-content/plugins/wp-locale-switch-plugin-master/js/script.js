jQuery(document).ready(function ($) {
    function switchLanguage() {
        var uri = window.location.href;
        var data = {
            action: 'wlsp_set_locale',
            uri: uri,
            nonce: wlspOptions.nonce
        };
        data[wlspOptions.langKey] = $(this).val();
        $.ajax({
            url: wlspOptions.ajaxurl,
            data: data,
            success: function (response) {
                // window.location.href = response;
                window.location.reload();
            }
        });
    }

    $(document).on("change", ".wlsp-language-switch", switchLanguage);
});