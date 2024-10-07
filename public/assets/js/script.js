// Menu toggle
let toggle = $('.toggle');
let navigation = $('.navigation');
let main = $('.main');

toggle.on('click', function () {
    navigation.toggleClass('active_nav');
    main.toggleClass('active_main');
});
if ($('#logout-link')) {
    $('#logout-link').on('click', function (e) {
        e.preventDefault();
        $('#logout-form').submit();
    });
}

if ($('ckeditor')) {
    CKEDITOR.replace('ckeditor');
}
if ($('ckeditor2')) {
    CKEDITOR.replace('ckeditor2');
}
