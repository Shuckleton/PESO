document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('select[name="applicant-status"]');

    selects.forEach(select => {
        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const selectedValue = selectedOption.value;

            // Update select box background color based on selected option
            this.style.backgroundColor = selectedValue === 'hired' ? '#289A00' : (selectedValue === 'pending' ? '#C09600' : '#fff');
            this.style.color = selectedValue === 'hired' || selectedValue === 'pending' ? 'white' : '#333';
        });
    });
});
