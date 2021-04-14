<template>
    <div class="container">
        Login
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>
        <form v-on:submit="login">
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
        login(e) {
            e.preventDefault();
            axios.post('/api/auth/login', new FormData(e.target))
                .then( response => {
                  this.$store.commit('login');
                  // alert(this.$store.getters.isLoggedIn);
                  alert('done log!')
                  this.$router.replace('/optimize')
                })
                .catch( response => alert('couldnt log'))
        }
    },
    mounted() {
        // console.log('Component mounted.')
    }
}
</script>
