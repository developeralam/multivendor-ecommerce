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
      
      <router-view></router-view>
    
      <Newsletter/>
    
      <Footer/>
    
  </div>
</template>