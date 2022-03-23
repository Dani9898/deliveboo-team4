
<template>
  <div class="container" id="check-out">

    <a class="arrow-back" href="javascript:history.back()"><i class="fas fa-arrow-circle-left"></i></a>
    
    <customer-form-component
      @getDishesId="getDishesId"
      @showForm="showForm"
      @showPayment="showPayment"
      @getCustomerData="getCustomerData"
    >
    </customer-form-component>

    <FormErrorComponent
    v-if="validationErrors"
    :errors="validationErrors"
    />

    <!-- PAGAMENTO -->
    <div v-if="showP">
      <div v-if="transition === ''">
        <h2>Riepilogo ordine</h2>
        <div class="contain-dishes">
          <ul class="check-out-dishes">
            <li v-for="dish in cart" :key="dish.id" class="chart-object">
              <span class="chart-info">
                {{ dish.dish_name }}
                X {{ dish.quantity }}
                
              </span>
              <div class="active chart-info">
                <i class="fas fa-plus" @click="addToCart(dish)"></i>
                <i class="fas fa-minus" @click="removeFromCart(dish)"></i>
              </div>
            </li>
          </ul>
          <h4>Prezzo totale:</h4>
          <h3>{{ totalPrice }}&euro;</h3>
        </div>

        <div class="contain-paycheck">
          <v-braintree
            v-if="authorization != ''"
            :authorization="authorization"
            locale="it_IT"
            btnText="Procedi al checkout"
            @success="onSuccess"
            @error="onError"
          ></v-braintree>
        </div>
      </div>
    </div>

    <div class="transition-result" v-if="transition != ''">
      <div v-if="transition == 'Transazione completata' ">
        {{ start() }}
        </div>
      <h2>{{transition}}</h2>
      <button @click="home" class="btn btn-success">HOME</button>
    </div>
  </div>
</template>

<script>
import CustomerFormComponent from "./CustomerFormComponent.vue";
import FormErrorComponent from "./FormErrorComponent.vue";

export default {
  components: {
      "customer-form-component": CustomerFormComponent,
      FormErrorComponent,
  },
  data: function () {
    return {
      validationErrors: '',
      cart: [],
      transition: "",
      authorization: "",
      form: {
        token: "",
        total: "",
      },
      paymetnConfirmation: 1,
      errors: [],

      showF: "",
      showP: false,

      customerData: {},

      a: 1,

      orderInfo: {
        total_price: "",
        payment_confirmation: "",
        date: "",
      },

      dishesId: [],
    };
  },

  computed: {
    // get total price of cart items
    totalPrice() {
      let total = 0;
      for (let i = 0; i < this.cart.length; i++) {
        total += this.cart[i].price * this.cart[i].quantity;
      }
      this.orderInfo.total_price = total;
      return (this.total = total.toFixed(2));
    },
  },
  methods: {
    start () {
      this.$confetti.start()
    },
    getDishesId(e) {
      this.dishesId = e;
      console.log(this.dishesId);
    },

    showForm() {
      this.showF = false;
    },

    showPayment() {
      this.showP = true;
    },

    getCustomerData(info) {
      this.customerData = info;
      console.log(this.customerData);
    },

    home() {
      window.location.href = "/";
    },
    onSuccess(payload) {
      let nonce = payload.nonce;
      this.form.token = nonce;
      this.form.total = this.total;
      this.buy();
    },
    onError(error) {
      // let message = error.message;
      this.paymetnConfirmation = 0;
      console.error(error);
    },
    check() {
      console.log(this.buy);
    },

    async buy() {
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, "0");
      let mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      let yyyy = today.getFullYear();
      today = yyyy + "/" + mm + "/" + dd;

      this.orderInfo.date = today;

      this.dishesId.forEach((id, i) => {
        let newDishProperty = "dish" + i;
        this.orderInfo[newDishProperty] = id;
        let newDishQuantity = "quantity" + i;
        this.orderInfo[newDishQuantity] = this.cart[i].quantity;
      });

      // this.cart.forEach((dish, i) => {
      //     let newDishQuantity = "dish" + i + "quantity";
      //     this.orderInfo[newDishQuantity] = dish.quantity;
      // });

      console.log("orderInfo", this.orderInfo);

      await axios
        .post("/orders/make/payment", this.form)
        .then((res) => {
          sessionStorage.removeItem("cart");
          this.transition = res.data.message;

          if (this.transition === "Transazione completata") {
            this.orderInfo.payment_confirmation = 1;
          } else {
            this.orderInfo.payment_confirmation = 0;
          }
          console.log(this.orderInfo.payment_confirmation);

          console.log("conferma api buy: ", res);
        })
        .catch((err) => {
          this.transition = err.data.message;
          console.error("errore api buy: ", err);
        });

      await axios
        .post("/orders/customerInfo", this.customerData)
        .then((res) => {
          sessionStorage.removeItem("customerData");
          console.log("customer data: ", res);
        })
        .catch((err) => {
          console.error("errore api customer data: ", err);
        });

      await axios
        .post("/orders/createOrder", this.orderInfo)
        .then((res) => {
          // console.log("order info SENZA ERRORE", this.orderInfo);
          // console.log('orderInfo: ', res)
        })
        .catch((err) => {
          console.error("errore api orderInfo: ", err);
          console.log("order info ERRORE", this.orderInfo);
        });
    },

    addToCart(element) {
      const parsed = JSON.stringify(this.cart);
      if (!parsed.includes(`"id":${element.id}`)) {
        element.quantity = 1;
        this.cart.push(element);
      } else {
        for (let i = 0; i < this.cart.length; i++) {
          if (element.id === this.cart[i].id) {
            this.cart[i].quantity++;
            element.quantity = this.cart[i].quantity;
            this.cart.splice(i, 1, element);
          }
        }
      }
      // check cart
      this.cart.length > 0
        ? (this.shoppingCart = true)
        : (this.shoppingCart = false);

      this.saveCart();
    },

    removeFromCart(dish) {
      for (let i = 0; i < this.cart.length; i++) {
        if (dish.id === this.cart[i].id) {
          if (dish.quantity > 1) {
            this.cart[i].quantity--;
            dish.quantity = this.cart[i].quantity;
            this.cart.splice(i, 1, dish);
          } else {
            this.cart.splice(i, 1);
          }
        }
      }
      this.saveCart();
    },
    saveCart() {
      const parsed = JSON.stringify(this.cart);
      sessionStorage.setItem("cart", parsed);
    },
  },

  async mounted() {
    if (sessionStorage.getItem("cart")) {
      try {
        this.cart = JSON.parse(sessionStorage.getItem("cart"));
      } catch (e) {
        sessionStorage.removeItem("cart");
      }
    }

    const response = await axios.get("/orders/generate");
    this.authorization = response.data.token;
    // return {tokenApi: this.authorization.type}
  },
};
</script>
