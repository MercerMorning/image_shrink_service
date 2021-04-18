<template>
  <ul id="example-1">
    <li v-for="message in messages">
      {{ message }}
    </li>
  </ul>
</template>

<script>
export default {
    methods: {
      data: function (){
        return {
          messages: []
        }
      },

        // login(e) {
        //     e.preventDefault();
        //     // axios.post('/graphql/auth/login', new FormData(e.target))
        //     // axios.post('/graphql', new FormData(e.target))
        //     axios.post('/graphql',  {
        //         query: `
        //           mutation {
        //             login(email:"${new FormData(e.target).get('email')}", password:"${new FormData(e.target).get('password')}")
        //           }
        //           `
        //       })
        //         .then( response => {
        //           // let result = new FormData(e.target);
        //           // console.log(response.data.data.login);
        //
        //           // console.log(response.data.login);
        //
        //           this.$store.commit('login', response.data.data.login);
        //
        //           // // alert(this.$store.getters.isLoggedIn);
        //           // alert('done log!')
        //           // alert(this.$store.getters.Token)
        //           this.$router.replace('/messages')
        //         })
        //         // .catch( response => alert('couldnt log'))
        //         .catch( response =>  console.log(response))
        // }
    },
    mounted() {
        // console.log('Component mounted.')
    }
}
</script>
