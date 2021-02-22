
<template>
  <div>
    <main class="p-0">
      <section class="absolute w-full h-full">
        <div class="absolute top-0 w-full h-full" style="background-color: darkslategray;"></div>
        <div class="container mx-auto px-4 h-full">
          <div class="flex content-center items-center justify-center h-full">
            <div class="w-full lg:w-4/12 px-4">
              <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg0 border-0"  >
                <div class="flex-auto px-4 lg:px-10 py-10 pt-0" style="background-color: cornsilk;">
                   <div class="text-gray-500 text-center mb-3 font-bold">
                   <h1 class="text-xl pt-4">Sign in to view your dashboard</h1>
                  </div>
                  <form @submit.prevent="send_form">
                    <div class="relative w-full mb-3">
                      <labeL class="block uppercase text-gray-700 text-xs font-bold mb-2" for="email">Email</label>
                      <input type="email" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full"
                        placeholder="Email" id="email" name="email" style="transition: all 0.15s ease 0s;" v-model="email"/>
                    </div>
                    <div class="relative w-full mb-3">
                      <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="password">Password</label>  
                      <input type="password"  class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full" 
                       placeholder="Password" id="password" name="password"  style="transition: all 0.15s ease 0s;"  v-model="password"  />
                    </div>
                    <div class="text-center mt-6">
                      <button type="submit"
                        class=" text-white  text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full"
                        style="transition: all 0.15s ease 0s; background-color: coral;">
                        Sign In
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>

<script>
  export default {
    name: "Login",
    data: function() {
      return {
          email: '',
          password: '',
      }
  },
  methods: {
      send_form: function (event) {
        axios.post('/login', {
        params: {
                email: email.value,
                password: password.value }
            },).then((response)=>{
         window.location.href= '/nova';
        }).catch((error)=>{
         console.log(error);
       
        });
      }
    }
  }
</script>