<template>
  <div>
    <ul v-if="messages">
      <li v-for="message in this.messages">
          {{ message.content }}
      </li>
    </ul>
    <input type="text" v-on:change="send">
  </div>

</template>

<script>
    export default {
      data: function (){
        return {
          messages: [],
          textMessage: ''
        }
      },
      methods: {
        send(e) {
          axios.post('/graphql', {
            query: `
                  mutation {
                    createMessage(content:"blablabla", user_id:1) {
                        id
                    }
                  }
                  `
          })
              .then(response => console.log(response))
              .catch(response => console.log(response))
        }
      },
        mounted() {
          axios.post('/graphql', {
            query: `{
                     messages {
                        content
                    }
                  }
                  `
          })
              .then(response => {
                // console.log(response.data.data.messages);
                this.messages = response.data.data.messages
              })
              // .catch( response => alert('couldnt log'))
              .catch(response => console.log(33))
        }
      }
</script>
