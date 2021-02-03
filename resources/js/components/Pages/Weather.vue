<template>
    <div>
        <div class="weather-content">
            <div class="weather-widget" v-if="!loading">
                <div class="city-name">
                    <div>
                        {{ city_name }}
                    </div>
                    <div>
                        <img class="weather-icon" :src="icon_url">
                    </div>               
                </div>
                <div class="weather-value">
                    <div>
                        {{ temperature }}
                    </div>
                    <div class="sign">
                        °C  
                    </div>
                </div>
            </div>
            <div v-else>
                Загрузка ...
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            city_name: "",
            temperature: "",
            icon_url: "",
            loading: true,
        }
    },
    mounted() {
        axios.get('/api/get_weather').then((response) => 
        {
            this.city_name = response.data.city;
            this.temperature = response.data.temperature;
            this.icon_url = "https://yastatic.net/weather/i/icons/blueye/color/svg/" + response.data.weather_icon + ".svg";
            this.loading = false;
        });
    }
}
</script>

<style>
.weather-icon {
    margin-left: 10px;
    display: block;
    height: 50px;
}

.weather-content {
    width: 1440px;
    margin: 0 auto;
}

.weather-value span {
    font-size: 15px;
    font-weight: bold;
}

.weather-value {
    display: flex;
    font-size: 40px;
    line-height: 40px;
    color: rgb(107, 107, 107);
}

.weather-value .sign {
    font-size: 15px;
    line-height: 35px;
    margin-left: 5px;
}

.weather-widget {
    font-family: "Raleway" !important;
    padding: 20px;
    width: 320px;
    background: rgb(255, 255, 255);
    border-radius: 5px;
    box-shadow: 0px 0px 8px rgb(0 0 0 / 20%);
}

.weather-widget .city-name {
    align-items: center;
    font-size: 30px;
    margin-bottom: 10px;
    font-weight: 800;
    display: flex;
}
</style>