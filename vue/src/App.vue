<template>
<div class="container" style="margin-top: 40px">
  <div class="row" style=" display: flex; justify-content: center;">
    <div class="col-sm-6" style="margin: 0 auto">
            <form @submit.prevent="">
              <div class="step">
                      <div class="form-group">
                        <label for="phone">Номер телефона</label>
                        <input type="text"
                               class="input-tel form-control" :class="{'notvalid': failedValidation.phone, 'valid': failedValidation.phone===false}"
                               id="phone"
                               v-model="phone"

                               v-on:input="onlyNumbers"
                               placeholder="Введите номер"
                               maxlength="12"
                               minlength="12">
                      </div>

                    <button  @click="secondReg()" ref="getcodder" class="btn btn-primary getcodder">Получить код</button>

                       <div ref="header" class="form-group form-code" >
                            <label for="code">Код</label>
                            <input type="text" class="form-control"  id="code"  v-model="code" v-on:input="enterCode" @keypress="enterCode" placeholder="Введите код">

                      <button type="submit" ref="enter" class="btn btn-primary btn-enter">Войти</button>
                       </div>
              </div>
            </form>
      <div class="showbox" ref="loader" >
        <div class="loader">
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
          </svg>
        </div>
      </div>
    </div>
  </div>
</div>

</template>
<script>
export default {

data() {
  return{
    show: false,
    failedValidation: {
      phone: null
    },
    phone: '',
    code: ''
  }
},
  methods: {
    onlyNumbers() {
      //this.failedValidation.phone = !/^[\d]{10}$/.test(this.phone);
     // console.log(this.phone.slice(1));
      if (this.phone.startsWith('+') && (/[0-9]/.test(this.phone.slice(1))) && (this.phone.slice(1).length == 11) ) {
        this.$refs.getcodder.style = "pointer-events: auto; background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);";
      }
      else {
        this.$refs.getcodder.style = "pointer-events: none; background-image: none";
      }
    },
    secondReg(){
      if( !this.failedValidation.phone ){
        // if (this.phone == 1234567890) {
          this.$refs.loader.style = "display: block";
          setTimeout(() => this.$refs.header.style = "display: block", 2000);
          setTimeout(() => this.$refs.loader.style = "display: none", 2000);
       // }
        // если телефон удачно проверен
      }
      else {
        // если проверка не пройдена
      }
    },
    enterCode() {
      if(this.code == 123) {
        this.$refs.enter.style = "pointer-events: auto; background-image: linear-gradient(to bottom,#337ab7 0,#265a88 100%);";
      }
    },

  }
}
</script>

<style scoped >
.notvalid {border: 1px solid red;}
.valid {border: 1px solid lightgreen;}

</style>
