// Item Post JavaScript functionality

// Function to handle form submission with validation
function handleItemPost() {
    const form = document.getElementById('itemForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const lat = document.getElementById('lat').value;
            const lng = document.getElementById('lng').value;
            const type = document.getElementById('type').value;
            const description = document.getElementById('description').value;
            const pic = document.getElementById('pic').files[0];

            // Validate required fields
            if (!type || !description || !pic) {
                e.preventDefault();
                showToast('Please fill in all required fields');
                return false;
            }

            // Validate location selection
            if (!lat || !lng) {
                e.preventDefault();
                showToast('Please select a location on the map');
                return false;
            }

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!allowedTypes.includes(pic.type)) {
                e.preventDefault();
                showToast('Please upload a valid image file (JPEG, JPG, or PNG)');
                return false;
            }

            // Validate file size (max 2MB)
            if (pic.size > 2 * 1024 * 1024) {
                e.preventDefault();
                showToast('File size exceeds 2MB limit');
                return false;
            }

            return true;
        });
    }
}

// Toast notification function
function showToast(msg) {
    const toast = document.getElementById('toast');
    if (toast) {
        document.getElementById('toastMsg').textContent = msg;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 3000);
    }
}

// File upload preview
function setupFileUpload() {
    const fileInput = document.getElementById('pic');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const uploadContainer = document.getElementById('uploadContainer');

    if (fileInput && fileNameDisplay && uploadContainer) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.classList.remove('hidden');
                uploadContainer.classList.add('border-green-400', 'bg-green-50');
            } else {
                fileNameDisplay.classList.add('hidden');
                uploadContainer.classList.remove('border-green-400', 'bg-green-50');
            }
        });
    }
}

// Ethics agreement checkbox handling
function setupEthicsAgreement() {
    const chk = document.getElementById('ethicsAgreement');
    const btn = document.getElementById('confirmBtn');
    
    if (chk && btn) {
        chk.addEventListener('change', function() {
            btn.disabled = !this.checked;
        });
    }
}

// Ethics modal functions
function showEthicsModal() {
    const modal = document.getElementById('ethicsModal');
    if (modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('opacity-100');
        }, 10);
    }
}

function hideEthicsModal() {
    const modal = document.getElementById('ethicsModal');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('opacity-100');
        
        const chk = document.getElementById('ethicsAgreement');
        const btn = document.getElementById('confirmBtn');
        
        if (chk) chk.checked = false;
        if (btn) btn.disabled = true;
    }
}

function submitForm() {
    document.getElementById('itemForm').submit();
}

// AI Override modal functions
function showAiOverrideModal() {
    const modal = document.getElementById('ai-override-modal');
    if (modal) {
        modal.classList.remove('hidden');
    }
}

function closeAiOverrideModal() {
    const modal = document.getElementById('ai-override-modal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Initialize all functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    handleItemPost();
    setupFileUpload();
    setupEthicsAgreement();
    
    // Check if AI labels are available and show modal
    if (window.Laravel && window.Laravel.hasImageLabels) {
        showAiOverrideModal();
    }
});