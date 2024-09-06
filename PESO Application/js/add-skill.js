function addSkill() {
    const skillItem = document.createElement('div');
    skillItem.classList.add('skill-item');

    const skillInput = document.createElement('input');
    skillInput.type = 'text';
    skillInput.name = 'skills[]';
    skillInput.required = true;

    const removeButton = document.createElement('img');
    removeButton.src = 'img/remove-button.png';
    removeButton.alt = 'Remove';
    removeButton.classList.add('remove-button');
    removeButton.addEventListener('click', function() {
        skillItem.remove();
    });

    skillItem.appendChild(skillInput);
    skillItem.appendChild(removeButton);

    const skillsList = document.getElementById('skillsList');
    skillsList.appendChild(skillItem);
}

function displayImage(event, imgPreviewId, textSelector) {
    const input = event.target;
    const preview = document.getElementById(imgPreviewId);
    const textElement = document.querySelector(textSelector);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            textElement.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}



