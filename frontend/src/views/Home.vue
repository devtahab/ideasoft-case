<template>
    <div class="home">
        <div class="home-header">
            <h1>Sipariş Yönetim Sistemine Hoşgeldiniz!</h1>
            <p>
                İstediğiniz müşteriyi seçtikten sonra ürünleri sepete ekleyin ve checkout kısmında sipariş verin. 
                Laravel kullanarak geliştirilen RESTful API servisini olası senaryolara karşı interaktif bir şekilde test edebilirsiniz.
                <span class="disclaimer">Bu proje <span class="disclaimer-info">ideasoft-case</span> projesi için geliştirilmiştir.</span>
            </p>
            <p>
                Seçmiş olduğunuz kullanıcının geçmiş sipariş verilerine ulaşmak için <RouterLink to="/orders">tıklayınız</RouterLink>.
            </p>
        </div>

        <div class="home-main">
            <h2>Ürünler</h2>
            <div class="products">
                <ProductCard 
                    v-for="product in products"
                    :key="product.id"
                    :product="product"
                />
            </div>
        </div>
    </div>
</template>

<script>
import ProductCard from '@/components/ProductCard.vue';
import axios from 'axios';

export default {
    name: 'Home',

    components: {
        ProductCard
    },

    props: {
        
    },

    data() {
        return {
            products: []
        }
    },

    methods: {

    },

    mounted() {
        axios.get('http://localhost:80/api/products').then((response) => {
            this.products = response.data;
        })
    }
}
</script>

<style scoped>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .home {
        font-family: 'Inter', sans-serif;
    }

    .home .home-header {
        padding: 60px 200px;
        background-color: antiquewhite;
    }

    .home h1 {
        margin-bottom: 30px;
        font-weight: 400;
    }

    .home p .disclaimer {
        font-style: italic;
    }

    .home p .disclaimer .disclaimer-info {
        color: red;
    }

    .home p:nth-of-type(2) {
        margin-top: 18px;
    }

    .home .home-main {
        padding: 0 200px 60px;
        /* background-color: red; */
    }

    .home .home-main h2{
        padding: 30px 0;
        font-weight: 400;
        font-size: 26px;
        font-family: 'Inter', sans-serif;
    }

    .home .home-main .products {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        /* flex-wrap: wrap; */
        gap: 30px;
    }
</style>