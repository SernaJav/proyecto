/**
 * =========================
 * Image Preview for Products
 * =========================
 * Maneja la previsualización de imágenes en el formulario de productos
 */

document.addEventListener('DOMContentLoaded', function() {
    // Verificar si existe el input de imagen
    const imageInput = document.getElementById('imagen');
    if (!imageInput) {
        return;
    }

    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewPlaceholder = document.getElementById('imagePreviewPlaceholder');
    const imagePreviewWrapper = document.getElementById('imagePreviewWrapper');
    const customFileLabel = document.querySelector('.custom-file-label[for="imagen"]');
    
    let imageStatusText = null;

    // Crear elemento de texto de estado
    function createStatusText() {
        if (!imageStatusText) {
            imageStatusText = document.createElement('div');
            imageStatusText.className = 'image-status-text';
            imagePreviewWrapper.parentElement.appendChild(imageStatusText);
        }
    }

    // Crear botón de eliminar
    function createRemoveButton() {
        let removeBtn = imagePreviewWrapper.querySelector('.btn-remove-image');
        if (!removeBtn) {
            removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-image';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.title = 'Eliminar imagen';
            removeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                removeImage();
            });
            imagePreviewWrapper.appendChild(removeBtn);
        }
        return removeBtn;
    }

    // Crear check de éxito
    function createSuccessCheck() {
        let successCheck = imagePreviewWrapper.querySelector('.image-success-check');
        if (!successCheck) {
            successCheck = document.createElement('div');
            successCheck.className = 'image-success-check';
            successCheck.innerHTML = '<i class="fas fa-check"></i>';
            imagePreviewWrapper.appendChild(successCheck);
        }
        return successCheck;
    }

    // Remover imagen
    function removeImage() {
        imageInput.value = '';
        imagePreview.src = '#';
        imagePreview.style.display = 'none';
        imagePreviewPlaceholder.style.display = 'block';
        customFileLabel.textContent = 'Seleccionar imagen';
        imagePreviewWrapper.classList.remove('has-image', 'success');
        
        const removeBtn = imagePreviewWrapper.querySelector('.btn-remove-image');
        const successCheck = imagePreviewWrapper.querySelector('.image-success-check');
        if (removeBtn) removeBtn.classList.remove('show');
        if (successCheck) successCheck.classList.remove('show');
        
        if (imageStatusText) {
            imageStatusText.textContent = '';
            imageStatusText.className = 'image-status-text';
        }
    }

    // Validar archivo
    function validateFile(file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!validTypes.includes(file.type)) {
            return { valid: false, message: 'Formato no válido. Use JPG, JPEG, PNG o WEBP.' };
        }

        if (file.size > maxSize) {
            return { valid: false, message: 'El archivo supera los 2MB.' };
        }

        return { valid: true, message: '' };
    }

    // Manejar selección de imagen
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (!file) {
            removeImage();
            return;
        }

        // Validar archivo
        const validation = validateFile(file);
        createStatusText();

        if (!validation.valid) {
            imageStatusText.textContent = validation.message;
            imageStatusText.className = 'image-status-text error';
            removeImage();
            return;
        }

        // Mostrar vista previa
        const reader = new FileReader();
        
        reader.onload = function(event) {
            imagePreview.src = event.target.result;
            imagePreview.alt = file.name;
            imagePreview.style.display = 'block';
            imagePreview.style.width = '100%';
            imagePreview.style.height = '100%';
            imagePreviewPlaceholder.style.display = 'none';
            
            // Actualizar label del input file
            customFileLabel.textContent = file.name;
            
            // Agregar clases para animación
            imagePreviewWrapper.classList.add('has-image', 'success');
            
            // Mostrar botón de eliminar y check
            const removeBtn = createRemoveButton();
            const successCheck = createSuccessCheck();
            removeBtn.classList.add('show');
            successCheck.classList.add('show');

            // Texto de estado
            const fileSizeKB = (file.size / 1024).toFixed(1);
            imageStatusText.textContent = `✓ Imagen seleccionada: ${file.name} (${fileSizeKB} KB)`;
            imageStatusText.className = 'image-status-text success';

            // Remover clase de animación después de completarse
            setTimeout(() => {
                imagePreviewWrapper.classList.remove('success');
            }, 600);
        };

        reader.readAsDataURL(file);
    });

    // Inicializar
    createStatusText();
});