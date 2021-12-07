<?php

echo "
                            </div><!-- ./row -->
                        </div><!-- ./page-wrapper -->
                    </div><!-- /.container-fluid -->
                </div><!-- /.content -->

                <footer class=\"sticky-footer bg-white\">
                    <div class=\"container my-auto\">
                        <div class=\"copyright text-center my-auto text-white\">
                            <span>Desenvolvido pela SUGESP - SEPLAG/MG</span>
                        </div>
                    </div>
                </footer>

            </div><!-- /.content-wrapper -->

        </div><!-- /.wrapper -->

        <!-- Scroll to Top Button-->
        <a class=\"scroll-to-top rounded\" href=\"#page-top\">
            <i class=\"fas fa-angle-up\"></i>
        </a>

        <!-- Logout Modal-->
        <div class=\"modal fade\" id=\"logoutModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\"
            aria-hidden=\"true\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\" id=\"exampleModalLabel\">Ready to Leave?</h5>
                        <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
                            <span aria-hidden=\"true\">×</span>
                        </button>
                    </div>
                    <div class=\"modal-body\">Select \"Logout\" below if you are ready to end your current session.</div>
                    <div class=\"modal-footer\">
                        <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
                        <a class=\"btn btn-primary\" href=\"login.html\">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class=\"modal fade\" id=\"trocarsenha\" tabindex=\"-1\" role=\"dialog\">
            <div class=\"modal-dialog\" role=\"document\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h4 class=\"modal-title\">Alterar senha</h4>
                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Fechar\">
                            <span aria-hidden=\"true\">&times;</span>
                        </button>
                    </div>
                    <form method=\"post\" action=\"javascript:;\" id=\"form_alterarsenha\" class=\"form-horizontal\">
                        <div class=\"modal-body\">";
