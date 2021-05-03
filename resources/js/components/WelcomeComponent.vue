<template>
<div class="container">
  <div id="inspire">
    <div>
      <p class="subtitle-2 text-center">
        Let's optimize
      </p>
      <p class="text-center">
        <router-link :to="{name: 'registerForm'}">Registration</router-link>
        <router-link :to="{name: 'loginForm'}">Login</router-link>
      </p>

    </div>
  </div>
</div>
</template>
<script>
export default {
  data () {
    return {
      text: 'center',
      icon: 'justify',
      toggle_none: null,
      toggle_one: 0,
      toggle_exclusive: 2,
      toggle_multiple: [0, 1, 2],
    }
  },
}

</script>