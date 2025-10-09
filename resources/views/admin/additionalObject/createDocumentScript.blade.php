<!-- Summernote -->
<script src="{{asset('assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- Page specific script -->
<script>
    var loadFile = function(event) {
        $('#output').show();
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
    $(function () {
        // Summernote
        $('#summernote').summernote();
        
        // Initialize Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            width: '100%',
            tags: true,
            allowClear: true,
            placeholder: 'Select an option',
        });
    });

    function slugify(text) {
        return text
        .toString()                     // Cast to string
        .toLowerCase()                  // Convert the string to lowercase letters
        .normalize('NFD')       // The normalize() method returns the Unicode Normalization Form of a given string.
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '-')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')        // Replace multiple - with single -
        .replace(/\&\&+/g, '-')        // Replace multiple & with single -
        .replace(/\_\_+/g, '-')        // Replace multiple & with single -
        
        .trim();                         // Remove whitespace from both sides of a string
    }

    function listingslug(text) {
        document.getElementById("slug").value = slugify(text); 
    }
</script>