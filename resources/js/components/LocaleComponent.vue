<template>
  <div>
    <div v-on:click="setlocale" lang="ru">ru</div>
    <div v-on:click="setlocale" lang="en">en</div>
  </div>
</template>


<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
      methods: {
          setlocale(e) {
            // console.log($(e.target).attr('lang'))
            axios.get('/set/' + $(e.target).attr('lang')).then((response) => console.log(response));
          }
      }
    }
</script>
