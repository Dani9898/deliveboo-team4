<template>
  <section id="cart">
    <div class="mobile-cart">
      <div class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
      <ul>
        <li v-for="dish in cart" :key="dish.id" class="chart-object trash">
          <span class="chart-info">
            {{ dish.dish_name }} x
            {{ dish.quantity }}
          </span>
          
          <div @click="removeFromCart(dish)" class="active">
            <span class="chart-info">{{ dish.price }}€</span>
            <i class="fas fa-minus"></i>
          </div>
          <!-- <button @click="removeFromCart(dish)" class="btn btn-danger active">
          delete
        </button> -->
        </li>
      </ul>
    </div>
    <div class="totalPrice">{{ totalPrice }}€</div>
    <div class="buy-button" @click="checkout">
      <div>Vai al pagamento</div>
    </div>
  </section>
</template>

<script>
export default {
  data: function () {
    return {
      total: 0,
    };
  },
  props: {
    cart: Array,
  },
  computed: {
    // get total price of cart items
    totalPrice() {
      let total = 0;
      for (let i = 0; i < this.cart.length; i++) {
        total += this.cart[i].price * this.cart[i].quantity;
      }
      return (this.total = total.toFixed(2));
    },
  },

  methods: {
    onSuccess(payload) {
      let nonce = payload.nonce;
      console.log("successo ", nonce);
      // Do something great with the nonce...
    },
    onError(error) {
      let message = error.message;
      console.log("errore: ", error);
      // Whoops, an error has occured while trying to get the nonce
    },
    // send dish info to parent
    removeFromCart(dish) {
      this.$emit("removeDish", dish);
    },

    checkout() {
      window.location.href = "/api/cart/checkout";
    },
  },
};
</script>