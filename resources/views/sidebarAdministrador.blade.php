<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-home"></i> INICIO</a>
            </li>
            <li class="nav-title">
                Opciones
            </li> 

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i>REGISTRO</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=1" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-people"></i> Clientes</a>
                    </li>
                    <li @click="menu=2" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-doc"></i>Mascota<a>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-doc"></i> Consulta<a>
                    </li>
                </ul>
            </li> 

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> INFORMACION</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-doc"></i> Información</a>
                    </li>
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-map"></i> Donación</a>
                    </li>
                </ul>
            </li> 

            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> REGISTRAR ADOPCION</a>
                <ul class="nav-dropdown-items">
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-doc"></i> Datos</a>
                    </li>
                    <li @click="menu=7" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-map"></i> Mascota</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-map"></i> Adoptar</a>
                    </li>
                </ul>
            </li> 


            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-key"></i> ACCESO</a>
                <ul class="nav-dropdown-items">                  							
                    <li @click="menu=9" class="nav-item">
                        <a class="nav-link" href="i#"><i class="icon-people"></i> Usuarios</a>
                    </li>
                    
                </ul>
            </li> 
     

            <li @click="menu=10" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-info"></i> QUIENES SOMOS</a> 
            </li>



        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
