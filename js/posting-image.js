function displayImage(event, previewId, textClass) {
    const input = event.target;
    const reader = new FileReader();
    
    reader.onload = function() {
        const dataURL = reader.result;
        const output = document.getElementById(previewId);
        output.src = dataURL;
        output.style.display = 'block';
        document.querySelector(textClass).style.display = 'none';
    };
    
    // Check if there's a file selected; if not, clear the image
    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    } else {
        const output = document.getElementById(previewId);
        output.src = '';
        output.style.display = 'none';
        document.querySelector(textClass).style.display = 'block';
    }
}

// Function to handle click on the image to trigger file input click
function clickImageUpload(inputId) {
    document.getElementById(inputId).click();
}

// Add event listeners for both job image and company logo inputs
document.getElementById('job-image').addEventListener('change', function(event) {
    displayImage(event, 'job-image-preview', '.upload-job-image-wrapper .upload-logo-text');
});

document.getElementById('company-logo').addEventListener('change', function(event) {
    displayImage(event, 'company-logo-preview', '.upload-logo-wrapper .upload-logo-text');
});

// Add click event listener to job image preview to trigger file input click
document.getElementById('job-image-preview').addEventListener('click', function() {
    clickImageUpload('job-image');
});

// Add click event listener to company logo preview to trigger file input click
document.getElementById('company-logo-preview').addEventListener('click', function() {
    clickImageUpload('company-logo');
});
