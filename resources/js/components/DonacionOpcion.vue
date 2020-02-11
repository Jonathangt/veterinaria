<template>
    <div>
        <div class="form-group row" v-for="registro in arrayRegistros" :key="registro.id">
            <div>
                <label>Publicado por</label>
                <label v-text="registro.name"></label><br>
                <label>recaudacion </label>
                <label v-text="registro.recaudacion"></label><br>
                <label>lugar </label>
                <label v-text="registro.lugar"></label><br>
                <label>motivo </label>
                <label v-text="registro.motivo"></label><br>
                <label>telefono </label>
                <label v-text="registro.telefono"></label><br>
                <label>direccion </label>
                <label v-text="registro.direccion"></label><br>
                <label>email </label>
                <label v-text="registro.email"></label><br>
            </div>        
        </div>        
    </div>
</template>



<script>
   
    export default {
        data() {
            return {
                name: '',
                email: '',
                motivo: '',
                recaudacion: '',
                lugar: '',
                telefono: '',
                direccion: '',
                idDonacion: 0,
                data: [],
                arrayRegistros: [],
                arrayMostrarDatos: [],
                errorMostrarMsj: [],
                errorValidacion: 0,
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                template: 1,
                offset: 3,
                criterio: 'motivo',
                buscar: '',
            }
        },
        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
           
        }, 
    
        methods: {
            listar() {
                let me = this;
                var url = '/donacion/mostrar';
                axios.get(url).then(function(response) {
                        var respuesta = response.data;
                        me.arrayRegistros = respuesta.donacion.data;
                
                    })
                    .catch(function(error) {
                         console.log(me.getID);
                        console.log(error);
                    });
            },
           
           
          
           
                      
            cambiarPagina(page, buscar, criterio) {
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listar(page, buscar, criterio);
            }, 
           
        
        },
        mounted() {
            this.listar();
        }
    }
</script>