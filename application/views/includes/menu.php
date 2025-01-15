        <!-- Navbar start -->
        <nav style="z-index: 2" class="navbar navbar-expand-lg navbar-light  sticky" data-offset="0">
            <div class="container">
                <a href="#" class="navbar-brand"><img alt="Commissariat Général des Migrations Burundi Logo" width='300'
                        src='<?=base_url()?>/assets/img/Logo-CENI.png'></a>

                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarContent">

                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php if($this->router->class == 'Home') echo 'active';?>"
                                href="<?=base_url('Home')?>">ACCUEIL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($this->router->class == 'HomeS') echo 'active';?>"
                                href="<?=base_url('HomeS')?>">A PROPOS DE NOUS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($this->router->class == 'HomeS') echo 'active';?>"
                                href="<?=base_url('HomeS')?>">ACTUALITES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($this->router->class == 'HomeS') echo 'active';?>"
                                href="<?=base_url('HomeS')?>">CONTACTEZ-NOUS</a>
                        </li>
                        

                    </ul>

                </div>

            </div>
        </nav>
        <!-- Navbar end -->