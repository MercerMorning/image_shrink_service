<template>
  <form v-on:submit="send" >
      <div class="input-group mb-3">
          <div class="input-group-prepend">
              <label class="input-group-text" for="archiveType">Zip</label>
          </div>
          <div class="input-group-prepend">
              <div class="input-group-text">
                  <input type="checkbox" name="archiveType" id="archiveType" value="zip" aria-label="Checkbox for following text input">
              </div>
          </div>
      </div>
      <input v-on:change="sync" type="file" name="image" class="form-control-file" id="exampleFormControlFile">
<!--    <div v-if="effect">-->
<!--      <input v-on:change="effecter" type="checkbox" name="effect" value="blur">blur-->
<!--    </div>-->

    <div v-if="image">
      <img v-if="image" :src="image" v-on:click="crop" id="image">
    </div>

    <input v-if="x" type="hidden" name="x" :value="x">
    <input v-if="y" type="hidden" name="y" :value="y">
    <input v-if="width" type="hidden" name="width" :value="width">
    <input v-if="height" type="hidden" name="height" :value="height">
    <input v-if="effect" type="hidden" name="effect" :value="effect">

<!--    <input v-if="image" type="submit" value="Отправить">-->
    <input type="submit" value="Отправить">

  </form>

</template>

<script>
    export default {
      data: function (){
        return {
          effect: null,
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
          send(e) {
              e.preventDefault();
              // console.log( new FormData(e.target).get('image'));
              axios.post('/api', new FormData(e.target))
                  .then(function (data) {
                      console.log(data.headers['content-type']);
                      const downloadUrl = window.URL.createObjectURL(new Blob([data.data], {type: 'attachment; filename="' + data.headers.filename + '"'}));
                      const link = document.createElement('a');
                      link.href = downloadUrl;
                      // link.setAttribute('download', data.headers.filename); //any other extension
                      link.setAttribute('download', 'file.png'); //any other extension
                      document.body.appendChild(link);
                      link.click();
                      link.remove();
                  })
                  .catch(function (resp) {
                      console.log(resp);
                      alert("Couldnt optimize image");
                  });
          },
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
          this.effect = true;
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
        },
        effecter(e) {
          this.effect = $(e.target).attr('value');
          if ($(e.target).attr('value') == 'blur') {
            $('.cropper-hide').css({'filter' : 'blur(10px)'});
          }
        }
      }
    }
</script>
