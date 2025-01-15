    <!-- Nnavbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-second">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">

                <a class="mr-5" href="<?=base_url()?>"><img width="100px" src="<?=base_url()?>assets/frontend/images/blason2.png"></a>
                 <a class="nav-link px-3"  href="<?=base_url()?>"><i class="fa fa-home"></i> Accueil</a>
                 &nbsp;
                <a class="nav-link px-3 <?php if(in_array($this->router->method,['index','index'])) echo 'active';?>"  href="<?=base_url()?>person/Demande_Espace_Person/index"><i class="fa fa-calendar-o"></i> Mes demandes</a>
                 <!--<a href="infos.html"><i class="fa fa-info-circle"></i> Mes infos</a>-->
                 &nbsp;
                <a class="nav-link px-3 <?php if(in_array($this->router->method,['message','message'])) echo 'active';?>" href="<?=base_url()?>person/Demande_Espace_Person/message"><i class="fa fa-envelope"></i> Mes plaintes</a> 
                &nbsp;
                <a href="<?=base_url('Login_Front/do_logout')?>"><i class="fa fa-sign-out"></i> Déconnexion</a>

            
                <div class="social-links d-flex align-items-center">
                    <a href="<?=base_url('Language/index/fr')?>"><img class=" p-1 language-image active d-flex align-items-center ms-2" src="<?=base_url()?>assets/img/FR.png"></a>
                    <a href="<?=base_url('Language/index/en')?>"><img class=" p-1 language-image d-flex align-items-center ms-2" src="<?=base_url()?>assets/img/EN.png"></a>
                </div>
      
            </div>
        </div>
    </nav>
    <!-- Navbar End -->