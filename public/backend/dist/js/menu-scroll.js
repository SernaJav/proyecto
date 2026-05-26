// =========================
// CERRAR MENÚ AL HACER CLICK EN ENLACE
// =========================
$(document).ready(function () {
    
    // Cerrar sidebar cuando se hace click en un enlace del menú (que no sea submenú)
    $('.sidebar .nav-link').on('click', function (e) {
        
        // Si el enlace tiene href y NO es un botón de expandir submenú
        const hasSubMenu = $(this).siblings('.nav-treeview').length > 0;
        
        if ($(this).attr('href') !== '#' && !hasSubMenu) {
            
            // Cerrar el sidebar usando el widget de AdminLTE
            $('[data-widget="pushmenu"]').PushMenu('collapse');
        }
    });

    // =========================
    // MANTENER POSICIÓN DEL SCROLL
    // =========================
    
    // Guardar scroll position antes de navegar
    $(window).on('beforeunload', function () {
        
        const scrollPos = $(window).scrollTop();
        
        sessionStorage.setItem('scrollPos', scrollPos);
    });

    // Restaurar scroll position después de cargar
    $(window).on('load', function () {
        
        if (sessionStorage.getItem('scrollPos') !== null) {
            
            const scrollPos = parseInt(sessionStorage.getItem('scrollPos'));
            
            $(window).scrollTop(scrollPos);
            
            sessionStorage.removeItem('scrollPos');
        }
    });

    // =========================
    // DATATABLES - MANTENER ESTADO Y SCROLL
    // =========================
    
    if ($('.datatable').length) {
        
        // Guardar posición de scroll antes de hacer clic en un botón
        $('body').on('click', 'a:not([data-toggle]), button:not([data-toggle])', function () {
            
            const scrollPos = $(window).scrollTop();
            
            sessionStorage.setItem('tableScrollPos', scrollPos);
        });

        // Restaurar posición después de cargar (con delay para asegurar que el DOM esté listo)
        setTimeout(() => {
            
            if (sessionStorage.getItem('tableScrollPos') !== null) {
                
                const savedPos = parseInt(sessionStorage.getItem('tableScrollPos'));
                
                $(window).scrollTop(savedPos);
                
                sessionStorage.removeItem('tableScrollPos');
            }
            
        }, 100);
    }

    // =========================
    // CERRAR MENÚ AL HACER CLICK EN BOTONES DE ACCIÓN
    // =========================
    
    $('body').on('click', '.btn-action, .btn-info, .btn-danger, .btn-primary', function () {
        
        // Cerrar sidebar
        const sidebar = $('.main-sidebar');
        
        if (sidebar.hasClass('sidebar-open') || $('body').hasClass('sidebar-open')) {
            
            $('[data-widget="pushmenu"]').PushMenu('collapse');
        }
    });

    // =========================
    // PREVENIR COMPORTAMIENTO INNECESARIO EN MODALES
    // =========================
    
    $('body').on('show.bs.modal', '.modal', function () {
        
        // Guardar scroll cuando se abre un modal
        sessionStorage.setItem('mainScrollPos', $(window).scrollTop());
    });

    $('body').on('hidden.bs.modal', '.modal', function () {
        
        // Restaurar scroll cuando se cierra un modal
        if (sessionStorage.getItem('mainScrollPos') !== null) {
            
            const savedPos = parseInt(sessionStorage.getItem('mainScrollPos'));
            
            $(window).scrollTop(savedPos);
            
            sessionStorage.removeItem('mainScrollPos');
        }
    });
});

