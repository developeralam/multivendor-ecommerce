<script setup>
import { useAuth, useNotification } from '@/store'
import { ref, reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router'
import * as yup from 'yup'
import { Form, Field } from 'vee-validate';
const showPassword = ref(false);
const otpVerify = ref(false);
const notify = useNotification();
const auth = useAuth();
const router = useRouter();
const register = async (formData, { setErrors }) => {
    const res = await auth.register(formData);
    if (res.status) {
        otpVerify.value = true;
        setTime(120);
        notify.success('Otp Send Successful')
    } else {
        setErrors(res);
    }
}
const otpFormData = reactive({
    'phone': '',
    'otp': ''
})
const otpSubmit = async (formData, { setErrors }) => {
    const res = await auth.otpVerify(otpFormData);
    if (res.data) {
        router.push({ name: 'index' });
        notify.success('Otp Send Successfully')
    } else {
        setErrors(res);
    }
}
//REsend Otp
const resendOtp = async () => {
    const res = await auth.resendOtp(otpFormData.phone);
    if (res.status) {
        setTime(120);
        notify.success('Otp Send Successfully');
    }
}
const togglePassword = () => {
    showPassword.value = !showPassword.value;
}
let schema = yup.object().shape({
    name: yup.string().required("Name Is Required"),
    email: yup.string().email().required("Email Is Required"),
    phone: yup.string().required("Phone Is Required"),
    password: yup.string().required("Password Is Required").min(8),
    password_confirmation: yup.string().required().min(8)
        .oneOf([yup.ref('password'), null], 'Passwords must match')
});
let schemaOtp = yup.object().shape({
    otp: yup.string().required("Otp Is Required"),
});


// Resend Timer Start
const timeLeft = ref('00:00');
var intervalTimer;
function setTime(seconds) {
    clearInterval(intervalTimer);
    timer(seconds);
}

function timer(seconds) {
    const now = Date.now();
    const end = now + seconds * 1000;
    displayTimeLeft(seconds);
    countdown(end);
}
function countdown(end) {
    // this.initialTime = this.selectedTime;
    intervalTimer = setInterval(() => {
        const secondsLeft = Math.round((end - Date.now()) / 1000);
        if (secondsLeft < 0) {
            clearInterval(intervalTimer);
            return;
        }
        displayTimeLeft(secondsLeft);
    }, 1000);
}

function displayTimeLeft(secondsLeft) {
    const minutes = Math.floor((secondsLeft % 3600) / 60);
    const seconds = secondsLeft % 60;

    timeLeft.value = `${zeroPadded(minutes)}:${zeroPadded(seconds)}`;
}

function zeroPadded(num) {
    return num < 10 ? `0${num}` : num;
}
// Resend Timer End
onMounted(() => {
    $("#loginModal").modal('hide');
})
</script>
<template>
    <section class="user-form-part">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-12 col-lg-12 col-xl-10">
                    <div class="user-form-card">
                        <div class="user-form-title">
                            <h2>Join Now!</h2>
                            <p>Setup A New Account In A Minute</p>
                            <p>{{ timeLeft }}</p>
                        </div>
                        <div class="user-form-group">
                            <ul class="user-form-social">
                                <li>
                                    <a href="#" class="facebook"><i class="fab fa-facebook-f"></i>Join with facebook</a>
                                </li>
                                <li>
                                    <a href="#" class="twitter"><i class="fab fa-twitter"></i>Join with twitter</a>
                                </li>
                                <li>
                                    <a href="#" class="google"><i class="fab fa-google"></i>Join with google</a>
                                </li>
                                <li>
                                    <a href="#" class="instagram"><i class="fab fa-instagram"></i>Join with
                                        instagram</a>
                                </li>
                            </ul>
                            <div class="user-form-divider">
                                <p>or</p>
                            </div>
                            <Form v-if="!otpVerify" class="user-form" @submit="register" :validation-schema="schema"
                                v-slot="{ errors, isSubmitting }">
                                <div class="form-group">
                                    <Field type="text" name="name" class="form-control"
                                        :class="errors.name ? 'is-invalid' : ''" placeholder="Enter your name" />
                                    <span v-if="errors.name" class="text-danger">{{ errors.name }}</span>
                                </div>
                                <div class="form-group">
                                    <Field type="email" name="email" :class="errors.email ? 'is-invalid': ''"
                                        class="form-control" placeholder="Enter your email" />
                                    <span v-if="errors.email" class="text-danger">{{ errors.email }}</span>
                                </div>
                                <div class="form-group">
                                    <Field type="text" name="phone" v-model="otpFormData.phone"
                                        :class="errors.phone ? 'is-invalid': ''" class="form-control"
                                        placeholder="Enter your phone" />
                                    <span v-if="errors.phone" class="text-danger">{{ errors.phone }}</span>
                                </div>
                                <div class="form-group">
                                    <Field :type="showPassword ? 'text' : 'password'" name="password"
                                        :class="errors.password ? 'is-invalid': ''" class="form-control"
                                        placeholder="Enter your password" />
                                    <span class="view-password" @click="togglePassword"><i class="fas text-success "
                                            :class="{ 'fa-eye-slash': showPassword, 'fa-eye':!showPassword}"></i></span>
                                    <span v-if="errors.password" class="text-danger">{{ errors.password }}</span>
                                </div>
                                <div class="form-group">
                                    <Field :type="showPassword ? 'text' : 'password'" name="password_confirmation"
                                        :class="errors.password_confirmation ? 'is-invalid': ''" class="form-control"
                                        placeholder="Enter repeat password" />
                                    <span class="view-password" @click="togglePassword"><i class="fas text-success "
                                            :class="{ 'fa-eye-slash': showPassword, 'fa-eye':!showPassword}"></i></span>
                                    <span v-if="errors.password_confirmation" class="text-danger">{{
                                        errors.password_confirmation }}</span>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="check"><label
                                        class="form-check-label" for="check">Accept all the <a href="#">Terms &amp;
                                            Conditions</a></label>
                                </div>
                                <div class="form-button">
                                    <button :disabled="isSubmitting" type="submit">register <span v-show="isSubmitting"
                                            class="spinner-border spinner-border-sm mr-1"></span></button>
                                </div>
                            </form>
                            <Form v-else class="user-form" @submit="otpSubmit" :validation-schema="schemaOtp"
                                v-slot="{ errors, isSubmitting }">
                                <div class="form-group">
                                    <Field type="text" v-model="otpFormData.otp" name="otp" class="form-control"
                                        :class="errors.otp ? 'is-invalid' : ''" placeholder="Enter your Otp" />
                                    <span v-if="errors.otp" class="text-danger">{{ errors.otp }}</span>
                                </div>
                                <a href="javascript:void(0)" @click="resendOtp" class="float-end" v-if="timeLeft === '00:00'">Resend Otp</a>
                                <a href="javascript:void(0)" class="float-end" v-else>{{timeLeft}}</a>
                                <div class="form-button">
                                    <button :disabled="isSubmitting" type="submit">Verify <span v-show="isSubmitting"
                                            class="spinner-border spinner-border-sm mr-1"></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="user-form-remind">
                        <p>Already Have An Account? <router-link :to="{name:'user.login'}">login here</router-link></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style>
@import '@/assets/css/user-auth.css';
</style>