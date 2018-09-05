// trigger on browse button click
function imageUpload(fileInputNumber) {
    // check which input file button was clicked
    $(document).on('change', '.btn-file' + fileInputNumber + ' :file', function () {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $('.btn-file' + fileInputNumber + ' :file').on('fileselect', function (event, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }

    });

    // get image url
    $("#imgInp" + fileInputNumber).change(function () {
        readURL(this);
    });

    // preview the image
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-upload' + fileInputNumber).attr('src', e.target.result).css({
                    "width": "25vw",
                    "height": "25vh"
                });
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
}
