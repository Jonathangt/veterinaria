<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-home"></i> Inicio</a>
            </li>
            <li @click="menu=1" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-paper-clip"></i> Información</a> 
            </li>

            <li @click="menu=2" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-heart"></i> Adoptar</a> 
            </li> 



            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pencil"></i> Registrar Adopción</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-doc"></i> Datos</a>
                    </li>
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-heart"></i> Mascota</a>
                    </li>
                </ul>
            </li> 

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-key"></i> Acceso</a>
                <ul class="nav-dropdown-items">                  							
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-people"></i> Usuario</a>
                    </li>
                </ul>
            </li> 

    
            <li @click="menu=6" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-info"></i> Quienes Somos</a> 
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
