/**
 * MQ Podio - Sistema de Premios
 * JavaScript / jQuery Logic
 */
$(document).ready(function () {

    // ============================================
    // DataTables Initialization
    // ============================================
    const dtConfig = {
        language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ empleados",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No hay datos disponibles",
            info: "Mostrando _START_ a _END_ de _TOTAL_ empleados",
            infoEmpty: "Mostrando 0 a 0 de 0 empleados",
            infoFiltered: "(filtrado de _MAX_ empleados en total)",
            search: '<i class="fa-solid fa-magnifying-glass"></i> Buscar:',
            paginate: {
                first: '<i class="fa-solid fa-angles-left"></i>',
                previous: '<i class="fa-solid fa-angle-left"></i>',
                next: '<i class="fa-solid fa-angle-right"></i>',
                last: '<i class="fa-solid fa-angles-right"></i>',
            },
        },
        pageLength: 10,
        lengthMenu: [5, 10, 17],
        order: [[0, "asc"]],
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
        columnDefs: [
            { orderable: false, targets: [3] },
            { className: "text-center", targets: [0, 2, 3] },
        ],
        drawCallback: function () {
            // Re-apply row classes after redraw (pagination/search)
            $(this.api().table().body()).find("tr").each(function () {
                var medalla = $(this).data("medalla");
                if (medalla && medalla !== "ninguna") {
                    $(this).addClass("row-" + medalla);
                }
            });
        },
    };

    // Initialize tables (only the visible one first)
    $(".table-ranking").each(function () {
        $(this).DataTable(dtConfig);
    });

    // ============================================
    // Points Counter Animation
    // ============================================
    function animateCounters($container) {
        $container.find(".points-counter").each(function () {
            var $this = $(this);
            var target = parseInt($this.data("target"));
            if ($this.data("animated")) return;
            $this.data("animated", true);

            $({ val: 0 }).animate(
                { val: target },
                {
                    duration: 1500,
                    easing: "swing",
                    step: function () {
                        $this.text(Math.floor(this.val));
                    },
                    complete: function () {
                        $this.text(target);
                    },
                }
            );
        });
    }

    // Animate counters for the initially active tab
    animateCounters($(".tab-pane.active"));

    // ============================================
    // Tab Change Animations
    // ============================================
    $('button[data-bs-toggle="pill"]').on("shown.bs.tab", function (e) {
        var target = $(e.target).data("bs-target");
        var $pane = $(target);

        // Reset and re-animate counter
        $pane.find(".points-counter").data("animated", false);
        animateCounters($pane);

        // Re-animate podio elements
        $pane.find(".podio-container").removeClass("animate__fadeInUp");
        void $pane.find(".podio-container")[0]?.offsetWidth; // force reflow
        $pane.find(".podio-container").addClass("animate__fadeInUp");

        $pane.find(".table-section").removeClass("animate__fadeInUp");
        void $pane.find(".table-section")[0]?.offsetWidth;
        $pane.find(".table-section").addClass("animate__fadeInUp");

        // Re-initialize tilt for new tab's avatar cards
        $pane.find('[data-tilt]').each(function () {
            var $card = $(this);
            var $inner = $card.find('.avatar-card-inner');
            $card.off('mousemove mouseleave mouseenter');

            $card.on('mousemove', function (e) {
                var rect = this.getBoundingClientRect();
                var x = e.clientX - rect.left;
                var y = e.clientY - rect.top;
                var centerX = rect.width / 2;
                var centerY = rect.height / 2;
                var rotateX = ((y - centerY) / centerY) * -15;
                var rotateY = ((x - centerX) / centerX) * 15;
                $card.addClass('tilt-active');
                $inner.css('transform', 'perspective(600px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale(1.05)');
            });

            $card.on('mouseleave', function () {
                $card.removeClass('tilt-active');
                $inner.css({
                    'transform': 'perspective(600px) rotateX(0deg) rotateY(0deg) scale(1)',
                    'transition': 'transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)'
                });
            });

            $card.on('mouseenter', function () {
                $inner.css('transition', 'none');
            });
        });

        // Reinitialize DataTable if not already done
        var tableId = $pane.find(".table-ranking").attr("id");
        if (tableId && !$.fn.DataTable.isDataTable("#" + tableId)) {
            $("#" + tableId).DataTable(dtConfig);
        }
    });

    // ============================================
    // 3D Avatar Tilt Effect
    // ============================================
    $('[data-tilt]').each(function () {
        var $card = $(this);
        var $inner = $card.find('.avatar-card-inner');

        $card.on('mousemove', function (e) {
            var rect = this.getBoundingClientRect();
            var x = e.clientX - rect.left;
            var y = e.clientY - rect.top;
            var centerX = rect.width / 2;
            var centerY = rect.height / 2;
            var rotateX = ((y - centerY) / centerY) * -15;
            var rotateY = ((x - centerX) / centerX) * 15;

            $card.addClass('tilt-active');
            $inner.css('transform', 'perspective(600px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale(1.05)');
        });

        $card.on('mouseleave', function () {
            $card.removeClass('tilt-active');
            $inner.css({
                'transform': 'perspective(600px) rotateX(0deg) rotateY(0deg) scale(1)',
                'transition': 'transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275)'
            });
        });

        $card.on('mouseenter', function () {
            $inner.css('transition', 'none');
        });
    });

    // ============================================
    // Employee Click — SweetAlert2 Modal
    // ============================================
    $(document).on("click", ".empleado-row", function () {
        var nombre = $(this).data("nombre");
        var puntos = $(this).data("puntos");
        var posicion = $(this).data("posicion");
        var medalla = $(this).data("medalla");
        var area = $(this).data("area");

        var medallaIcon = "";
        var medallaText = "";
        var medallaColor = "";

        if (medalla === "oro") {
            medallaIcon = "🥇";
            medallaText = "Medalla de Oro";
            medallaColor = "#FFD700";
        } else if (medalla === "plata") {
            medallaIcon = "🥈";
            medallaText = "Medalla de Plata";
            medallaColor = "#C0C0C0";
        } else if (medalla === "bronce") {
            medallaIcon = "🥉";
            medallaText = "Medalla de Bronce";
            medallaColor = "#CD7F32";
        }

        var htmlContent = '<div style="text-align: center; padding: 10px 0;">';
        htmlContent +=
            '<div style="width: 90px; height: 90px; border-radius: 50%; margin: 0 auto 15px; overflow: hidden; border: 3px solid ' +
            (medallaColor || 'rgba(255,255,255,0.2)') +
            '; box-shadow: 0 0 20px ' +
            (medallaColor ? medallaColor + '44' : 'rgba(255,255,255,0.1)') + ';">';
        htmlContent += '<div style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;background:linear-gradient(145deg,#5b8fd9,#3a6dbf);border-radius:50%;"><i class="fa-solid fa-user" style="font-size:2.5rem;color:rgba(255,255,255,0.85);"></i></div>';
        htmlContent += "</div>";
        htmlContent +=
            '<h3 style="margin-bottom: 5px; color: #fff;">' +
            escapeHtml(nombre) +
            "</h3>";
        htmlContent +=
            '<p style="color: rgba(255,255,255,0.5); margin-bottom: 15px;">' +
            escapeHtml(area) +
            "</p>";
        htmlContent += '<div style="display: flex; justify-content: center; gap: 20px; margin: 20px 0;">';
        htmlContent +=
            '<div style="text-align: center;"><div style="font-size: 1.8rem; font-weight: 800; color: #6366f1;">#' +
            posicion +
            '</div><small style="color: rgba(255,255,255,0.5);">Posición</small></div>';
        htmlContent +=
            '<div style="text-align: center;"><div style="font-size: 1.8rem; font-weight: 800; color: #FFD700;"><i class="fa-solid fa-star" style="font-size: 1.2rem;"></i> ' +
            puntos.toLocaleString() +
            '</div><small style="color: rgba(255,255,255,0.5);">Puntos</small></div>';
        htmlContent += "</div>";

        if (medalla !== "ninguna") {
            htmlContent +=
                '<div style="margin-top: 10px; padding: 10px; border-radius: 12px; background: ' +
                medallaColor +
                '22; border: 1px solid ' +
                medallaColor +
                '44;">';
            htmlContent +=
                '<span style="font-size: 2.5rem;">' + medallaIcon + "</span>";
            htmlContent +=
                '<p style="margin: 5px 0 0; font-weight: 700; color: ' +
                medallaColor +
                ';">' +
                medallaText +
                "</p>";
            htmlContent +=
                '<p style="font-size: 0.85rem; color: rgba(255,255,255,0.6); margin: 0;">¡Felicitaciones por tu excelente desempeño!</p>';
            htmlContent += "</div>";
        }

        htmlContent += "</div>";

        Swal.fire({
            html: htmlContent,
            showConfirmButton: true,
            confirmButtonText:
                medalla !== "ninguna"
                    ? '<i class="fa-solid fa-hands-clapping me-1"></i> ¡Felicidades!'
                    : '<i class="fa-solid fa-thumbs-up me-1"></i> ¡Sigue así!',
            showCloseButton: true,
            customClass: {
                popup: "swal-podio-popup",
                confirmButton: "swal-podio-confirm",
            },
            background: "transparent",
            backdrop: "rgba(0, 0, 0, 0.7)",
            showClass: {
                popup: "animate__animated animate__zoomIn animate__faster",
            },
            hideClass: {
                popup: "animate__animated animate__zoomOut animate__faster",
            },
        });
    });

    // ============================================
    // Utility: Escape HTML to prevent XSS
    // ============================================
    function escapeHtml(text) {
        var div = document.createElement("div");
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }
});
