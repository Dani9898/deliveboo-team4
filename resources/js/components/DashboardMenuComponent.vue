<template>
    <div id="dishes_menu">
    <!-- button to toggle create - form -->
            <div v-if="!createForm && !changeForm" class="d-flex align-items-center m-3">
                <h2 class="m-0">Aggiungi piatti al tuo menu</h2>
                <div class="button-create d-flex align-items-center justify-content-center" @click="createNewDish"><i class="fas fa-plus"></i></div>
            </div>
        
        <!-- dish menu -->
        <section v-if="!createForm && !changeForm" id="menu">
            <h2>I tuoi piatti</h2>      
            <ul v-for="dish in dishes" :key="dish.id">
                <li class="mycard row m-0">
                    <div class="container-card col-sm-10">
                        <div class="dish-img">
                            <!-- <img src="https://picsum.photos/200/200" alt=""> -->
                            <img v-if="dish.dishes_img" :src="'/storage/dishes/' + dish.dishes_img" width="200px">
                            <p v-else>image</p>
                        </div>
                        <div class="card-body">
                            <div class="card-content">
             
                                <div class="details"> 
                                    <h3>{{dish.dish_name}}</h3>
                                    
                                    <p>{{dish.description}}</p>
                                    <p v-for="category in categories" :key="category.id">
                                        <span v-if="category.id === dish.category_id"> Categoria: {{category.category_name}} </span>
                                    </p>
                                    <span>{{dish.price}} &euro;</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mod-container col-sm-2">
                        <div class="modifiers" @click="editDish(dish.id)">
                            <i class="fas fa-pencil-alt"></i> 
                        </div>
                        <div class="modifiers" @click="deleteDish(dish.id)">
                            <i class="fas fa-trash-alt"></i>        
                        </div>
                    </div>
                </li>
            </ul>
        </section>

        <!-- create new dish component -->
        <CreateDishComponent 
        :dishes="dishes"
        :categories="categories"
        v-if="createForm"
        @createNewDish="createNewDish"
        @getNewDishes="getNewDishes"
        />
        
        <!-- edit existing dish - form -->
        <EditDishComponent
        v-if="changeForm"
        :editDishArr="editDishArr"
        :categories="categories"
        @updateDish="updateDish"
        @toggleEditDish="toggleEditDish"
        />
    </div>
</template>

<script>
import CreateDishComponent from './CreateDishComponent.vue';
import EditDishComponent from './EditDishComponent.vue';
export default {
    components: { 
        CreateDishComponent,
        EditDishComponent,
    },
    data: function(){
        return{
            // db data
            dishes: [],
            categories: [],

            // utility
            createForm: false,
            changeForm: false,
            

            // retrive for edit single dish info
            editDishArr: [],  
            dishEdit_id: -1,   
        };
    },

    methods: {

        toStatistics(){
            window.location.href = "/chart/statistics";
        },

        // toggle create - form
        createNewDish() {
            this.createForm = !this.createForm;
        },
        // get new dish from CreateComponent
        getNewDishes(newDishes) {
            this.dishes = newDishes;
        },
        // toggle close edit - form
        toggleEditDish() {
            this.changeForm = !this.changeForm;
        },
        // get selected dish open edit - form
        editDish(id) {
            this.dishEdit_id = id;
            let selectedDish = this.dishes[this.getDishIndById(id)];
            this.editDishArr = selectedDish;
            this.changeForm = !this.changeForm;
        },
        // save updated user img - useful format
        saveUpdatedImg(img) {
            this.editDishes_img = img.target.files[0];
        },
        // update existing dish
        updateDish(dish) {
            let ind = this.getDishIndById(dish.id);
            this.dishes.splice(ind, 1, dish)             
        },
        // delete dish
        deleteDish(id) {
            if(confirm('Sei sicuro di voler eliminare il piatto? Il processo è irreversibile!')) {
                axios.get(`/api/dishDelete/${id}`)
                .then(res => { 
                    const dish = res.data;
                    let dishInd = this.getDishIndById(dish.id);
                    this.dishes.splice(dishInd, 1); 
                })
            }
        },
        // get dish index to delete
        getDishIndById(id){
            for (let i = 0; i < this.dishes.length; i++) {
                const dish = this.dishes[i];
                if (dish.id == id) {
                    return i;
                }
            }
            return -1
        }
    },
    mounted() {
        //  get all dishes
        axios.get('/api/dishes/')
            .then(r=> this.dishes = r.data)
            .catch(e=>console.error(e));
        //  get all dishes category
        axios.get('/api/categories')
            .then(r=> this.categories = r.data)
            .catch(e=>console.error(e));
    },
}
</script>