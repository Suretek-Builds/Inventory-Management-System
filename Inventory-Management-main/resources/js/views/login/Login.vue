<template>
  <div class="login-screen">
    <div class="container-fluid">
      <div class="row justify-content-center ">
        <div class="col-md-6 p-0 login-filds-area d-flex align-items-center">
          <div class="login-filds border-0 align-items-center ">

            <div class="form-title">
              <h3>log in</h3>
              <p>Are you trying to log into an account?</p>
            </div>
            <div class="">
              <form @submit.prevent="submitLogin">
                <div class="">
                  <!-- Email -->
                  <div class="mb-3">
                    <!-- <label for="email" class="form-label">{{ $t('email') }}</label> -->
                    <div class="fl-icon">
                      <input v-model="loginForm.email" id="email" type="email" class="form-control" autofocus autocomplete="username" placeholder="Email">
                      <div class="icons">
                        <img src="images/email.svg">
                      </div>
                    </div>
                    <!-- Validation Errors -->
                    <div class="text-danger mt-1">
                      <div v-for="message in validationErrors?.email">
                        {{ message }}
                      </div>
                    </div>
                  </div>
                  <!-- Password -->
                  <div class="mb-4">
                    <!-- <label for="password" class="form-label">
                        {{ $t('password') }}
                    </label> -->

                    <div class="fl-icon">
                      <input v-model="loginForm.password" id="password" type="password" class="form-control" autocomplete="current-password" placeholder="Password">
                      <div class="icons">
                        <img src="images/hidden.svg">
                      </div>
                    </div>

                    <!-- Validation Errors -->
                    <div class="text-danger mt-1">
                      <div v-for="message in validationErrors?.password">
                        {{ message }}
                      </div>
                    </div>
                  </div>
                  <!-- Remember me -->
                  <div class="form-check">

                    <input class="form-check-input" type="checkbox" name="remember" v-model="loginForm.remember" id="flexCheckIndeterminate">

                    <label class="form-check-label" for="flexCheckIndeterminate">
                      {{ $t('remember_me') }}
                    </label>
                  </div>

                  <!-- Buttons -->
                  <div class="flex items-center justify-end mt-4">
                    <button class="btn login-btn btn-primary" :class="{ 'opacity-25': processing }" :disabled="processing">
                      {{ $t('login') }}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6 p-0">
          <div class="right-side-bg d-flex align-items-center">

            <img src="images/deh-login.png" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import useAuth from '@/composables/auth'

const { loginForm, validationErrors, processing, submitLogin } = useAuth();

</script>
