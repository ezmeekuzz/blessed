function handleFiles(files) {
    const fileListContainer = document.getElementById('dynamicFileList');
    if (files.length > 0) {
        let fileNames = [];
        for (let i = 0; i < Math.min(files.length, 3); i++) {
            fileNames.push(files[i].name);
        }
        let extra = files.length > 3 ? ` and ${files.length-3} more` : '';
        fileListContainer.innerHTML = `
            <span><i class="fas fa-file me-2"></i>${fileNames.join(', ')} ${extra}</span>
            <span class="badge bg-light text-dark px-4 py-2 rounded-pill">${(files[0].size / 1024).toFixed(0)} KB</span>
        `;
    } else {
        fileListContainer.innerHTML = `<span class="text-muted fst-italic"><i class="fas fa-file me-2"></i>No files chosen</span>
            <span class="badge bg-light text-dark px-4 py-2 rounded-pill">max 50 MB</span>`;
    }
}

// Ensure click on upload area triggers file input even if user clicks inside (but not on buttons)
document.querySelector('.upload-area')?.addEventListener('click', function(e) {
    // If the click target is a button or inside button, we already have specific handler, but we stop propagation on buttons.
    if (e.target.tagName === 'BUTTON' || e.target.closest('button')) {
        // let the button handle it
        return;
    }
    document.getElementById('fileInput').click();
});
        
// Make all template cards in explore-templates-section clickable
document.addEventListener('DOMContentLoaded', function() {
    // Get all template cards in the explore templates section
    const templateCards = document.querySelectorAll('.explore-templates-section .template-card');
    
    // Add click event to each card
    templateCards.forEach(card => {
        card.addEventListener('click', function() {
            // Get the template title
            const titleElement = this.querySelector('h5');
            const title = titleElement ? titleElement.textContent.trim() : 'Vision Board';
            
            // Get the template image
            const imgElement = this.querySelector('img');
            const imgSrc = imgElement ? imgElement.src : 'images/front-mug.png';
            
            // Update modal with template data
            updateTemplateModal(title, imgSrc);
            
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('templatePreviewModal'));
            modal.show();
        });
        
        // Add cursor pointer to indicate clickability
        card.style.cursor = 'pointer';
    });
});

// Function to update modal content based on selected template
function updateTemplateModal(title, imgSrc) {
    // Update modal title
    document.getElementById('templatePreviewModalLabel').textContent = title + ' Photo Collage';
    document.getElementById('modalTemplateTitle').textContent = title;
    document.getElementById('modalTemplateImage').src = imgSrc;
    
    // Set dimensions based on template type (you can customize this logic)
    let dimensions = 'Photo Collage (Portrait) 20 X 30 Cm';
    if (title.includes('Bible')) {
        dimensions = 'Bible Cover (Standard) 18 X 24 Cm';
    } else if (title.includes('Mug')) {
        dimensions = 'Mug (11oz) 8 X 8 Cm';
    } else if (title.includes('Journal')) {
        dimensions = 'Journal (A5) 15 X 21 Cm';
    } else if (title.includes('Phone')) {
        dimensions = 'Phone Case (Universal) 7 X 14 Cm';
    }
    
    document.getElementById('modalTemplateDimensions').textContent = dimensions;
}

// Function to handle customize button click
function customizeTemplate() {
    const modal = bootstrap.Modal.getInstance(document.getElementById('templatePreviewModal'));
    modal.hide();
    
    // You can add your customization logic here
    // For example, redirect to a customization page or open another modal
    console.log('Customize template clicked');
    
    // Show a success message or trigger customization workflow
    alert('Starting template customization...');
}

// Function to handle related template selection
function selectRelatedTemplate(templateName) {
    console.log('Selected related template:', templateName);
    
    // Update the main modal with the selected related template
    document.getElementById('templatePreviewModalLabel').textContent = templateName + ' Template';
    document.getElementById('modalTemplateTitle').textContent = templateName;
    
    // You can also update the image based on the selected template
    // For now, we'll keep the same image
    
    // Optional: Add visual feedback
    const modal = bootstrap.Modal.getInstance(document.getElementById('templatePreviewModal'));
    // Keep modal open, just update content
}

// Optional: Add keyboard support for modal navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('templatePreviewModal');
        if (modal.classList.contains('show')) {
            const modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide();
        }
    }
});