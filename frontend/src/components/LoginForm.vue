<script setup>
import { ref, reactive, onMounted } from 'vue';
import { storeToRefs } from 'pinia';
import { useAuth, useNotification } from '@/store';
import { Form, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';
import { useRouter, useRoute } from 'vue-router';
const router = useRouter();
const route = useRoute();
const auth = useAuth();
const showPassword = ref(false);
const togglePassword = () => {
    showPassword.value = !showPassword.value;
}
const notify = useNotification();
let schema = yup.object().shape({
    phone: yup.string().required("Phone Is Required"),
    password: yup.string().required("Password Is Required"),
});
const login = async (values, { setErrors, resetForm }) => {
    const res = await auth.login(values);

    if (res.data) {
        resetForm();
        
        notify.success('Login successful');
        if (route.name == 'user.login') {
            router.push({ name: 'index' });
        } else {
            $("#loginModal").modal('hide');
        }
    } else {
        setErrors(res);
    }
}
</script>
<template>
<div class="user-form-card">
    <div class="user-form-title">
        <h2>Customer Login</h2>
        <p>Use your credentials to access</p>
    </div>
    <div class="user-form-group" id="axiosForm">
        <Form class="user-form" @submit="login" :validation-schema="schema" v-slot="{errors, isSubmitting}">
            <!--v-if-->
            <div class="form-group">
                <Field type="text" name="phone" class="form-control" :class="{ 'is-invalid': errors.phone }"
                    placeholder="phone no" /><!--v-if-->
                <ErrorMessage name="phone" class="text-danger" />
            </div>
            <div class="form-group">
                <Field name="password" :type="showPassword ? 'text' : 'password'"
                    :class="errors.password ? 'is-invalid' : ''" class="form-control" placeholder="password" /><span
                    class="view-password" @click="togglePassword"><i class="fas text-success "
                        :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></i></span><!--v-if-->
                <ErrorMessage name="password" class="text-danger" />

            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="check" value=""><label class="form-check-label"
                    for="check">Remember Me</label>
            </div>
            <div class="form-button">
                <button type="submit" :disabled="isSubmitting">login
                    <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
                </button>

                <p v-if="route.name == 'user.login'">
                    Forgot your password?<a href="reset-password.html" class="">reset here</a>
                </p>
                <p v-else>
                    Don't Have Any Account?<router-link :to="{name:'user.register'}" class="">Register</router-link>
                </p>
            </div>
        </Form>
    </div>
</div>
</template>
