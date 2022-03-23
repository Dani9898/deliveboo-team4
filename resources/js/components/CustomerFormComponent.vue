
<template>
     <div class="login-register" >


        
         
         

         <p v-if="showForm" class="text-order">Inserisci i tuoi dati per procedere al pagamento dell'ordine</p>
         <form
         v-if="showForm"
         method="POST" 
         enctype="multipart/form-data" 
         @submit.prevent="infoCustomer" class="customer-form">

            <label for="name">Name</label>
                <input type="text" name="name" min="2" maxlength="60" v-model="name"  required 
                onkeypress="return /[a-zA-Z\u00C0-\u00FF\u0020]/i.test(event.key) ">
            

            <label for="surname">Cognome</label>
                <input type="text" name="surname" min="2" maxlength="60" v-model="surname"  required
                onkeypress="return /[a-zA-Z\u00C0-\u00FF\u0020]/i.test(event.key)">
            

            <label for="email">Email</label>
                <input type="email" name="email" min="2" maxlength="60" v-model="email"  required>
            

            <label for="address">Address</label>
                <input type="text" name="address" min="5" maxlength="60" v-model="address"  required>
            

            <label for="cap">CAP</label>             
                <input type="text" name="cap" min="5" maxlength="5" v-model="cap"  required 
                    onkeypress="return event.charCode>=48 && event.charCode<=57">
            

            <label for="telephone">Telefono</label>
                <input type="text" name="telephone" maxlength="20" v-model="telephone"  required 
                    onkeypress="return event.charCode>=48 && event.charCode<=57">  

            <label for="note">
                Note
                <textarea name="note" rows="5" maxlength="255" v-model="note" class="text-area" placeholder="Note al ristorante..."></textarea>
            </label>

            <input type="submit" value="Procedi al pagamento" class="blocktonone login-button">
            <input type="submit" value="Paga" class="nonetoblock login-button">
         </form>
    </div>

</template>

<script>
import FormErrorComponent from "./FormErrorComponent.vue";
export default {
    props:{
        paymetnConfirmation: Number
    },
    data: function() {
        return {
            // errors: [],

            customerForm: {
                name: "",
                surname: "",
                email: "",
                address: "",
                note: "",
                cap: "",
                telephone: "",
            },

            name: "",
            surname: "",
            email: "",
            address: "",
            note: "",
            cap: "",
            telephone: "",
            showForm: true,
            showPayment: false,


            dishesId: [],
            cart: [],
        }
    },

    components: {
        FormErrorComponent,
    },

 mounted() {
    if(sessionStorage.getItem('customerData')) {
        const storageCustomerData = JSON.parse(sessionStorage.getItem('customerData'));
        this.name = storageCustomerData.name;
        this.surname = storageCustomerData.surname;
        this.email = storageCustomerData.email;
        this.address = storageCustomerData.address;
        this.note = storageCustomerData.note;
        this.cap = storageCustomerData.cap;
        this.telephone = storageCustomerData.telephone;
    }

    if (sessionStorage.getItem('cart')) {
        try {
            this.cart = JSON.parse(sessionStorage.getItem('cart'));
        } catch(e) {
            sessionStorage.removeItem('cart');
        }
    }    

    console.log("cart", this.cart);
},

    methods: {
        infoCustomer() {
            this.showForm = false;

            this.customerForm.name = this.name;
            this.customerForm.surname = this.surname;
            this.customerForm.email = this.email;
            this.customerForm.address = this.address;
            this.customerForm.note = this.note;
            this.customerForm.cap = this.cap;
            this.customerForm.telephone = this.telephone;

            const parsed = JSON.stringify(this.customerForm);
            sessionStorage.setItem('customerData', parsed);

            this.cart.forEach(dish => {
                console.log("dish",dish.id);
                this.dishesId.push(dish.id);
            });
            console.log("ids", this.dishesId);

            this.$emit("getDishesId", this.dishesId);
            this.$emit("showForm");
            this.$emit("showPayment");
            this.$emit("getCustomerData", this.customerForm);
        },
    }       
}
</script>
