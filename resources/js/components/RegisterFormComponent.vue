<template>
    <div class="container">
        <form v-on:submit="register">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword2">Name</label>
                <input name="name" type="text" class="form-control" id="exampleInputPassword2" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword3">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
export default {
    methods: {
        register(e) {
            e.preventDefault();

          // this.$store.commit('login');
          // console.log(this.$store.state.auth)

          // this.$router.replace('/login')
          //
          // app.$router.replace('/login');
            axios.post('/api/auth/registration', new FormData(e.target))
                .then( response => {
                  alert('success')
                  this.$router.replace('/login')
                })
                .catch( response => alert('couldnt reg'))
        }
    },
    mounted() {
        // console.log(123)
    }
}
</script>
