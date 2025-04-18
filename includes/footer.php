<?php
// includes/footer.php (Modificado)

// Este archivo se incluirá al final de tus vistas

?>

                </div> {/* Fin de .container-fluid */}

            </div> {/* Fin de #content */}

            {/* Footer (Pie de Página) */}
            <footer class="sticky-footer bg-white"> {/* Clases de ejemplo para estilo */}
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Tu Sistema <?php echo date('Y'); ?></span> {/* Año dinámico */}
                    </div>
                </div>
            </footer>
            {/* End of Footer */}

        </div> {/* Fin de #content-wrapper */}

    </div> {/* Fin de #wrapper */}

    {/* Scroll to Top Button (Opcional) */}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {/* Logout Modal (Si usas un modal de confirmación para salir) */}
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Salir" abajo si estás listo para terminar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="/auth/logout.php">Salir</a> {/* Enlace real de logout */}
                </div>
            </div>
        </div>
    </div>


    {/* Scripts de Bootstrap si usas */}
    <script src="/assets/vendor/jquery/jquery.min.js"></script> {/* Ejemplo con jQuery */}
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> {/* Ejemplo con Bootstrap */}

    {/* Plugins de terceros si usas */}
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script> {/* Ejemplo con plugin de easing */}

    {/* Scripts personalizados para todas las páginas */}
    <script src="/assets/js/sb-admin-2.min.js"></script> {/* Ejemplo de script de plantilla (si usas SB Admin 2) */}


    <script src="/assets/js/auth.js"></script> {/* Ejemplo: si tienes JS para autenticación */}
    <script src="/assets/js/charts.js"></script> {/* Ejemplo: si usas gráficos */}
    </body>
</html>