<template>
    <div class="container">
        <form v-on:submit="register">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
<!--                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">-->
                <input name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
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
      <div>
        <div class="alert alert-danger" role="alert" v-for="error in errors" :key="error[0]">
          {{ error[0] }}
        </div>
      </div>
    </div>
</template>

<script>
export default {
  data: function (){
    return {
      errors: []
    }
  },
    methods: {
        register(e) {
            e.preventDefault();
            axios.post('/graphql',  {
              query: `
                  mutation {
                    registration(
                      email:"${new FormData(e.target).get('email')}",
                      password:"${new FormData(e.target).get('password')}"
                      name:"${new FormData(e.target).get('name')}"
                      )
                  }
                  `
            })
                .then( response => {
                  if (response.data.errors) {
                    this.errors = response.data.errors[0].extensions.validation;
                  } else {
                    this.$router.replace('/login');
                  }
                  // alert('success')
                  // this.$router.replace('/login')
                })
                // .catch( response => alert('couldnt reg'))
        }
    },
    mounted() {
        // console.log(123)
    }
}
</script>
