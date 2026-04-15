// assets/js/admin/custom-tags.js
// Custom Tags Input Implementation
(function() {
    // Wait for DOM to be fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTagsInput);
    } else {
        initTagsInput();
    }
    
    function initTagsInput() {
        const tagInputs = document.querySelectorAll('[data-role="tagsinputCustom"]');
        
        tagInputs.forEach(input => {
            // Skip if already initialized
            if (input.hasAttribute('data-tags-initialized')) return;
            input.setAttribute('data-tags-initialized', 'true');
            
            new CustomTagsInput(input, {
                duplicateAllowed: input.getAttribute('data-duplicate-allowed') === 'true',
                placeholder: input.getAttribute('data-placeholder') || input.placeholder || ''
            });
        });
    }
    
    class CustomTagsInput {
        constructor(inputElement, options = {}) {
            this.input = inputElement;
            this.options = {
                duplicateAllowed: options.duplicateAllowed || false,
                placeholder: options.placeholder || 'Add tags',
                ...options
            };
            
            this.tags = [];
            this.init();
        }
        
        init() {
            // Get existing tags from input value
            if (this.input.value) {
                this.tags = this.input.value.split(',').map(t => t.trim()).filter(t => t);
            }
            
            // Hide original input
            this.input.type = 'hidden';
            
            // Create wrapper div
            this.wrapper = document.createElement('div');
            this.wrapper.className = 'custom-tags-wrapper';
            
            // Create tags input container
            this.container = document.createElement('div');
            this.container.className = 'custom-tags-container';
            
            // Create tags area
            this.tagsArea = document.createElement('div');
            this.tagsArea.className = 'custom-tags-area';
            
            // Create input field
            this.tagInput = document.createElement('input');
            this.tagInput.type = 'text';
            this.tagInput.className = 'custom-tag-input';
            this.tagInput.placeholder = this.tags.length === 0 ? this.options.placeholder : '';
            
            // Assemble the structure
            this.container.appendChild(this.tagsArea);
            this.container.appendChild(this.tagInput);
            this.wrapper.appendChild(this.container);
            
            // Insert after the original input
            this.input.parentNode.insertBefore(this.wrapper, this.input.nextSibling);
            
            // Render existing tags
            this.renderTags();
            
            // Bind events
            this.bindEvents();
        }
        
        bindEvents() {
            // Focus on input when clicking the container
            this.container.addEventListener('click', (e) => {
                if (e.target !== this.tagInput) {
                    this.tagInput.focus();
                }
            });
            
            // Handle keydown events
            this.tagInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.addTag();
                } else if (e.key === 'Backspace' && this.tagInput.value === '' && this.tags.length > 0) {
                    this.removeTag(this.tags.length - 1);
                } else if (e.key === 'Escape') {
                    this.tagInput.value = '';
                }
            });
            
            // Handle blur event
            this.tagInput.addEventListener('blur', () => {
                if (this.tagInput.value.trim()) {
                    this.addTag();
                }
            });
            
            // Update hidden input on form submit
            if (this.input.form) {
                this.input.form.addEventListener('submit', () => {
                    this.input.value = this.tags.join(',');
                });
            }
        }
        
        addTag() {
            let tagValue = this.tagInput.value.trim();
            
            if (!tagValue) return;
            
            // Remove commas and special characters
            tagValue = tagValue.replace(/[,;]/g, '');
            
            // Check for duplicates
            if (!this.options.duplicateAllowed && this.tags.includes(tagValue)) {
                this.showError(`Tag "${tagValue}" already exists`);
                this.tagInput.value = '';
                return;
            }
            
            // Add tag (no max limit check)
            this.tags.push(tagValue);
            this.renderTags();
            this.tagInput.value = '';
            
            // Update placeholder
            this.tagInput.placeholder = this.tags.length === 0 ? this.options.placeholder : '';
        }
        
        removeTag(index) {
            this.tags.splice(index, 1);
            this.renderTags();
            
            // Update placeholder
            this.tagInput.placeholder = this.tags.length === 0 ? this.options.placeholder : '';
        }
        
        renderTags() {
            this.tagsArea.innerHTML = '';
            
            this.tags.forEach((tag, index) => {
                const tagElement = document.createElement('span');
                tagElement.className = 'custom-tag';
                
                const tagText = document.createElement('span');
                tagText.className = 'custom-tag-text';
                tagText.textContent = tag;
                
                const removeBtn = document.createElement('span');
                removeBtn.className = 'custom-tag-remove';
                removeBtn.innerHTML = '×';
                removeBtn.title = 'Remove tag';
                removeBtn.onclick = (e) => {
                    e.stopPropagation();
                    this.removeTag(index);
                };
                
                tagElement.appendChild(tagText);
                tagElement.appendChild(removeBtn);
                this.tagsArea.appendChild(tagElement);
            });
        }
        
        showError(message) {
            // Remove any existing error
            const existingError = this.wrapper.querySelector('.custom-tags-error');
            if (existingError) existingError.remove();
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'custom-tags-error';
            errorDiv.textContent = message;
            this.wrapper.appendChild(errorDiv);
            
            setTimeout(() => {
                if (errorDiv.parentNode) errorDiv.remove();
            }, 3000);
        }
        
        getTags() {
            return this.tags;
        }
        
        setTags(tags) {
            this.tags = tags;
            this.renderTags();
            this.tagInput.value = '';
            this.tagInput.placeholder = this.tags.length === 0 ? this.options.placeholder : '';
            this.input.value = this.tags.join(',');
        }
        
        clearTags() {
            this.tags = [];
            this.renderTags();
            this.tagInput.value = '';
            this.tagInput.placeholder = this.options.placeholder;
            this.input.value = '';
        }
    }
})();