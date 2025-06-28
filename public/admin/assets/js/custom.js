//  <!-- submit click disable button -->
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('productForm');
    const button = document.getElementById('submitBtn');

    if (form && button) {
        form.addEventListener('submit', function () {
            button.disabled = true;
            button.innerText = 'Please wait...';
        });
    }
});

// images preview
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('imagePreviewContainer');

    imageInput.addEventListener('change', function () {
        previewContainer.innerHTML = ''; // Clear old previews

        Array.from(this.files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.maxWidth = '100px';
                    img.style.marginRight = '10px';
                    img.style.marginBottom = '10px';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
});



