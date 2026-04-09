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
                    duration: 2500,
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

    var $podiosGrid = $(".podios-grid");
    if ($podiosGrid.find(".podio-area-card").length <= 1) {
        animateCounters($podiosGrid);
    }

    // ============================================
    // Podium Auto-Rotation (10s)
    // ============================================
    function resetAndAnimateCounters($container) {
        $container.find(".points-counter").each(function () {
            $(this).data("animated", false).text("0");
        });
        animateCounters($container);
    }

    function initPodioRotation() {
        var $grid = $(".podios-grid");
        var $cards = $grid.find(".podio-area-card");
        var $controls = $("#podioCarouselControls");
        var $progressWrap = $("#podioProgressWrap");
        var $prevBtn = $controls.find('[data-podio-nav="prev"]');
        var $nextBtn = $controls.find('[data-podio-nav="next"]');
        var $dots = $controls.find(".podio-dot");
        var $dotsWrap = $controls.find(".podio-dots");
        var $progressBar = $("#podioProgressBar");

        if ($cards.length <= 1) {
            $controls.hide();
            $progressWrap.hide();
            return;
        }

        var activeIndex = 0;
        var timeoutId = null;
        var isTransitioning = false;
        var transitionMs = 900;
        var changeEveryMs = 10000;
        var dragThreshold = 70;
        var isPointerDown = false;
        var dragStartX = 0;
        var dragStartY = 0;
        var dragDeltaX = 0;
        var isHorizontalDrag = false;
        var dragStartTs = 0;
        var remainingMs = changeEveryMs;
        var rotationStartedAt = 0;
        var isDotsScrubbing = false;

        $cards.removeClass("animate__animated animate__fadeInUp");
        $grid.addClass("is-rotating");
        $grid.attr("tabindex", "0");
        $cards.removeClass("is-active is-leaving");
        $cards.eq(activeIndex).addClass("is-active");

        function updateDots(index) {
            $dots.removeClass("is-active");
            $dots.eq(index).addClass("is-active");
        }

        function updateGridHeight($card) {
            $grid.css("min-height", $card.outerHeight(true) + "px");
        }

        function setProgressInstant(percent) {
            $progressBar.css({
                transition: "none",
                width: percent + "%",
            });
        }

        function animateProgress(remaining) {
            var consumed = ((changeEveryMs - remaining) / changeEveryMs) * 100;
            setProgressInstant(Math.max(0, Math.min(100, consumed)));
            void $progressBar[0]?.offsetWidth;
            $progressBar.css({
                transition: "width " + remaining + "ms linear",
                width: "100%",
            });
        }

        function goTo(nextIndex) {
            if (isTransitioning || nextIndex === activeIndex) {
                return false;
            }

            isTransitioning = true;

            var $current = $cards.eq(activeIndex);
            var $next = $cards.eq(nextIndex);

            $grid.removeClass("is-dragging").css("--drag-x", "0px");
            $current.addClass("is-leaving").removeClass("is-active");
            $next.addClass("is-active");
            activeIndex = nextIndex;
            updateDots(activeIndex);

            updateGridHeight($next);
            resetAndAnimateCounters($next);

            window.setTimeout(function () {
                $current.removeClass("is-leaving");
                isTransitioning = false;
            }, transitionMs);

            return true;
        }

        function startRotation() {
            if (timeoutId) {
                return;
            }

            if (remainingMs <= 0) {
                remainingMs = changeEveryMs;
            }

            rotationStartedAt = Date.now();
            animateProgress(remainingMs);

            timeoutId = window.setTimeout(function () {
                timeoutId = null;
                var moved = goNext();
                remainingMs = changeEveryMs;
                if (!moved) {
                    remainingMs = changeEveryMs;
                }
                startRotation();
            }, remainingMs);
        }

        function stopRotation(preserveRemaining) {
            if (preserveRemaining === undefined) {
                preserveRemaining = true;
            }

            if (timeoutId) {
                window.clearTimeout(timeoutId);
                timeoutId = null;
            }

            if (preserveRemaining && rotationStartedAt) {
                var elapsed = Date.now() - rotationStartedAt;
                remainingMs = Math.max(0, remainingMs - elapsed);
            } else if (!preserveRemaining) {
                remainingMs = changeEveryMs;
            }

            var consumed = ((changeEveryMs - remainingMs) / changeEveryMs) * 100;
            setProgressInstant(Math.max(0, Math.min(100, consumed)));
        }

        function restartRotation() {
            stopRotation(false);
            startRotation();
        }

        function goNext() {
            var next = (activeIndex + 1) % $cards.length;
            return goTo(next);
        }

        function goPrev() {
            var next = (activeIndex - 1 + $cards.length) % $cards.length;
            return goTo(next);
        }

        function nearestDotIndexFromClientX(clientX) {
            var nearestIndex = activeIndex;
            var nearestDistance = Number.POSITIVE_INFINITY;

            $dots.each(function (idx) {
                var rect = this.getBoundingClientRect();
                var center = rect.left + rect.width / 2;
                var distance = Math.abs(clientX - center);
                if (distance < nearestDistance) {
                    nearestDistance = distance;
                    nearestIndex = idx;
                }
            });

            return nearestIndex;
        }

        function getPointFromEvent(e) {
            var original = e.originalEvent;
            if (original && original.touches && original.touches.length) {
                return original.touches[0];
            }
            if (original && original.changedTouches && original.changedTouches.length) {
                return original.changedTouches[0];
            }
            return e;
        }

        function onDragStart(e) {
            if (isTransitioning) {
                return;
            }

            var point = getPointFromEvent(e);
            isPointerDown = true;
            isHorizontalDrag = false;
            dragStartX = point.clientX;
            dragStartY = point.clientY;
            dragDeltaX = 0;
            dragStartTs = Date.now();
            stopRotation(true);
        }

        function onDragMove(e) {
            if (!isPointerDown || isTransitioning) {
                return;
            }

            var point = getPointFromEvent(e);
            var deltaX = point.clientX - dragStartX;
            var deltaY = point.clientY - dragStartY;

            if (!isHorizontalDrag) {
                if (Math.abs(deltaX) < 8) {
                    return;
                }
                if (Math.abs(deltaX) <= Math.abs(deltaY)) {
                    return;
                }
                isHorizontalDrag = true;
            }

            if (e.cancelable) {
                e.preventDefault();
            }

            dragDeltaX = deltaX;
            var clamped = Math.max(-140, Math.min(140, dragDeltaX));
            $grid.addClass("is-dragging").css("--drag-x", clamped + "px");
        }

        function onDragEnd() {
            if (!isPointerDown) {
                return;
            }

            isPointerDown = false;

            if (!isHorizontalDrag) {
                startRotation();
                return;
            }

            $grid.removeClass("is-dragging").css("--drag-x", "0px");

            var elapsed = Math.max(1, Date.now() - dragStartTs);
            var velocityX = dragDeltaX / elapsed;
            var hasMomentum = Math.abs(velocityX) >= 0.45;
            var shouldMove = Math.abs(dragDeltaX) >= dragThreshold || hasMomentum;

            if (shouldMove) {
                if (dragDeltaX < 0) {
                    goNext();
                } else {
                    goPrev();
                }
                restartRotation();
            } else {
                startRotation();
            }
        }

        updateGridHeight($cards.eq(activeIndex));
        resetAndAnimateCounters($cards.eq(activeIndex));
        updateDots(activeIndex);
        startRotation();

        $grid.on("mouseenter", function () {
            stopRotation(true);
        });
        $grid.on("mouseleave", startRotation);

        $prevBtn.on("click", function () {
            goPrev();
            restartRotation();
        });

        $nextBtn.on("click", function () {
            goNext();
            restartRotation();
        });

        $dots.on("click", function () {
            var idx = parseInt($(this).data("podio-index"), 10);
            if (Number.isNaN(idx)) {
                return;
            }
            goTo(idx);
            restartRotation();
        });

        // Dot scrubber drag: arrastra sobre los puntos para moverte podio a podio
        $dotsWrap.on("mousedown touchstart", function (e) {
            var point = getPointFromEvent(e);
            isDotsScrubbing = true;
            stopRotation(true);
            var idx = nearestDotIndexFromClientX(point.clientX);
            goTo(idx);
            if (e.cancelable) {
                e.preventDefault();
            }
        });

        $(document).on("mousemove touchmove", function (e) {
            if (!isDotsScrubbing) {
                return;
            }
            var point = getPointFromEvent(e);
            var idx = nearestDotIndexFromClientX(point.clientX);
            goTo(idx);
            if (e.cancelable) {
                e.preventDefault();
            }
        });

        $(document).on("mouseup touchend touchcancel", function () {
            if (!isDotsScrubbing) {
                return;
            }
            isDotsScrubbing = false;
            restartRotation();
        });

        // Mouse/touch swipe drag support
        $grid.on("mousedown touchstart", onDragStart);
        $(document).on("mousemove touchmove", onDragMove);
        $(document).on("mouseup touchend touchcancel", onDragEnd);

        // Keyboard controls for accessibility/pro mode
        $grid.on("keydown", function (e) {
            if (e.key === "ArrowRight") {
                goNext();
                restartRotation();
                e.preventDefault();
            } else if (e.key === "ArrowLeft") {
                goPrev();
                restartRotation();
                e.preventDefault();
            }
        });

        $(window).on("resize", function () {
            updateGridHeight($cards.eq(activeIndex));
        });
    }

    initPodioRotation();

    // Animate counters when switching to the "Mejor Area" view tab
    $('button[data-bs-target="#podio-view-area"]').on("shown.bs.tab", function () {
        resetAndAnimateCounters($("#podio-view-area"));
    });

    // ============================================
    // Tab Change Animations
    // ============================================
    $('#areaTabs button[data-bs-toggle="pill"]').on("shown.bs.tab", function (e) {
        var target = $(e.target).data("bs-target");
        var $pane = $(target);

        $pane.find(".table-section").removeClass("animate__fadeInUp");
        void $pane.find(".table-section")[0]?.offsetWidth;
        $pane.find(".table-section").addClass("animate__fadeInUp");

        // Reinitialize DataTable if not already done
        var tableId = $pane.find(".table-ranking").attr("id");
        if (tableId && !$.fn.DataTable.isDataTable("#" + tableId)) {
            $("#" + tableId).DataTable(dtConfig);
        }
    });

    // ============================================
    // 3D Avatar Tilt Effect
    // ============================================
    function initTilt($elements) {
        $elements.each(function () {
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
    }

    initTilt($('[data-tilt]'));

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
