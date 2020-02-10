<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li @click="menu=0" class="nav-item">
                <a class="nav-link active" href="#"><i class="icon-menu"></i> Inicio usuer</a>
            </li>
            <li class="nav-title">
                Opciones
            </li>  
            <li @click="menu=1" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-info"></i> Registrar Adopción</a> 
            </li>          

            <li @click="menu=2" class="nav-item">
                <a class="nav-link" href="#"><i class="icon-info"></i> Quienes Somos</a> 
            </li>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
