<template>
  <div>
    <label for="archiveType">Zip</label>
    <input type="checkbox" name="archiveType" id="archiveType" value="zip">
    <label for="archiveType">Rarr</label>
    <input type="checkbox" name="archiveType" id="archiveType" value="rarr">
    <br>
    <label for="exampleFormControlFile1">Example file input</label>
    <input v-on:change="sync" type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
    <img v-if="image" :src="image">
<!--    <input @onclick="upload" type="submit" value="Отправить">-->
<!--    <input v-if="image" type="button" v-on:click="upload" value="Отправить">-->
    <input v-if="image" type="submit" value="Отправить">
<!--    <span v-if="is_refresh">uploading</span>-->
  </div>

</template>

<script>
    export default {
      data: function (){
        return {
          image: null,
        }
      },

      props: [
        'archiveTypes'
      ],
      mounted() {
      },
      methods: {
        selectImage (file) {
          this.file = file;
          let reader = new FileReader();
          reader.onload = this.onImageLoad;
          reader.readAsDataURL(file);
        },
        sync (e) {
          e.preventDefault();
          let fr = new FileReader();
          fr.readAsDataURL(e.target.files[0]);
          new Promise((resolve, reject) => {
            fr.onloadend = function(e) {
              resolve(e.target.result);
            }
          }).then((resolve) => this.image = resolve);
        }
      }
    }
</script>
