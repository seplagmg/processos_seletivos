<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
if(strlen($this -> session -> nome) > 0){
        $nome=explode(' ', $this -> session -> nome);
        $primeironome=$nome[0];
        $ultimonome=$nome[count($nome)-1];
        if(strlen($primeironome) + strlen($ultimonome) > 30){
                $ultimonome=substr($ultimonome, 0, 1).'.';
        }
}
*/
echo "
            <ul class=\"navbar-nav bg-gradient-primary sidebar sidebar-dark accordion\" id=\"accordionSidebar\">
                <!-- Sidebar - Brand -->
                <a class=\"sidebar-brand d-flex align-items-center justify-content-center\" href=\"".base_url()."\">
                    <img class=\"img-fluid\" alt=\"Logo\" src=\"".base_url('images/logo.png')."\" width=\"150\">
                </a>
                <a class=\"mobile-options\">
                    <i class=\"feather icon-more-horizontal\"></i>
                </a>

                <!-- Divider -->
                <hr class=\"sidebar-divider my-0\">

                <!-- Nav Item - Dashboard -->
                <li class=\"nav-item ";
if($menu1 == 'Interna' && $menu2 == 'index'){
        echo 'active';
}
echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Interna/index')."\">
                        <i class=\"fas fa-home\"></i>
                        <span>Página inicial</span>
                    </a>
                </li>";

if($this -> session -> perfil == 'candidato'){ //candidato
        echo "
                <li class=\"nav-item ";
        if($menu1 == 'Candidaturas' && $menu2 != 'AgendamentoEntrevista'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Candidaturas/index')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-edit\"></i></span>
                        <span class=\"pcoded-mtext\">Suas candidaturas</span>
                    </a>
                </li>";
}
if($this -> session -> perfil == 'avaliador' || $this -> session -> perfil == 'avaliador_curriculo' || $this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador'){
        echo "
                <li class=\"nav-item ";
        if(($this -> session -> perfil == 'avaliador' && $menu1 == 'Candidaturas' && $menu2 != 'AgendamentoEntrevista') || ($this -> session -> perfil != 'avaliador' && $menu1 == 'Candidaturas'  && $menu2 != 'AgendamentoEntrevista')){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Candidaturas/ListaAvaliacao')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-edit\"></i></span>
                        <span class=\"pcoded-mtext\">Candidaturas</span>
                    </a>
                </li>";
}
if($this -> session -> perfil == 'candidato' || $this -> session -> perfil == 'avaliador' || $this -> session -> perfil == 'sugesp'){
        echo "
                <li class=\"nav-item ";
        if($menu1 == 'Candidaturas' && $menu2 == 'AgendamentoEntrevista'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Candidaturas/AgendamentoEntrevista')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-calendar\"></i></span>
                        <span class=\"pcoded-mtext\">Seus agendamentos</span>
                    </a>
                </li>";
}
if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador'){
        echo "
                <li class=\"nav-item ";
        if($menu1 == 'Candidatos'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Candidatos/ListaCandidatos')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-users\"></i></span>
                        <span class=\"pcoded-mtext\">Candidatos</span>
                    </a>
                </li>";
}
if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador'){
        echo "
                <li class=\"nav-item ";
        if($menu1 == 'Vagas'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Vagas/index')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-thumbtack\"></i></span>
                        <span class=\"pcoded-mtext\">Vagas</span>
                    </a>
                </li>";
        //if($this -> session -> perfil != 'orgaos'){
                echo "
                <li class=\"nav-item ";
                if($menu1 == 'GruposVagas' || $menu1 == 'Questoes'){
                        echo ' active';
                }
                echo "\">
                    <a class=\"nav-link\" href=\"".base_url('GruposVagas/index')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-check-square\"></i></span>
                        <span class=\"pcoded-mtext\">Grupos de vagas e questões</span>
                    </a>
                </li>";
        //}
        echo "
                <li class=\"nav-item ";
        if($menu1 == 'Relatorios'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Relatorios/index')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-chart-line\"></i></span>
                        <span class=\"pcoded-mtext\">Relatórios</span>
                    </a>
                </li>";
}
else if($this -> session -> perfil == 'avaliador'){
         echo "
                <li class=\"nav-item ";
        if($menu1 == 'Vagas'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Vagas/index')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-thumbtack\"></i></span>
                        <span class=\"pcoded-mtext\">Vagas</span>
                    </a>
                </li>";
}
if($this -> session -> perfil == 'administrador'){ //administrador
        echo "
                <li class=\"nav-item ";
        if($menu1 == 'Interna' && $menu2=='auditoria'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Interna/auditoria')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-cog\"></i></span>
                        <span class=\"pcoded-mtext\">Auditoria</span>
                    </a>
                </li>";
        echo "
                <li class=\"nav-item ";
        if($menu1 == 'Usuarios'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Usuarios/index')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-users\"></i></span>
                        <span class=\"pcoded-mtext\">Usuários</span>
                    </a>
                </li>";
}
else if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos'){
        echo "
                <li class=\"nav-item ";
        if($menu1 == 'Usuarios'){
                echo ' active';
        }
        echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Usuarios/index')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-users\"></i></span>
                        <span class=\"pcoded-mtext\">Usuários</span>
                    </a>
                </li>";
}
if($this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos'){ //administrador

    echo "
                <li class=\"nav-item ";
    if($menu1 == 'Editais'){
            echo ' active';
    }
    echo "\">
                    <a class=\"nav-link\" href=\"".base_url('Editais/index')."\">
                        <span class=\"pcoded-micon\"><i class=\"far fa-file-alt\"></i></span>
                        <span class=\"pcoded-mtext\">Editais</span>
                    </a>
                </li>";
}
echo "
                <li class=\"nav-item\">
                    <a class=\"nav-link\" href=\"".base_url('Interna/logout')."\">
                        <span class=\"pcoded-micon\"><i class=\"fa fa-sign-out-alt\"></i></span>
                        <span class=\"pcoded-mtext\">Sair</span>
                    </a>
                </li>
                <hr class=\"sidebar-divider d-none d-md-block\">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class=\"text-center d-none d-md-inline\">
                        <button class=\"rounded-circle border-0\" id=\"sidebarToggle\"></button>
                </div>
            </ul>";
?>
