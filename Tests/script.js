document.addEventListener('DOMContentLoaded', function() {
    var dropzone = document.getElementById('dropzone');
    var preview = document.getElementById('preview');

    dropzone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropzone.classList.add('highlight');
    });

    dropzone.addEventListener('dragleave', function() {
        dropzone.classList.remove('highlight');
    });

    dropzone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropzone.classList.remove('highlight');

        var file = e.dataTransfer.files[0];
        handleFile(file);
    });

    dropzone.addEventListener('click', function() {
        var input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = function(e) {
            var file = e.target.files[0];
            handleFile(file);
        };
        input.click();
    });

    function handleFile(file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(file);
    }
});
