<script setup>
import { Header, Navbar, CartSidebar, MobileMenu, Newsletter, Footer, LoginModal } from '@/components';
</script>
<template>
  <div>
      <div class="backdrop"></div>
      <a class="backtop fas fa-arrow-up" href="#"></a>
      
      <Header/>
    
      <Navbar/>

      <CartSidebar />
      
      <MobileMenu/>
    
      <LoginModal/>
      <router-view v-slot="{ Component }">
        <transition name="fade">
          <component :is="Component" />
        </transition>
      </router-view>
      <!-- <router-view></router-view> -->
    
      <Newsletter/>
    
      <Footer/>
      <LoginModal/>
  </div>
</template>
<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>