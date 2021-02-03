<template>
    <div>
        <nav class="navigation-wrap">
            <router-link :to="{ path: '/' }" class="nav-btn">Погода</router-link>
            <router-link :to="{ path: '/orders' }" class="nav-btn">Список заказов</router-link>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
export default {

}
</script>

<style>
.navigation-wrap {
    padding-bottom: 15px;
    display: flex;  
    width: 1440px;
    margin: 0 auto;
}

.nav-btn {
    margin-right: 20px;
    padding: 10px;
    box-shadow: 0px 0px 5px rgb(0 0 0 / 58%);
    border-radius: 5px;
    text-decoration: none !important;
    color: black;
    display: block;
}

.router-link-exact-active {
    background-color: rgb(109, 36, 81);
    color: white;
}
</style>