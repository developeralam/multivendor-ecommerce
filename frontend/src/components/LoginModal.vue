<script setup>
  import { LoginForm } from '@/components';
</script>
<template>
  <div>
    <div class="modal fade" id="loginModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <button class="modal-close icofont-close" data-bs-dismiss="modal"></button>
            <div class="product-view">
              <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                  <LoginForm/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</template>
<style scoped>
@import '@/assets/css/user-auth.css';
</style>