if ($this->session->trocasenha){
        echo "
                            <div class=\"alert alert-warning\">
                                <div class=\"alert-text\">
                                    Você deve alterar a senha recebida por e-mail.
                                </div>
                            </div>";
}
echo "
                            <p style=\"margin-left: 10px; font-size: medium;\">
                                <span class=\"bolder\">Padrão da senha:</span><br/>
                                Tamanho mínimo: 8 caracteres<br/>
                                Tamanho máximo: 20 caracteres.
                            </p>
                            <h5>Senha atual</h5>
                            <p>
                                <input class=\"form-control form-control-inline input-medium\" type=\"password\" name=\"senhaAtual\" id=\"senhaAtual\" />
                            </p>
                            <h5>Nova senha</h5>
                            <p>
                                <input class=\"form-control form-control-inline input-medium\" type=\"password\" name=\"senhaNova\" id=\"senhaNova\" />
                            </p>
                            <h5>Confirmação</h5>
                            <p>
                                <input class=\"form-control form-control-inline input-medium\" type=\"password\" name=\"senhaConfirmacao\" id=\"senhaConfirmacao\" />
                            </p>
                        </div>
                        <div class=\"modal-footer\">
                            <button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-outline-dark\">Cancelar</button>
                            <button type=\"button\" name=\"alterar\" id=\"alterarSenha\" class=\"btn btn-primary\">Alterar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        


        <!-- Bootstrap core JavaScript-->
        <script type=\"text/javascript\" src=\"".base_url('assets/vendor/jquery/jquery.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('assets/vendor/jquery-ui/jquery-ui.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components/popper.js/js/popper.min.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components/bootstrap/js/bootstrap.min.js')."\"></script>

        <!-- Masking js -->
        <script src=\"".base_url('assets/pages/form-masking/inputmask.js')."\"></script>
        <script src=\"".base_url('assets/pages/form-masking/jquery.inputmask.js')."\"></script>
        <script src=\"".base_url('assets/pages/form-masking/autoNumeric.js')."\"></script>
        <script src=\"".base_url('assets/pages/form-masking/form-mask.js')."\"></script>
        
        <!-- Moment -->
        <script src=\"https://momentjs.com/downloads/moment-with-locales.js\"></script>

        <!-- Core plugin JavaScript-->
        <script src=\"".base_url('assets/vendor/jquery-easing/jquery.easing.min.js')."\"></script>

        <!-- Custom scripts for all pages-->
        <script src=\"".base_url('assets/js/sb-admin-2.min.js')."\"></script>

        <!-- jquery slimscroll js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components/jquery-slimscroll/js/jquery.slimscroll.js')."\"></script>

        <!-- modernizr js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components/modernizr/js/modernizr.js')."\"></script>
        <script type=\"text/javascript\" src=\"".base_url('bower_components\modernizr\js\css-scrollbars.js')."\"></script>

        <!-- sweet alert js -->
        <script src=\"".base_url('bower_components/sweetalert2/dist/sweetalert2.min.js')."\" type=\"text/javascript\"></script>";
if(isset($adicionais['datatables'])){
        echo "
        <!-- data-table js -->
        <script type=text/javascript src=\"".base_url('bower_components\datatables.net\js\jquery.dataTables.min.js')."\"></script>
        <script type=text/javascript src=\"".base_url('bower_components\datatables.net-buttons\js\dataTables.buttons.min.js')."\"></script>
        <script type=text/javascript src=\"".base_url('assets\pages\data-table\js\jszip.min.js')."\"></script>
        <script type=text/javascript src=\"".base_url('assets\pages\data-table\js\pdfmake.min.js')."\"></script>
        <script type=text/javascript src=\"".base_url('assets\pages\data-table\js\vfs_fonts.js')."\"></script>
        <script type=text/javascript src=\"".base_url('bower_components\datatables.net-buttons\js\buttons.print.min.js')."\"></script>
        <script type=text/javascript src=\"".base_url('bower_components\datatables.net-buttons\js\buttons.html5.min.js')."\"></script>
        <script type=text/javascript src=\"".base_url('bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js')."\"></script>
        <script type=text/javascript src=\"".base_url('bower_components\datatables.net-responsive\js\dataTables.responsive.min.js')."\"></script>
        <script type=text/javascript src=\"".base_url('bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js')."\"></script>";
}
if(isset($adicionais['inputmasks'])){
        echo "
        <!-- Masking js -->
        <script ".('assets/pages/form-masking/inputmask.js')."\"></script>
        <script src=\"".base_url('assets/pages/form-masking/jquery.inputmask.js')."\"></script>
        <script src=\"".base_url('assets/pages/form-masking/autoNumeric.js')."\"></script>
        <script src=\"".base_url('assets/pages/form-masking/form-mask.js')."\"></script>";
}
if(isset($adicionais['pickers'])){
        echo "
        <!-- datetimepicker js -->
        <script src=\"".base_url('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-timepicker/js/bootstrap-timepicker.min.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('bower_components/bootstrap-daterangepicker/daterangepicker.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('assets/js/bootstrap-datepicker.init.js')."\" type=\"text/javascript\"></script>
        <script src=\"".base_url('assets/js/bootstrap-timepicker.init.js')."\" type=\"text/javascript\"></script>
        <link rel=\"stylesheet\" type=\"text/css\" href=\"".base_url('assets/css/datetimepicker.css')."\" />";
}

if(isset($adicionais['rangeslider'])){
        echo "
        <script type=\"text/javascript\" src=\"".base_url('bower_components\seiyria-bootstrap-slider\js\bootstrap-slider.js')."\"></script>";
}

if(isset($adicionais['wizard'])){
        echo "
        <!--Forms - Wizard js-->
        <script src=\"".base_url('bower_components/jquery.cookie/js/jquery.cookie.js')."\"></script>
        <script src=\"".base_url('bower_components/jquery.steps/js/jquery.steps.js')."\"></script>
        <script src=\"".base_url('bower_components/jquery-validation/js/jquery.validate.js')."\"></script>";
}

if(isset($adicionais['select2'])){
        echo "
        <!-- Select 2 js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components\select2\js\select2.full.min.js')."\"></script>";
}

if(isset($adicionais['dcountjs'])){
    echo "
        <!-- dcounts-js.js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components\dCountsjs\src\dcounts-js.js')."\"></script>";
}
if(isset($adicionais['calendar'])){
        echo "
        <!-- calendar js -->
        <script type=\"text/javascript\" src=\"".base_url('bower_components\fullcalendar\js\fullcalendar.min.js')."\"></script>";
}
echo "
    <input type=\"hidden\" id=\"passwordChangeUrl\" value=\"<?= base_url().'Interna/alterar_senha' ?>\"/>
    <script src=\"".base_url('assets/js/pss.js')."\"></script>
    <script type=\"text/javascript\">
        $(document).ready(function() {
            setTimeout(function(){ alert(\"Sua sessão está se expirando.\"); }, 1800000);

            setTimeout(function(){ window.location='<?php echo base_url('Interna/logout');?>'; }, 1860000);
        });
    </script>";
if ($this->session->trocasenha){
        echo "
    <script type=\"text/javascript\">
        $(document).ready(function(){
            $('#trocarsenha').modal('show');
        });
    </script>";
}

if(isset($js)) {
    echo $js;
}

echo "
    </body>
</html>";
?>
