<template>
  <div>
    <label for="archiveType">Zip</label>
    <input type="checkbox" name="archiveType" id="archiveType" value="zip">
    <label for="archiveType">Rarr</label>
    <input type="checkbox" name="archiveType" id="archiveType" value="rarr">
    <br>
    <label for="exampleFormControlFile1">Example file input</label>
    <input v-on:change="sync" type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
    <div v-if="image">
      <img v-if="image" :src="image" v-on:click="crop" id="image">
<!--      this.crop()-->
    </div>

    <input v-if="x" type="hidden" name="x" :value="x">
    <input v-if="y" type="hidden" name="y" :value="y">
    <input v-if="width" type="hidden" name="width" :value="width">
    <input v-if="height" type="hidden" name="height" :value="height">
    <input v-if="image" type="submit" value="Отправить">
  </div>

</template>

<script>
    export default {
      data: function (){
        return {
          image: null,
          x: null,
          y: null,
          height: null,
          width: null
        }
      },
      props: [
        'archiveTypes'
      ],
      methods: {
        sync (e) {
          e.preventDefault();
          let fr = new FileReader();
          fr.readAsDataURL(e.target.files[0]);
          new Promise((resolve, reject) => {
            fr.onloadend = function(e) {
              resolve(e.target.result);
            }
          }).then( (resolve) => function (resolve) {
            this.image = resolve;
          }.call(this, resolve))
        },
        crop() {
          const image = document.getElementById('image');
          let vue = this;
          const cropper = new Cropper(image, {
            aspectRatio: 16 / 9,
            crop(event) {
              vue.x = event.detail.x;
              vue.y = event.detail.y;
              vue.width = event.detail.width;
              vue.height = event.detail.height;
            },
          });
        }

      }
    }
</script>
