<script setup>
import { LoginForm } from '@/components';
</script>
<template>
    <section class="user-form-part">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-12 col-lg-12 col-xl-6">
                    <LoginForm/>
                    <div class="user-form-remind">
                        <p>
                            Don't have any account?<router-link :to="{ name: 'user.register' }" class="">register
                                here</router-link>
                        </p>
                    </div>
                    <div class="user-form-footer"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@import '@/assets/css/user-auth.css';
</style>